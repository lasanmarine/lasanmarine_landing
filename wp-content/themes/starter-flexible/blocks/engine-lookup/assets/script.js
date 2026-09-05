/**
 * A searchable, multi-select popover over a list of strings. The trigger reads
 * like a <select>; the panel holds a filter box and one checkbox per option.
 */
function setupMultiSelect(el, { noneFound, onChange }) {
	const trigger = el.querySelector('[data-ms-trigger]');
	const pop = el.querySelector('[data-ms-pop]');
	const searchInput = el.querySelector('[data-ms-search]');
	const list = el.querySelector('[data-ms-list]');
	const note = el.querySelector('[data-ms-note]');
	const value = el.querySelector('[data-ms-value]');
	const clear = el.querySelector('[data-ms-clear]');
	const placeholder = el.dataset.msPlaceholder ?? '';
	const more = el.dataset.msMore ?? 'và %d khác';
	const countOnly = el.dataset.msCount ?? '%d';

	const selected = new Set();
	let options = [];

	const labelFor = (names, shown) => {
		const rest = names.length - shown;
		if (shown === 0) return countOnly.replace('%d', String(names.length));
		const head = names.slice(0, shown).join(', ');
		return rest > 0 ? `${head} ${more.replace('%d', String(rest))}` : head;
	};

	// How many names fit is a question only the rendered box can answer, so the
	// label is written longest-first and shortened until it stops overflowing.
	const updateValue = () => {
		const picked = [...selected];
		trigger.classList.toggle('is-empty', picked.length === 0);
		if (picked.length === 0) {
			value.textContent = placeholder;
			return;
		}
		for (let shown = picked.length; shown >= 0; shown -= 1) {
			value.textContent = labelFor(picked, shown);
			// A hidden or not-yet-laid-out box measures 0 — take the first
			// candidate rather than collapsing all the way to the count.
			if (value.clientWidth === 0 || value.scrollWidth <= value.clientWidth) return;
		}
	};

	const renderList = () => {
		const q = (searchInput?.value ?? '').trim().toLowerCase();
		const shown = options.filter((option) => !q || option.toLowerCase().includes(q));

		if (shown.length === 0) {
			const blank = document.createElement('p');
			blank.className = 'pc__multi-empty';
			blank.textContent = noneFound;
			list.replaceChildren(blank);
			return;
		}

		list.replaceChildren(
			...shown.map((option) => {
				const row = document.createElement('label');
				row.className = 'pc__multi-option';
				const box = document.createElement('input');
				box.type = 'checkbox';
				box.value = option;
				box.checked = selected.has(option);
				const text = document.createElement('span');
				text.textContent = option;
				row.append(box, text);
				box.addEventListener('change', () => {
					if (box.checked) selected.add(option);
					else selected.delete(option);
					updateValue();
					onChange();
				});
				return row;
			}),
		);
	};

	const close = () => {
		pop.hidden = true;
		trigger.setAttribute('aria-expanded', 'false');
	};
	const open = () => {
		pop.hidden = false;
		trigger.setAttribute('aria-expanded', 'true');
		searchInput?.focus();
	};

	trigger.addEventListener('click', () => (pop.hidden ? open() : close()));
	// The label is width-dependent, so it is rewritten whenever the box resizes.
	if ('ResizeObserver' in window) new ResizeObserver(updateValue).observe(trigger);
	searchInput?.addEventListener('input', renderList);
	clear?.addEventListener('click', () => {
		selected.clear();
		updateValue();
		renderList();
		onChange();
	});
	el.addEventListener('keydown', (event) => {
		if (event.key !== 'Escape' || pop.hidden) return;
		close();
		trigger.focus();
	});
	document.addEventListener('click', (event) => {
		if (!pop.hidden && !el.contains(event.target)) close();
	});

	return {
		selected,
		/** Swap the option list, dropping any selection that is no longer offered. */
		setOptions(next, { keepSelection = false } = {}) {
			options = next;
			if (!keepSelection) {
				[...selected].filter((item) => !next.includes(item)).forEach((item) => selected.delete(item));
			}
			updateValue();
			renderList();
		},
		setNote(text) {
			if (!note) return;
			note.textContent = text ?? '';
			note.hidden = !text;
		},
		reset() {
			selected.clear();
			if (searchInput) searchInput.value = '';
			updateValue();
			renderList();
		},
	};
}

