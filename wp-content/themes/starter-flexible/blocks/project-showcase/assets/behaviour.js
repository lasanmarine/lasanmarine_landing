// Project Showcase — a heading beside a rail of project cards.
//
// The rail is a native horizontal scroller everywhere: swipe, trackpad,
// shift+wheel or the arrow buttons, which step one card. The page scroll is
// never taken over. The bar under the heading shows how far along the rail
// the reader is; it is updated from the rail's own scroll events, at most
// once a frame.
import { on, cleanupAll } from '$lib/dom';
import { motion } from '$lib/stores/motion.svelte.js';

export const selector = '[data-showcase-stack]';

export default function showcase(root) {
	const row = root.querySelector('.ps__stack');
	const cards = [...root.querySelectorAll('[data-ps-card]')];
	if (!row || cards.length < 2) return null;
	const prev = root.querySelector('[data-ps-prev]');
	const next = root.querySelector('[data-ps-next]');
	const bar = root.querySelector('.ps__progress span');

	const max = () => Math.max(0, row.scrollWidth - row.clientWidth);
	const step = () => {
		const gap = parseFloat(getComputedStyle(row).columnGap) || 0;
		return cards[0].getBoundingClientRect().width + gap;
	};

	let raf = 0;
	const sync = () => {
		raf = 0;
		const m = max();
		const x = row.scrollLeft;
		bar?.style.setProperty('--p', (m ? x / m : 0).toFixed(3));
		if (prev) prev.disabled = x <= 2;
		if (next) next.disabled = x >= m - 2;
		root.classList.toggle('ps--fits', m <= 2);
	};
	const queue = () => {
		if (!raf) raf = requestAnimationFrame(sync);
	};
	const go = (dir) => row.scrollBy({ left: dir * step(), behavior: motion.allowed ? 'smooth' : 'auto' });

	sync();
	return cleanupAll(
		[
			on(row, 'scroll', queue, { passive: true }),
			on(window, 'resize', queue, { passive: true }),
			prev && on(prev, 'click', () => go(-1)),
			next && on(next, 'click', () => go(1)),
			() => cancelAnimationFrame(raf),
		].filter(Boolean)
	);
}
