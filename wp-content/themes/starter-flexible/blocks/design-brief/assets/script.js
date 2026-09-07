// Design Brief — the form that opens a design job.
//
// Four things happen here beyond plain typing: the design code is composed
// from province + number + design type, an engine picked from the catalogue
// fills in its own power and rpm, the shaft figures follow from those, and the
// whole brief is printed as an administrative document (Nghị định 30/2020).
//
// The brief is never split into records: it is one JSON object of whatever was
// typed, keyed by field name — kept in localStorage while it is written and
// posted through Contact Form 7 when it is sent.
document.querySelectorAll('[data-design-brief]').forEach((form) => {
	const root = form.closest('section') ?? document;
	const readJson = (selector, fallback) => {
		try {
			return JSON.parse(root.querySelector(selector)?.textContent || fallback);
		} catch {
			return JSON.parse(fallback);
		}
	};
	const catalogue = readJson('[data-db-engines-data]', '[]');
	const letterhead = readJson('[data-db-doc-data]', '{}');
	const template = root.querySelector('[data-db-engine-template]');
	const holder = form.querySelector('[data-db-engines]');
	const STORAGE_KEY = `lasan-design-brief:${location.pathname}`;

	/* ------------------------------------------------------------- fields */

	// Every control sits in a `[data-db-field]` wrapper carrying its name,
	// label and unit. A field is either a plain box or a combo: a box with the
	// catalogue underneath it, where clicking an entry types it in for you.
	// Nothing is locked to a list, so a tỉnh or a máy that is not in the
	// catalogue is simply typed.

	const wrappers = (scope = form) => [...scope.querySelectorAll('[data-db-field]')];
	const inputOf = (wrap) => wrap.querySelector('input, textarea');

	/** What was typed, or what a preset typed in. */
	const valueOf = (wrap) => inputOf(wrap)?.value ?? '';
	const textOf = valueOf;

	/** The catalogue code behind the current value, when one was picked. */
	const codeOf = (wrap) => wrap.dataset.code || valueOf(wrap).trim();

	const setValue = (wrap, value) => {
		const el = inputOf(wrap);
		if (!el) return false;
		el.value = value;
		return true;
	};

	const wrapOf = (name, scope = form) => scope.querySelector(`[data-db-field][data-name="${CSS.escape(name)}"]`);
	const named = (name, scope = form) => {
		const wrap = wrapOf(name, scope);
		return wrap ? valueOf(wrap).trim() : '';
	};
	const namedCode = (name, scope = form) => {
		const wrap = wrapOf(name, scope);
		return wrap ? codeOf(wrap).trim() : '';
	};

	/** One catalogue entry, built for the engine models that arrive with a make. */
	const preset = (label, code, data = {}) => {
		const button = document.createElement('button');
		button.type = 'button';
		button.className = 'db__preset';
		button.dataset.value = label;
		button.dataset.code = code;
		Object.entries(data).forEach(([key, val]) => {
			button.dataset[key] = val;
		});
		button.textContent = label;
		return button;
	};

	// One listener for every catalogue on the form: fill the box above, remember
	// the code behind it, and let the field's own `change` handlers run.
	form.addEventListener('click', (event) => {
		const button = event.target.closest('.db__preset');
		if (!button || !form.contains(button)) return;
		const wrap = button.closest('[data-db-field]');
		const el = inputOf(wrap);
		if (!el) return;
		el.value = button.dataset.value ?? '';
		wrap.dataset.code = button.dataset.code ?? el.value;
		wrap.dataset.picked = button.dataset.value ?? '';
		el.dispatchEvent(new Event('input', { bubbles: true }));
		el.dispatchEvent(new Event('change', { bubbles: true }));
		markPicked(wrap);
	});

	// Typing by hand drops the remembered code: the words are the value now.
	form.addEventListener('input', (event) => {
		const wrap = event.target.closest('[data-db-field]');
		if (!wrap || !wrap.classList.contains('db__field--combo')) return;
		if (wrap.dataset.picked !== event.target.value) {
			delete wrap.dataset.code;
			delete wrap.dataset.picked;
		}
		markPicked(wrap);
	});

	/** Show which entry the box currently holds. */
	const markPicked = (wrap) => {
		const value = valueOf(wrap).trim();
		wrap.querySelectorAll('.db__preset').forEach((button) => {
			button.classList.toggle('is-picked', button.dataset.value === value);
		});
	};

	/* ---------------------------------------------------------- design code */

	const codeInput = form.querySelector('[data-db-code]');

	// The middle number is the only part a person types, so it is kept and the
	// ends are rewritten around it.
	const middleOf = (value) => {
		const parts = String(value || '').split('-');
		return parts.length >= 3 ? parts.slice(1, -1).join('-') : '';
	};

	const syncCode = () => {
		if (!codeInput) return;
		const head = namedCode('province');
		const tail = namedCode('design_type');
		if (!head && !tail) return;
		codeInput.value = [head, middleOf(codeInput.value) || '000000', tail].join('-');
	};

	form.addEventListener('change', (event) => {
		if (['province', 'design_type'].includes(event.target.name)) syncCode();
	});
	form.addEventListener('input', (event) => {
		if (['province', 'design_type'].includes(event.target.name)) syncCode();
	});

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
		const makeWrap = wrapOf('engine_make', engine) ?? engine.querySelector('[data-db-make]');
		const modelWrap = wrapOf('engine_model', engine) ?? engine.querySelector('[data-db-model]');
		const materialWrap = wrapOf('shaft_material', engine) ?? engine.querySelector('[data-db-material]');
		const kw = engine.querySelector('[data-db-kw]');
		const rpm = engine.querySelector('[data-db-rpm]');
		const ratio = engine.querySelector('[data-db-ratio]');
		const k3 = engine.querySelector('[data-db-k3]');
		const propRpm = engine.querySelector('[data-db-prop-rpm]');
		const dmin = engine.querySelector('[data-db-dmin]');

		// The models offered follow whatever is in the make box, typed or picked.
		const fillModels = () => {
			if (!modelWrap) return;
			const list = modelWrap.querySelector('[data-db-presets]');
			if (!list) return;
			const make = (makeWrap ? valueOf(makeWrap) : '').trim().toLowerCase();
			const rows = make ? catalogue.filter((row) => row.make.toLowerCase() === make) : [];
			if (!rows.length) {
				const empty = document.createElement('p');
				empty.className = 'db__presets-empty';
				empty.textContent = make
					? 'Không có mã hiệu nào cho hãng này — nhập tay ở ô trên.'
					: 'Nhập hoặc chọn hãng ở trên để thấy danh sách mã hiệu.';
				list.replaceChildren(empty);
				return;
			}
			list.replaceChildren(...rows.map((row) => preset(row.model, row.model, { kw: row.kw, rpm: row.rpm })));
			markPicked(modelWrap);
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

		makeWrap?.addEventListener('input', () => {
			fillModels();
			compute();
		});
		// Picking a model brings its power and rpm with it; typing one does not,
		// because a machine outside the catalogue has no figures to carry.
		modelWrap?.addEventListener('click', (event) => {
			const button = event.target.closest('.db__preset');
			if (!button) return;
			if (button.dataset.kw && kw) kw.value = button.dataset.kw;
			if (button.dataset.rpm && rpm) rpm.value = button.dataset.rpm;
			compute();
		});
		materialWrap?.addEventListener('click', (event) => {
			const button = event.target.closest('.db__preset');
			if (button?.dataset.k3 && k3) k3.value = button.dataset.k3;
			compute();
		});
		[kw, rpm, ratio, k3].forEach((el) => el?.addEventListener('input', compute));

		engine.querySelector('[data-db-remove-engine]')?.addEventListener('click', () => {
			if (holder.querySelectorAll('[data-db-engine]').length < 2) return;
			engine.remove();
			renumber();
			writeDraft();
		});

		fillModels();
		compute();
	};

	/** Engine blocks are numbered in the legend and in every field name. */
	const renumber = () => {
		const engines = [...holder.querySelectorAll('[data-db-engine]')];
		engines.forEach((engine, i) => {
			const no = i + 1;
			const legend = engine.querySelector('[data-db-engine-no]');
			if (legend) legend.textContent = String(no);

			wrappers(engine).forEach((wrap) => {
				const base = wrap.dataset.name.replace(/^engine\d+__/, '');
				const name = `engine${no}__${base}`;
				const id = `db-${name}`;
				wrap.dataset.name = name;

				const control = inputOf(wrap);
				if (control) {
					control.name = name;
					control.id = id;
				}
				const label = wrap.querySelector(':scope > .field__label');
				if (label) label.htmlFor = id;
			});
		});
		engines.forEach((engine) => {
			engine.querySelector('[data-db-remove-engine]').hidden = engines.length < 2;
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
		const engine = addEngine();
		writeDraft();
		engine?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
	});

	/* ----------------------------------------------------------- the brief */

	// One object, no tables: every field that was filled in, by name, plus the
	// labels and units needed to read it back. The same shape is the draft on
	// this machine and the payload posted to the company.
	const collect = () => {
		const fields = {};
		const labels = {};
		const units = {};
		const texts = {};
		const codes = {};

		wrappers().forEach((wrap) => {
			const value = String(valueOf(wrap)).trim();
			if (!value) return;
			const name = wrap.dataset.name;
			fields[name] = value;
			labels[name] = wrap.dataset.label || name;
			texts[name] = textOf(wrap).trim();
			if (wrap.dataset.unit) units[name] = wrap.dataset.unit;
			if (wrap.dataset.code) codes[name] = wrap.dataset.code;
		});

		return {
			generated_at: new Date().toISOString(),
			url: location.href,
			engines: holder.querySelectorAll('[data-db-engine]').length,
			fields,
			labels,
			units,
			texts,
			codes,
		};
	};

	/* ----------------------------------------------------- draft on this pc */

	const saved = form.querySelector('[data-db-saved]');

	// Restoring writes to every control in turn; the draft is only rewritten
	// once at the end, so a half-applied form never overwrites a whole one.
	let restoring = false;

	const readDraft = () => {
		try {
			return JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
		} catch {
			return {};
		}
	};

	const writeDraft = () => {
		if (restoring) return;
		try {
			localStorage.setItem(STORAGE_KEY, JSON.stringify(collect()));
			if (saved) saved.hidden = false;
		} catch {
			/* private window: the form still works, it just will not remember */
		}
	};

	const restore = () => {
		const draft = readDraft();
		restoring = true;
		try {
			const count = Math.max(1, Number(draft.engines) || 1);
			for (let i = 0; i < count; i += 1) addEngine();

			// In document order, so an engine make is restored — and its models
			// built — before the model that depends on it.
			wrappers().forEach((wrap) => {
				const value = draft.fields?.[wrap.dataset.name];
				if (value === undefined || !setValue(wrap, value)) return;
				if (draft.codes?.[wrap.dataset.name]) {
					wrap.dataset.code = draft.codes[wrap.dataset.name];
					wrap.dataset.picked = value;
				}
				markPicked(wrap);
				inputOf(wrap)?.dispatchEvent(new Event('input', { bubbles: true }));
			});
			holder.querySelectorAll('[data-db-ratio]').forEach((el) => el.dispatchEvent(new Event('input', { bubbles: true })));
		} finally {
			restoring = false;
		}
		if (saved) saved.hidden = !draft.fields;
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
			wrappers().forEach((wrap) => {
				delete wrap.dataset.code;
				delete wrap.dataset.picked;
				markPicked(wrap);
			});
			holder.replaceChildren();
			addEngine();
			if (saved) saved.hidden = true;
		});
	});

	/* ------------------------------------------------------------- outline */

	// The form's own structure, filtered down to what was answered: sections
	// (a fieldset), blocks (one engine, or the section itself) and the titled
	// rows inside them. Both the plain-text copy and the printed document are
	// written from this, so the two never disagree.

	const groupsOf = (scope) =>
		[...scope.querySelectorAll('.db__row-group')]
			.map((group) => ({
				title: group.querySelector(':scope > .db__row-title')?.textContent.trim() ?? '',
				rows: wrappers(group)
					.map((wrap) => ({
						label: wrap.dataset.label || wrap.dataset.name,
						value: textOf(wrap).trim(),
						unit: wrap.dataset.unit || '',
					}))
					.filter((row) => row.value !== ''),
			}))
			.filter((group) => group.rows.length);

	const outline = () =>
		[...form.querySelectorAll('.db__section')]
			.map((section) => {
				const title = section.querySelector('.db__legend')?.textContent.trim() ?? '';
				const engines = [...section.querySelectorAll('[data-db-engine]')];
				const blocks = engines.length
					? engines.map((engine, i) => ({ title: `Máy ${i + 1}`, groups: groupsOf(engine) }))
					: [{ title: '', groups: groupsOf(section) }];
				return { title, blocks: blocks.filter((block) => block.groups.length) };
			})
			.filter((section) => section.blocks.length);

	/* ------------------------------------------------------------- xuất bản */

	const asText = () => {
		const lines = [];
		outline().forEach((section) => {
			lines.push(section.title.toUpperCase());
			section.blocks.forEach((block) => {
				if (block.title) lines.push(`  ${block.title}`);
				block.groups.forEach((group) => {
					if (group.title) lines.push(`  · ${group.title}`);
					group.rows.forEach((row) => {
						lines.push(`    ${row.label}: ${row.value}${row.unit ? ' ' + row.unit : ''}`);
					});
				});
			});
			lines.push('');
		});
		return lines.join('\n');
	};

	// navigator.clipboard only exists in a secure context, which a site served
	// over plain http is not, so a hidden textarea stands in for it.
	const copy = async (text) => {
		try {
			await navigator.clipboard.writeText(text);
			return true;
		} catch {
			/* fall through */
		}
		const scratch = document.createElement('textarea');
		scratch.value = text;
		scratch.setAttribute('readonly', '');
		scratch.style.cssText = 'position:fixed;top:0;left:-9999px;opacity:0';
		document.body.append(scratch);
		scratch.select();
		let done = false;
		try {
			done = document.execCommand('copy');
		} catch {
			done = false;
		}
		scratch.remove();
		return done;
	};

	form.querySelector('[data-db-copy]')?.addEventListener('click', async (event) => {
		const button = event.currentTarget;
		if (!(await copy(asText()))) return;
		button.classList.add('is-copied');
		window.setTimeout(() => button.classList.remove('is-copied'), 1600);
	});

	/* ---------------------------------------------- văn bản hành chính (in) */

	// Printed to the layout of Nghị định 30/2020: quốc hiệu and tiêu ngữ on the
	// right, the issuing body and document number on the left, the name of the
	// document, the body in Roman-numbered parts, then nơi nhận and the two
	// signatures. Rendered into an off-screen iframe so the page's own styling
	// never reaches the paper.

	const esc = (value) =>
		String(value ?? '').replace(/[&<>"]/g, (ch) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' })[ch]);

	const ROMAN = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

	const longDate = (date) => `ngày ${String(date.getDate()).padStart(2, '0')} tháng ${date.getMonth() + 1} năm ${date.getFullYear()}`;

	const documentHtml = () => {
		const today = new Date();
		const org = letterhead.org || 'CÔNG TY TNHH LASAN MARINE';
		const place = letterhead.place || '';
		const symbol = letterhead.symbol || 'NVT';
		const number = named('request_no') || '......';
		const code = named('design_code');
		const customer = named('customer_name');
		const vessel = named('vessel_no');
		const requestDate = named('request_date');

		const contact = [letterhead.address, letterhead.phone && `ĐT: ${letterhead.phone}`, letterhead.email]
			.filter(Boolean)
			.join(' · ');

		const grounds = [
			`Căn cứ Đơn đề nghị thiết kế số ${esc(number)}${requestDate ? ` ngày ${esc(requestDate)}` : ''}${customer ? ` của ${esc(customer)}` : ''};`,
			'Căn cứ Quy chuẩn kỹ thuật quốc gia về phân cấp và đóng tàu cá hiện hành;',
			'Căn cứ số liệu khảo sát thực tế và thoả thuận giữa hai bên,',
		].join('<br />');

		const body = outline()
			.map((section, i) => {
				const blocks = section.blocks
					.map((block) => {
						const groups = block.groups
							.map((group) => {
								const rows = group.rows
									.map(
										(row) =>
											`<tr><td class="k">${esc(row.label)}</td><td class="v">${esc(row.value)}${row.unit ? ' ' + esc(row.unit) : ''}</td></tr>`
									)
									.join('');
								return `${group.title ? `<h4>${esc(group.title)}</h4>` : ''}<table class="spec">${rows}</table>`;
							})
							.join('');
						return `${block.title ? `<h3>${esc(block.title)}</h3>` : ''}${groups}`;
					})
					.join('');
				return `<section class="part"><h2>${ROMAN[i] ?? i + 1}. ${esc(section.title.toUpperCase())}</h2>${blocks}</section>`;
			})
			.join('');

		return `<!doctype html>
<html lang="vi"><head><meta charset="utf-8" />
<title>Nhiệm vụ thư thiết kế${code ? ' ' + esc(code) : ''}</title>
<style>
@page { size: A4; margin: 20mm 15mm 20mm 30mm; }
* { box-sizing: border-box; }
body { margin: 0; font-family: "Times New Roman", Times, serif; font-size: 13pt; line-height: 1.45; color: #000; }
p { margin: 0 0 6pt; }
.head { width: 100%; border-collapse: collapse; margin-bottom: 12pt; }
.head td { vertical-align: top; padding: 0; }
.head .left { width: 42%; text-align: center; }
.head .right { width: 58%; text-align: center; }
.org, .nation { font-weight: bold; text-transform: uppercase; font-size: 12pt; }
.nation { font-size: 12pt; }
.motto { font-weight: bold; font-size: 13pt; }
.rule { width: 60%; margin: 3pt auto 6pt; border-bottom: 1px solid #000; }
.rule--wide { width: 78%; }
.no { font-size: 12pt; }
.place { font-style: italic; font-size: 13pt; }
.contact { font-size: 10pt; font-style: italic; }
h1 { margin: 16pt 0 4pt; font-size: 14pt; text-align: center; text-transform: uppercase; }
.subject { text-align: center; font-style: italic; margin-bottom: 14pt; }
.grounds { font-style: italic; margin-bottom: 10pt; }
.part { margin-bottom: 10pt; page-break-inside: auto; }
h2 { font-size: 13pt; margin: 12pt 0 4pt; text-transform: uppercase; }
h3 { font-size: 13pt; margin: 8pt 0 3pt; font-style: italic; }
h4 { font-size: 13pt; margin: 6pt 0 2pt; font-weight: normal; font-style: italic; }
table.spec { width: 100%; border-collapse: collapse; margin: 0 0 4pt; }
table.spec td { border: 1px solid #000; padding: 3pt 6pt; vertical-align: top; }
table.spec td.k { width: 45%; }
table.spec tr { page-break-inside: avoid; }
.sign { width: 100%; border-collapse: collapse; margin-top: 18pt; page-break-inside: avoid; }
.sign td { width: 50%; vertical-align: top; text-align: center; padding: 0; }
.sign .role { font-weight: bold; text-transform: uppercase; }
.sign .hint { font-style: italic; font-size: 12pt; }
.sign .space { height: 60pt; }
.recipients { margin-top: 14pt; font-size: 11pt; }
.recipients .title { font-weight: bold; font-style: italic; }
</style></head>
<body>
<table class="head"><tr>
	<td class="left">
		<p class="org">${esc(org)}</p>
		<div class="rule"></div>
		<p class="no">Số: ${esc(number)}/${esc(symbol)}</p>
	</td>
	<td class="right">
		<p class="nation">Cộng hòa xã hội chủ nghĩa Việt Nam</p>
		<p class="motto">Độc lập - Tự do - Hạnh phúc</p>
		<div class="rule rule--wide"></div>
		<p class="place">${place ? esc(place) + ', ' : ''}${longDate(today)}</p>
	</td>
</tr></table>

<h1>Nhiệm vụ thư thiết kế</h1>
<p class="subject">${[code && `Ký hiệu thiết kế: ${esc(code)}`, vessel && `Số đăng ký: ${esc(vessel)}`].filter(Boolean).join(' — ') || '&nbsp;'}</p>

<p class="grounds">${grounds}</p>
<p>Hai bên thống nhất nội dung nhiệm vụ thư thiết kế như sau:</p>

${body}

<table class="sign"><tr>
	<td>
		<p class="role">Chủ tàu / Khách hàng</p>
		<p class="hint">(Ký, ghi rõ họ tên)</p>
		<div class="space"></div>
		<p>${esc(customer)}</p>
	</td>
	<td>
		<p class="role">Đơn vị thiết kế</p>
		<p class="hint">(Ký, ghi rõ họ tên, đóng dấu)</p>
		<div class="space"></div>
		<p>${esc(named('handler'))}</p>
	</td>
</tr></table>

<div class="recipients">
	<p class="title">Nơi nhận:</p>
	<p>- Chủ tàu (để thực hiện);<br />- Trung tâm đăng kiểm (để biết);<br />- Lưu: VT, hồ sơ thiết kế.</p>
	${contact ? `<p class="contact">${esc(contact)}</p>` : ''}
</div>
</body></html>`;
	};

	// An off-screen iframe rather than window.print(): the sheet is the
	// document above, not the page around the form, and no popup is opened.
	const printDocument = (html) => {
		const frame = document.createElement('iframe');
		frame.setAttribute('aria-hidden', 'true');
		frame.style.cssText = 'position:fixed;right:0;bottom:0;width:0;height:0;border:0;visibility:hidden';
		frame.srcdoc = html;
		frame.addEventListener(
			'load',
			() => {
				const view = frame.contentWindow;
				let removed = false;
				const drop = () => {
					if (removed) return;
					removed = true;
					frame.remove();
				};
				view.addEventListener('afterprint', () => window.setTimeout(drop, 200), { once: true });
				window.setTimeout(drop, 60000);
				view.focus();
				view.print();
			},
			{ once: true }
		);
		document.body.append(frame);
	};

	form.querySelector('[data-db-print]')?.addEventListener('click', () => printDocument(documentHtml()));

	// Contact Form 7 does the sending. The brief is written into its hidden
	// fields and its own submit button is clicked, so mail, validation and the
	// response message all stay CF7's job. brief-json carries the whole thing.
	const cf7 = root.querySelector('[data-db-cf7] form');
	form.querySelector('[data-db-send]')?.addEventListener('click', () => {
		if (!cf7) return;
		const put = (cf7Name, text) => {
			const field = cf7.querySelector(`[name="${cf7Name}"]`);
			if (field) field.value = text;
		};

		put('brief-code', named('design_code') || named('vessel_no') || '—');
		put('brief-customer', named('customer_name'));
		put('brief-vessel', named('vessel_no'));
		put('brief-email', named('customer_email'));
		put('brief-body', asText());
		put('brief-json', JSON.stringify(collect(), null, 2));

		cf7.querySelector('.wpcf7-submit')?.click();
		root.querySelector('[data-db-cf7]')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
	});

	restore();
});