const COPY_ICONS =
	'<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="pc__copy-icon" style="flex:none" aria-hidden="true"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>' +
	'<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="pc__copy-icon pc__copy-icon--done" style="flex:none" aria-hidden="true"><path d="M21.801 10A10 10 0 1 1 17 3.335"></path><path d="m9 11 3 3L22 4"></path></svg>';

/**
 * A copy button for one table value. Numbers are copied bare, in the machine's
 * locale, so pasting into a spreadsheet lands on the decimal mark it expects.
 */
function copyButton(value, label) {
	const text =
		typeof value === 'number'
			? value.toLocaleString(undefined, { maximumFractionDigits: 6, useGrouping: false })
			: String(value);

	const button = document.createElement('button');
	button.type = 'button';
	button.className = 'pc__copy el__copy';
	button.setAttribute('aria-label', `${label}: ${text}`);
	button.innerHTML = COPY_ICONS;
	button.addEventListener('click', async () => {
		try {
			await navigator.clipboard.writeText(text);
		} catch {
			return;
		}
		button.classList.add('is-copied');
		window.clearTimeout(button._copyTimeout);
		button._copyTimeout = window.setTimeout(() => button.classList.remove('is-copied'), 1400);
	});
	return button;
}

document.querySelectorAll('[data-engines]').forEach((root) => {
	const rowsJson = root.querySelector('[data-el-rows]')?.textContent;
	if (!rowsJson) return;

	const all = JSON.parse(rowsJson);
	const perPage = Number(root.dataset.perPage) || 12;
	const modelSample = Number(root.dataset.modelSample) || 8;
	const modelHint = root.dataset.modelHint ?? '';
	const noneFound = root.dataset.noneFound ?? '';
	const copyLabel = root.dataset.copyLabel ?? 'Sao chép';

	const body = root.querySelector('[data-el-body]');
	const empty = root.querySelector('[data-el-empty]');
	const pager = root.querySelector('[data-el-pager]');
	const search = root.querySelector('[data-el-search]');

	let sortKey = 'make';
	let sortDir = 1;
	let page = 0;

	const byName = (a, b) => a.localeCompare(b);

	// A range input is only a bound once it holds a number; its unit select
	// carries the factor back to the dataset's units (kW, rpm).
	const bound = (valueSelector, unitSelector) => {
		const raw = root.querySelector(valueSelector)?.value ?? '';
		if (raw.trim() === '') return null;
		const value = Number(raw);
		if (!Number.isFinite(value)) return null;
		const factor = Number(root.querySelector(unitSelector)?.value);
		return value * (factor > 0 ? factor : 1);
	};

	const inRange = (value, min, max) => {
		if (typeof value !== 'number' || !Number.isFinite(value)) return min === null && max === null;
		if (min !== null && value < min) return false;
		if (max !== null && value > max) return false;
		return true;
	};

	const filtered = () => {
		const q = (search?.value ?? '').trim().toLowerCase();
		const kwMin = bound('[data-el-kw-min]', '[data-el-kw-unit]');
		const kwMax = bound('[data-el-kw-max]', '[data-el-kw-unit]');
		const rpmMin = bound('[data-el-rpm-min]', '[data-el-rpm-unit]');
		const rpmMax = bound('[data-el-rpm-max]', '[data-el-rpm-unit]');
		const makes = multis.make?.selected ?? new Set();
		const models = multis.model?.selected ?? new Set();

		return all
			.filter((e) => (!q ? true : `${e.make} ${e.model} ${e.kw} ${e.rpm}`.toLowerCase().includes(q)))
			.filter((e) => (makes.size === 0 ? true : makes.has(e.make)))
			.filter((e) => (models.size === 0 ? true : models.has(e.model)))
			.filter((e) => inRange(e.kw, kwMin, kwMax))
			.filter((e) => inRange(e.rpm, rpmMin, rpmMax))
			.sort((a, b) => {
				const x = a[sortKey];
				const y = b[sortKey];
				if (typeof x === 'number' && typeof y === 'number') return (x - y) * sortDir;
				return String(x).localeCompare(String(y)) * sortDir;
			});
	};

	const render = () => {
		const rows = filtered();
		const pages = Math.max(Math.ceil(rows.length / perPage), 1);
		page = Math.min(page, pages - 1);
		const slice = rows.slice(page * perPage, page * perPage + perPage);

		if (body) {
			body.replaceChildren(
				...slice.map((e) => {
					const tr = document.createElement('tr');
					for (const value of [e.make, e.model, e.kw, e.rpm]) {
						const td = document.createElement('td');
						const cell = document.createElement('div');
						cell.className = 'el__cell';
						const blank = value === null || value === undefined || value === '';
						const text = document.createElement('span');
						text.textContent = blank ? '—' : String(value);
						cell.append(text);
						if (!blank) cell.append(copyButton(value, copyLabel));
						td.append(cell);
						tr.append(td);
					}
					return tr;
				}),
			);
		}

		const count = root.querySelector('[data-el-count]');
		if (count) count.textContent = String(rows.length);
		if (empty) empty.hidden = rows.length > 0;
		if (pager) pager.hidden = rows.length <= perPage;
		const label = root.querySelector('[data-el-page]');
		if (label) label.textContent = `${page + 1} / ${pages}`;
		root.querySelector('[data-el-prev]').disabled = page === 0;
		root.querySelector('[data-el-next]').disabled = page >= pages - 1;
	};

	const rerender = () => {
		page = 0;
		render();
	};

	const multis = {};
	root.querySelectorAll('[data-ms]').forEach((el) => {
		multis[el.dataset.ms] = setupMultiSelect(el, {
			noneFound,
			onChange: () => {
				if (el.dataset.ms === 'make') refreshModels();
				rerender();
			},
		});
	});

	// Every model, sorted, once a make narrows the list — otherwise a random
	// handful, so the field shows what kind of thing lives in there.
	const refreshModels = () => {
		if (!multis.model) return;
		const makes = multis.make?.selected ?? new Set();
		const models = [
			...new Set(all.filter((e) => (makes.size === 0 ? true : makes.has(e.make))).map((e) => e.model)),
		].sort(byName);

		if (makes.size > 0) {
			multis.model.setOptions(models);
			multis.model.setNote('');
			return;
		}

		const pool = [...models];
		for (let i = pool.length - 1; i > 0; i -= 1) {
			const j = Math.floor(Math.random() * (i + 1));
			[pool[i], pool[j]] = [pool[j], pool[i]];
		}
		// The sample is only what is listed — a model picked earlier stays
		// selected even when it falls outside it.
		multis.model.setOptions(pool.slice(0, modelSample).sort(byName), { keepSelection: true });
		multis.model.setNote(modelHint);
	};

	multis.make?.setOptions([...new Set(all.map((e) => e.make))].sort(byName));
	refreshModels();

	root.querySelectorAll('[data-el-sort]').forEach((btn) => {
		btn.addEventListener('click', () => {
			const key = btn.dataset.elSort;
			sortDir = key === sortKey && sortDir === 1 ? -1 : 1;
			sortKey = key;
			root.querySelectorAll('th').forEach((th) => th.removeAttribute('aria-sort'));
			btn.closest('th')?.setAttribute('aria-sort', sortDir === 1 ? 'ascending' : 'descending');
			rerender();
		});
	});

	[
		search,
		root.querySelector('[data-el-kw-min]'),
		root.querySelector('[data-el-kw-max]'),
		root.querySelector('[data-el-rpm-min]'),
		root.querySelector('[data-el-rpm-max]'),
	].forEach((el) => el?.addEventListener('input', rerender));

	[root.querySelector('[data-el-kw-unit]'), root.querySelector('[data-el-rpm-unit]')].forEach((el) =>
		el?.addEventListener('change', rerender),
	);

	root.querySelector('[data-el-reset]')?.addEventListener('click', () => {
		if (search) search.value = '';
		root
			.querySelectorAll('[data-el-kw-min], [data-el-kw-max], [data-el-rpm-min], [data-el-rpm-max]')
			.forEach((input) => {
				input.value = '';
			});
		root.querySelectorAll('[data-el-kw-unit], [data-el-rpm-unit]').forEach((select) => {
			select.selectedIndex = 0;
		});
		multis.make?.reset();
		multis.model?.reset();
		refreshModels();
		rerender();
	});

	root.querySelector('[data-el-prev]')?.addEventListener('click', () => {
		page = Math.max(page - 1, 0);
		render();
	});
	root.querySelector('[data-el-next]')?.addEventListener('click', () => {
		page += 1;
		render();
	});

	render();
});
