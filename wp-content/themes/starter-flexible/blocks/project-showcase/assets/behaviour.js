// Project Showcase — a stack of cards that pin as the page scrolls.
//
// The pinning is CSS (position: sticky). This only adds depth: as the next
// card slides up over a pinned one, the pinned card eases back (a little
// smaller, a little dimmer) through `--cover`, 0 → 1.
import { viewport } from '$lib/stores/viewport.svelte.js';
import { motion } from '$lib/stores/motion.svelte.js';
import { clamp } from '$lib/format';

export const selector = '[data-showcase-stack]';

export default function showcaseStack(root) {
	const cards = [...root.querySelectorAll('[data-ps-card]')];
	if (cards.length < 2) return null;

	const draw = () => {
		if (!motion.allowed) {
			cards.forEach((c) => c.style.removeProperty('--cover'));
			return;
		}
		cards.forEach((card, i) => {
			const next = cards[i + 1];
			if (!next) return;
			const a = card.getBoundingClientRect();
			const b = next.getBoundingClientRect();
			// 0 when the next card is a full card-height below, 1 when it lies on top.
			const cover = clamp(1 - (b.top - a.top) / Math.max(1, a.height), 0, 1);
			card.style.setProperty('--cover', cover.toFixed(3));
		});
	};

	const offScroll = viewport.subscribe(draw);
	const offMotion = motion.subscribe(draw);
	return () => {
		offScroll();
		offMotion();
	};
}
