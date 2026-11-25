// Project Showcase — a heading beside a rail of project cards.
//
// On a desktop with motion allowed: pin, then slide. The content sticks
// under the header and the cards slide left as far as the page scrolls,
// from the first card in full view to the last (style.scss, `ps-rail`): CSS
// sticky plus a CSS scroll-driven animation, both on the compositor, so
// nothing lags the scroll. This module only measures the travel and the
// pinned height (once per layout) and turns the mode on when it fits.
// Elsewhere (phones, reduced motion, browsers without scroll timelines) the
// rail is a native horizontal scroller with arrow buttons that step one card.
import { on, cleanupAll } from '$lib/dom';
import { motion } from '$lib/stores/motion.svelte.js';

export const selector = '[data-showcase-stack]';

const DRIVEN_MQ = '(min-width: 1024px)';
const supportsTimeline = typeof CSS !== 'undefined' && CSS.supports?.('animation-timeline: view()');

export default function showcase(root) {
	const row = root.querySelector('.ps__stack');
	const cards = [...root.querySelectorAll('[data-ps-card]')];
	if (!row || cards.length < 2) return null;
	const prev = root.querySelector('[data-ps-prev]');
	const next = root.querySelector('[data-ps-next]');
	const mq = window.matchMedia(DRIVEN_MQ);

	const max = () => Math.max(0, row.scrollWidth - row.clientWidth);
	const step = () => {
		const gap = parseFloat(getComputedStyle(row).columnGap) || 0;
		return cards[0].getBoundingClientRect().width + gap;
	};

	// How far the last card must move for its right edge to meet the rail's.
	// offsetLeft/offsetWidth ignore transforms, so the animation in progress
	// does not skew the measurement.
	const travel = () => {
		const first = cards[0];
		const last = cards[cards.length - 1];
		const cs = getComputedStyle(row);
		const inner = row.clientWidth - (parseFloat(cs.paddingLeft) || 0) - (parseFloat(cs.paddingRight) || 0);
		return Math.max(0, last.offsetLeft - first.offsetLeft + last.offsetWidth - inner);
	};

	let raf = 0;
	const sync = () => {
		raf = 0;
		const pin = root.querySelector('[data-ps-pin]');
		const hdr = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--hdr-h')) || 76;
		// Pin only when the held content fits under the header.
		const fits = pin && pin.offsetHeight + hdr + 48 <= window.innerHeight;
		const t = supportsTimeline && mq.matches && motion.allowed && fits ? travel() : 0;
		const driven = t > 2;
		root.classList.toggle('is-scroll-driven', driven);
		if (driven) {
			row.scrollLeft = 0;
			root.style.setProperty('--ps-travel', `${Math.round(t)}px`);
			root.style.setProperty('--ps-pin-h', `${pin.offsetHeight}px`);
			root.classList.remove('ps--fits');
			return;
		}
		root.style.removeProperty('--ps-travel');
		root.style.removeProperty('--ps-pin-h');
		const m = max();
		const x = row.scrollLeft;
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
			on(mq, 'change', queue),
			motion.subscribe(() => queue()),
			prev && on(prev, 'click', () => go(-1)),
			next && on(next, 'click', () => go(1)),
			() => cancelAnimationFrame(raf),
			() => root.classList.remove('is-scroll-driven'),
		].filter(Boolean)
	);
}
