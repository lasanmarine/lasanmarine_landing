// "Point at a row, its partner lights up": rows and their targets share a
// `data-i`, and the active pair carries data-active="true". Used by Geo
// Operations (rows ↔ map pins) and Service Architecture (rows ↔ slides).
import { on, cleanupAll } from './dom';

export function hoverSelect(root, { rows, targets, events = ['mouseenter', 'focus'] }) {
	const rowEls = [...root.querySelectorAll(rows)];
	const targetEls = [...root.querySelectorAll(targets)];

	const show = (i) => {
		rowEls.forEach((r) => r.setAttribute('data-active', String(r.dataset.i === i)));
		targetEls.forEach((t) => t.setAttribute('data-active', String(t.dataset.i === i)));
	};

	return cleanupAll(
		rowEls.flatMap((row) => events.map((type) => on(row, type, () => show(row.dataset.i ?? '0')))),
	);
}
