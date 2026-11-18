// Document Center — filter the server-rendered rows by group.
import { on, cleanupAll } from '$lib/dom';
import { name, transition } from '$lib/view-transition';

export const selector = '[data-doc-filters]';

export default function documentFilters(bar) {
	const scope = bar.parentElement;
	const rows = [...(scope?.querySelectorAll('[data-doc-group]') ?? [])];
	const empty = scope?.querySelector('[data-doc-empty]');
	const buttons = [...bar.querySelectorAll('[data-doc-filter]')];

	// Rows slide to their new places when the group changes.
	name(rows, 'dc');
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

	// A filter can lift cards that have not made their entrance yet into view.
	// They join the re-flow as they are, without starting an entrance of their
	// own (an entrance runs once, and only on the way down the page).
	const settle = () => {
		const waiting = rows.filter((row) => row.hasAttribute('data-reveal-item') && !row.classList.contains('is-revealed'));
		if (!waiting.length) return;
		waiting.forEach((row) => {
			row.style.transition = 'none';
			row.classList.add('is-revealed');
		});
		void bar.offsetWidth; // commit the end state before the transitions return
		waiting.forEach((row) => row.style.removeProperty('transition'));
	};

	return cleanupAll(
		buttons.map((btn) =>
			on(btn, 'click', () => {
				settle();
				transition(() => apply(btn));
			}),
		),
	);
}
