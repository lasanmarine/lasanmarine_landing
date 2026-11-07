// Project Showcase — a heading beside a rail of project cards.
//
// On a desktop with motion on, the block pins under the header and the page
// scroll slides the row sideways: as far as the reader scrolls, so far the
// row moves, until the last card reaches the left edge; then the page moves
// on (lib/scrub). Elsewhere the row is a native swipe/scroll strip.
import { scrub } from '$lib/scrub';

export const selector = '[data-showcase-stack]';
export const order = 50; // before stack.js sizes the sheets

export default function showcaseSlider(root) {
	const pin = root.querySelector('[data-ps-pin]');
	const row = root.querySelector('.ps__stack');
	const cards = [...root.querySelectorAll('[data-ps-card]')];
	if (!pin || !row || cards.length < 2) return null;

	const max = () => Math.max(0, row.scrollWidth - row.clientWidth);

	return scrub(root, {
		pin,
		reset: () => {
			row.style.paddingRight = '';
			row.scrollLeft = 0;
			root.style.removeProperty('--p');
		},
		run: () => {
			// Room after the last card so it can travel to the left edge.
			const last = cards[cards.length - 1];
			row.style.paddingRight = `${Math.max(0, row.clientWidth - last.offsetWidth)}px`;
			return max() * 1.2;
		},
		progress: (p) => {
			row.scrollLeft = p * max();
			root.style.setProperty('--p', p.toFixed(3));
		},
	});
}
