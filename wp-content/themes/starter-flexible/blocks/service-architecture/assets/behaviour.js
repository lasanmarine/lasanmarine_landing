// Service Architecture — a row in the list brings up its slide.
//
// Entrance: the rows are layers that stack up from the bottom, so the reveal
// kit's stagger (document order, set by reveal.js before this runs) is
// turned around: the last row gets the first delay.
import { hoverSelect } from '$lib/hover-select';
import { cleanupAll } from '$lib/dom';

export const selector = '[data-service-arch]';

function stackFromBottom(root) {
	const rows = [...root.querySelectorAll('[data-reveal-stagger] > [data-reveal-item]')];
	const delays = rows.map((row) => row.style.getPropertyValue('--reveal-delay'));
	if (!delays.some(Boolean)) return;
	delays.reverse().forEach((d, i) => d && rows[i].style.setProperty('--reveal-delay', d));
}

export default (root) => {
	stackFromBottom(root);
	return cleanupAll([hoverSelect(root, { rows: '[data-service-row]', targets: '[data-service-slide]' })]);
};
