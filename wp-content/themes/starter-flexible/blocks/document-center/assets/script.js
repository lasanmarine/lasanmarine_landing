document.querySelectorAll('[data-doc-filters]').forEach((bar) => {
	const scope = bar.parentElement;
	const rows = scope?.querySelectorAll('[data-doc-group]') ?? [];
	const empty = scope?.querySelector('[data-doc-empty]');
	const buttons = bar.querySelectorAll('[data-doc-filter]');

	buttons.forEach((btn) => {
		btn.addEventListener('click', () => {
			buttons.forEach((b) => b.setAttribute('data-active', String(b === btn)));
			// The "all" pill carries no group index.
			const group = btn.dataset.docFilter === 'all' ? null : btn.dataset.docFilter;
			let shown = 0;
			rows.forEach((row) => {
				const hit = group === null || row.dataset.docGroup === group;
				row.hidden = !hit;
				if (hit) shown += 1;
			});
			if (empty) empty.hidden = shown > 0;
		});
	});
});
