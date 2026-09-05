// Design Brief — the form that opens a design job.
//
// Three things happen here beyond plain typing: the design code is composed
// from province + number + design type, an engine picked from the catalogue
// fills in its own power and rpm, and the shaft figures follow from those.
document.querySelectorAll('[data-design-brief]').forEach((form) => {
	const root = form.closest('section') ?? document;
	const enginesJson = root.querySelector('[data-db-engines-data]')?.textContent ?? '[]';
	const catalogue = JSON.parse(enginesJson);
	const template = root.querySelector('[data-db-engine-template]');
	const holder = form.querySelector('[data-db-engines]');
	const STORAGE_KEY = `lasan-design-brief:${location.pathname}`;

	/* ---------------------------------------------------------- design code */

	const codeInput = form.querySelector('[data-db-code]');
	const province = form.querySelector('[name="province"]');
	const designType = form.querySelector('[name="design_type"]');

	// The middle number is the only part a person types, so it is kept and the
	// ends are rewritten around it.
	const middleOf = (value) => {
		const parts = String(value || '').split('-');
		return parts.length >= 3 ? parts.slice(1, -1).join('-') : '';
	};

	const syncCode = () => {
		if (!codeInput) return;
		const head = province?.value || '';
		const tail = designType?.value || '';
		if (!head && !tail) return;
		codeInput.value = [head, middleOf(codeInput.value) || '000000', tail].join('-');
	};
	province?.addEventListener('change', syncCode);
	designType?.addEventListener('change', syncCode);

	/* -------------------------------------------------------------- tiền tệ */

	const money = form.querySelector('[data-db-money]');
	money?.addEventListener('blur', () => {
		const digits = money.value.replace(/\D/g, '');
		money.value = digits ? Number(digits).toLocaleString('vi-VN') : '';
	});

	/* --------------------------------------------------------------- engines */

	const round = (n, digits) => {
		const f = 10 ** digits;
		return Math.round(n * f) / f;
	};

	/** Wire one engine block: catalogue lookups and the shaft calculation. */
	const initEngine = (engine) => {
		const make = engine.querySelector('[data-db-make]');
		const model = engine.querySelector('[data-db-model]');
		const kw = engine.querySelector('[data-db-kw]');
		const rpm = engine.querySelector('[data-db-rpm]');
		const ratio = engine.querySelector('[data-db-ratio]');
		const material = engine.querySelector('[data-db-material]');
		const k3 = engine.querySelector('[data-db-k3]');
		const propRpm = engine.querySelector('[data-db-prop-rpm]');
		const dmin = engine.querySelector('[data-db-dmin]');

		const fillModels = (keep) => {
			if (!model) return;
			const models = catalogue.filter((row) => row.make === make?.value);
			model.replaceChildren(new Option('— Chọn mã hiệu —', ''));
			models.forEach((row) => {
				const option = new Option(row.model, row.model);
				option.dataset.kw = row.kw;
				option.dataset.rpm = row.rpm;
				model.append(option);
			});
			if (keep) model.value = keep;
		};

		// n = n_e / i, then d = k₃ · ∛(P/n) — the same formula as the Shaft
		// Diameter tool, so the two never disagree.
		const compute = () => {
			const power = Number(kw?.value);
			const engineRpm = Number(rpm?.value);
			const gear = Number(ratio?.value);
			const coefficient = Number(k3?.value);

			const n = engineRpm > 0 && gear > 0 ? engineRpm / gear : 0;
			if (propRpm) propRpm.value = n > 0 ? round(n, 1) : '';
			if (dmin) {
				dmin.value = n > 0 && power > 0 && coefficient > 0 ? Math.round(coefficient * Math.cbrt(power / n)) : '';
			}
		};

		make?.addEventListener('change', () => {
			fillModels('');
			compute();
		});
		model?.addEventListener('change', () => {
			const option = model.selectedOptions[0];
			if (option?.dataset.kw && kw) kw.value = option.dataset.kw;
			if (option?.dataset.rpm && rpm) rpm.value = option.dataset.rpm;
			compute();
		});
		material?.addEventListener('change', () => {
			const option = material.selectedOptions[0];
			if (option?.dataset.k3 && k3) k3.value = option.dataset.k3;
			compute();
		});
		[kw, rpm, ratio, k3].forEach((el) => el?.addEventListener('input', compute));

		engine.querySelector('[data-db-remove-engine]')?.addEventListener('click', () => {
			if (holder.querySelectorAll('[data-db-engine]').length < 2) return;
			engine.remove();
			renumber();
		});

		fillModels(model?.value);
		compute();
	};

	/** Engine blocks are numbered in the legend and in every field name. */
	const renumber = () => {
		holder.querySelectorAll('[data-db-engine]').forEach((engine, i) => {
			const label = engine.querySelector('[data-db-engine-no]');
			if (label) label.textContent = String(i + 1);
			engine.querySelectorAll('[name]').forEach((el) => {
				const base = el.name.replace(/^engine\d+__/, '');
				el.name = `engine${i + 1}__${base}`;
				const id = `db-engine${i + 1}-${base}`;
				const bound = engine.querySelector(`label[for="${el.id}"]`);
				el.id = id;
				if (bound) bound.htmlFor = id;
			});
		});
		holder.querySelectorAll('[data-db-remove-engine]').forEach((button) => {
			button.hidden = holder.querySelectorAll('[data-db-engine]').length < 2;
		});
	};

	const addEngine = () => {
		if (!template || !holder) return null;
		const engine = template.content.firstElementChild.cloneNode(true);
		holder.append(engine);
		renumber();
		initEngine(engine);
		return engine;
	};

	form.querySelector('[data-db-add-engine]')?.addEventListener('click', () => {
		addEngine()?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
	});

	/* ----------------------------------------------------- draft on this pc */

	const saved = form.querySelector('[data-db-saved]');

	const readDraft = () => {
		try {
			return JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
		} catch {
			return {};
		}
	};

	const writeDraft = () => {
		const data = { engines: holder.querySelectorAll('[data-db-engine]').length, fields: {} };
		form.querySelectorAll('[name]').forEach((el) => {
			if (el.value) data.fields[el.name] = el.value;
		});
		try {
			localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
			if (saved) saved.hidden = false;
		} catch {
			/* private window: the form still works, it just will not remember */
		}
	};

	const restore = () => {
		const draft = readDraft();
		const count = Math.max(1, Number(draft.engines) || 1);
		for (let i = 0; i < count; i += 1) addEngine();
		if (!draft.fields) return;

		// Selects first: an engine make has to be set before its models exist.
		Object.entries(draft.fields).forEach(([name, value]) => {
			const el = form.querySelector(`[name="${CSS.escape(name)}"]`);
			if (el && el.tagName === 'SELECT') {
				el.value = value;
				el.dispatchEvent(new Event('change'));
			}
		});
		Object.entries(draft.fields).forEach(([name, value]) => {
			const el = form.querySelector(`[name="${CSS.escape(name)}"]`);
			if (el && el.tagName !== 'SELECT') el.value = value;
		});
		holder.querySelectorAll('[data-db-engine]').forEach((engine) => {
			engine.querySelector('[data-db-ratio]')?.dispatchEvent(new Event('input'));
		});
		if (saved) saved.hidden = false;
	};

	form.addEventListener('input', writeDraft);
	form.addEventListener('change', writeDraft);
	form.addEventListener('reset', () => {
		window.setTimeout(() => {
			try {
				localStorage.removeItem(STORAGE_KEY);
			} catch {
				/* nothing to clear */
			}
			holder.replaceChildren();
			addEngine();
			if (saved) saved.hidden = true;
		});
	});

	/* ------------------------------------------------------------- xuất bản */

	// Plain text, grouped by the form's own sections, so it can be pasted
	// straight into an email or a document.
	const asText = () => {
		const lines = [];
		form.querySelectorAll('fieldset').forEach((section) => {
			const title = section.querySelector('legend')?.textContent.trim();
			const rows = [];
			section.querySelectorAll('[name]').forEach((el) => {
				const value = String(el.value || '').trim();
				if (!value) return;
				const label = section.querySelector(`label[for="${el.id}"]`)?.textContent.trim() || el.name;
				const unit = el.closest('.db__control')?.querySelector('.db__unit')?.textContent.trim() || '';
				rows.push(`  ${label}: ${value}${unit ? ' ' + unit : ''}`);
			});
			if (rows.length) lines.push(title, ...rows, '');
		});
		return lines.join('\n');
	};

	form.querySelector('[data-db-copy]')?.addEventListener('click', async (event) => {
		const button = event.currentTarget;
		try {
			await navigator.clipboard.writeText(asText());
		} catch {
			return;
		}
		button.classList.add('is-copied');
		window.setTimeout(() => button.classList.remove('is-copied'), 1600);
	});

	form.querySelector('[data-db-print]')?.addEventListener('click', () => window.print());

	// Contact Form 7 does the sending. The brief is written into its hidden
	// fields and its own submit button is clicked, so mail, validation and the
	// response message all stay CF7's job.
	const cf7 = root.querySelector('[data-db-cf7] form');
	form.querySelector('[data-db-send]')?.addEventListener('click', () => {
		if (!cf7) return;
		const value = (name) => form.querySelector(`[name="${name}"]`)?.value.trim() ?? '';
		const put = (cf7Name, text) => {
			const field = cf7.querySelector(`[name="${cf7Name}"]`);
			if (field) field.value = text;
		};

		put('brief-code', value('design_code') || value('vessel_no') || '—');
		put('brief-customer', value('customer_name'));
		put('brief-vessel', value('vessel_no'));
		put('brief-email', value('customer_email'));
		put('brief-body', asText());

		cf7.querySelector('.wpcf7-submit')?.click();
		root.querySelector('[data-db-cf7]')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
	});

	restore();
});
