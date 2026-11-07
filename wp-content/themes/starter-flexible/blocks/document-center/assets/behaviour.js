// Document Center — filter the server-rendered rows by group.
import { on, cleanupAll } from '$lib/dom';

export const selector = '[data-doc-filters]';

export default function documentFilters(bar) {
	const scope = bar.parentElement;
	const rows = [...(scope?.querySelectorAll('[data-doc-group]') ?? [])];
	const empty = scope?.querySelector('[data-doc-empty]');
	const buttons = [...bar.querySelectorAll('[data-doc-filter]')];

	const apply = (btn) => {
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
	};

	return cleanupAll(buttons.map((btn) => on(btn, 'click', () => apply(btn))));
}
