// Design Brief — the brief as data, with no DOM.
//
// The form's state is two kinds of scope: the global one, and one per engine.
// A scope is { values: {base: string}, codes: {base: string}, picked: {base: label} }.
// Field names in the brief's JSON are the base name for global fields and
// `engine{n}__{base}` for engine ones, numbered by position — the same keys
// the old DOM-based script produced, so earlier drafts still restore.
import { propellerRpm, shaftDiameter } from '../shaft';
import { round } from '../format';

export const newScope = () => ({ values: {}, codes: {}, picked: {} });

export const engineName = (index, base) => `engine${index + 1}__${base}`;

/** Fields computed from others; read-only on the form. */
export function computed(scope, base) {
	const v = scope.values;
	const n = propellerRpm(Number(v.engine_rpm), Number(v.gear_ratio));
	if (base === 'prop_rpm') return n ? String(round(n, 1)) : '';
	if (base === 'shaft_dmin') {
		const d = n ? shaftDiameter(Number(v.engine_kw), n, Number(v.k3)) : null;
		return d ? String(Math.round(d)) : '';
	}
	return undefined;
}

export function valueOf(scope, base) {
	const c = computed(scope, base);
	return c !== undefined ? c : String(scope.values[base] ?? '');
}

/** The catalogue code behind a value when one was picked, else the words typed. */
export const codeOf = (scope, base) => scope.codes[base] || valueOf(scope, base).trim();

/* ---- design code ---------------------------------------------------------- */

// Tỉnh – số – Loại hình thiết kế. The middle number is the only part a person
// types, so it is kept and the ends are rewritten around it.
export const middleOf = (value) => {
	const parts = String(value || '').split('-');
	return parts.length >= 3 ? parts.slice(1, -1).join('-') : '';
};

export function composeCode(current, head, tail) {
	if (!head && !tail) return null;
	return [head, middleOf(current) || '000000', tail].join('-');
}

/* ---- walking the form ----------------------------------------------------- */

/**
 * Every field in document order: global sections, and the engine block
 * repeated inside the engines section.
 * visit({ section, engineIndex, row, field, scope, name })
 */
export function walk(schema, global, engines, visit) {
	for (const section of schema.sections) {
		if (section.engines) {
			engines.forEach((scope, engineIndex) => {
				for (const group of schema.engine) {
					for (const row of group.rows) {
						for (const field of row.fields) {
							visit({ section, engineIndex, row, field, scope, name: engineName(engineIndex, field.name) });
						}
					}
				}
			});
			continue;
		}
		for (const row of section.rows) {
			for (const field of row.fields) {
				visit({ section, engineIndex: null, row, field, scope: global, name: field.name });
			}
		}
	}
}

/**
 * One object, no tables: every filled field by name, plus the labels and
 * units needed to read it back. The same shape is the draft on this machine
 * and the payload posted to the company.
 */
export function collect(schema, global, engines, { now = new Date(), url = '' } = {}) {
	const out = { fields: {}, labels: {}, units: {}, texts: {}, codes: {} };
	walk(schema, global, engines, ({ field, scope, name }) => {
		const value = valueOf(scope, field.name).trim();
		if (!value) return;
		out.fields[name] = value;
		out.labels[name] = field.label || name;
		out.texts[name] = value;
		if (field.unit) out.units[name] = field.unit;
		if (scope.codes[field.name]) out.codes[name] = scope.codes[field.name];
	});
	return { generated_at: now.toISOString(), url, engines: engines.length, ...out };
}

/** Rebuild the scopes from a draft written by collect(). */
export function restore(schema, draft) {
	const global = newScope();
	const count = Math.max(1, Number(draft?.engines) || 1);
	const engines = Array.from({ length: count }, newScope);
	if (!draft?.fields) return { global, engines };

	walk(schema, global, engines, ({ field, scope, name }) => {
		const value = draft.fields[name];
		if (value === undefined || computed(scope, field.name) !== undefined) return;
		scope.values[field.name] = String(value);
		const code = draft.codes?.[name];
		if (code) {
			scope.codes[field.name] = code;
			scope.picked[field.name] = String(value);
		}
	});
	return { global, engines };
}

/* ---- outline: what was answered, in the form's own structure -------------- */

// Sections → blocks (one per engine, or the section itself) → titled rows.
// Both the plain-text copy and the printed document are written from this,
// so the two never disagree.
export function outline(schema, global, engines, engineLabel = 'Máy') {
	const groupsOf = (rows, scope) =>
		rows
			.map((row) => ({
				title: row.title || '',
				rows: row.fields
					.map((f) => ({ label: f.label || f.name, value: valueOf(scope, f.name).trim(), unit: f.unit || '' }))
					.filter((r) => r.value !== ''),
			}))
			.filter((g) => g.rows.length);

	return schema.sections
		.map((section) => {
			const blocks = section.engines
				? engines.map((scope, i) => ({
						title: `${engineLabel} ${i + 1}`,
						groups: groupsOf(
							schema.engine.flatMap((g) => g.rows),
							scope,
						),
					}))
				: [{ title: '', groups: groupsOf(section.rows, global) }];
			return { title: section.title, blocks: blocks.filter((b) => b.groups.length) };
		})
		.filter((s) => s.blocks.length);
}

export function asText(sections) {
	const lines = [];
	sections.forEach((section) => {
		lines.push(section.title.toUpperCase());
		section.blocks.forEach((block) => {
			if (block.title) lines.push(`  ${block.title}`);
			block.groups.forEach((group) => {
				if (group.title) lines.push(`  · ${group.title}`);
				group.rows.forEach((row) => lines.push(`    ${row.label}: ${row.value}${row.unit ? ` ${row.unit}` : ''}`));
			});
		});
		lines.push('');
	});
	return lines.join('\n');
}

/** Engine models for whatever is in the make box, typed or picked. */
export function modelsFor(catalogue, make) {
	const m = String(make || '').trim().toLowerCase();
	if (!m) return [];
	return catalogue
		.filter((row) => row.make.toLowerCase() === m)
		.map((row) => ({ value: row.model, label: row.model, data: { kw: row.kw, rpm: row.rpm } }));
}

/** "1234567" → "1.234.567" on blur of the fee field. */
export function formatMoney(value) {
	const digits = String(value || '').replace(/\D/g, '');
	return digits ? Number(digits).toLocaleString('vi-VN') : '';
}
