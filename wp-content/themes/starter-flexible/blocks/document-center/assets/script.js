document.querySelectorAll('[data-doc-filters]').forEach((bar) => {
	const scope = bar.parentElement;
	const rows = scope?.querySelectorAll('[data-doc-group]') ?? [];
	const empty = scope?.querySelector('[data-doc-empty]');
	const buttons = bar.querySelectorAll('[data-doc-filter]');

	buttons.forEach((btn, i) => {
		btn.addEventListener('click', () => {
			buttons.forEach((b) => b.setAttribute('data-active', String(b === btn)));
			// The first filter is always the "all" pill.
			const group = i === 0 ? null : btn.dataset.docFilter;
			let shown = 0;
			rows.forEach((row) => {
				const hit = !group || row.dataset.docGroup === group;
				row.hidden = !hit;
				if (hit) shown += 1;
			});
			if (empty) empty.hidden = shown > 0;
		});
	});
});
