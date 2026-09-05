document.querySelectorAll('[data-engines]').forEach((root) => {
	const rowsJson = root.querySelector('[data-el-rows]')?.textContent;
	if (!rowsJson) return;

	const all = JSON.parse(rowsJson);
	const perPage = Number(root.dataset.perPage) || 12;

	const body = root.querySelector('[data-el-body]');
	const empty = root.querySelector('[data-el-empty]');
	const pager = root.querySelector('[data-el-pager]');
	const search = root.querySelector('[data-el-search]');
	const make = root.querySelector('[data-el-make]');
	const min = root.querySelector('[data-el-min]');

	let sortKey = 'make';
	let sortDir = 1;
	let page = 0;

	const filtered = () => {
		const q = (search?.value ?? '').trim().toLowerCase();
		const m = make?.value ?? '';
		const floor = Number(min?.value);

		return all
			.filter((e) => (!q ? true : `${e.make} ${e.model}`.toLowerCase().includes(q)))
			.filter((e) => (!m ? true : e.make === m))
			.filter((e) => (Number.isFinite(floor) && floor > 0 ? e.kw >= floor : true))
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
						td.textContent = value === null || value === undefined || value === '' ? '—' : String(value);
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

	root.querySelectorAll('[data-el-sort]').forEach((btn) => {
		btn.addEventListener('click', () => {
			const key = btn.dataset.elSort;
			sortDir = key === sortKey && sortDir === 1 ? -1 : 1;
			sortKey = key;
			root.querySelectorAll('th').forEach((th) => th.removeAttribute('aria-sort'));
			btn.closest('th')?.setAttribute('aria-sort', sortDir === 1 ? 'ascending' : 'descending');
			page = 0;
			render();
		});
	});

	[search, make, min].forEach((el) =>
		el?.addEventListener('input', () => {
			page = 0;
			render();
		}),
	);

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
