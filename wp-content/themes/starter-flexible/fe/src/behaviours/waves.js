// Scroll-linked drift for the wave marks.
//
// Each <path> in a `[data-wave]` svg is nudged along a sine of the element's
// progress through the viewport, with a phase offset per line, so the lines
// slide out of step — a slow swell rather than the whole graphic sliding.
// `data-wave="0.5"` scales the amplitude for a mark that should barely move.
import { viewport } from '../lib/stores/viewport.svelte.js';
import { motion } from '../lib/stores/motion.svelte.js';

export const selector = '[data-wave]';

const BASE_X = 16; // viewBox units, not px — the svgs stretch to fit
const BASE_Y = 5;

export default function waves(svg) {
	const paths = [...svg.querySelectorAll('path')];
	const amp = Number(svg.dataset.wave) || 1;
	let allowed = true;

	const draw = ({ height: vh }) => {
		if (!allowed) return;
		const rect = svg.getBoundingClientRect();
		// Well outside the viewport: no work, no layout thrash.
		if (rect.bottom < -vh || rect.top > vh * 2) return;
		const progress = (rect.top + rect.height / 2 - vh / 2) / vh; // -1 above, 0 centred, +1 below
		paths.forEach((path, i) => {
			const phase = i * 0.55;
			const x = Math.sin(progress * Math.PI * 1.5 + phase) * BASE_X * amp;
			const y = Math.cos(progress * Math.PI * 1.1 + phase) * BASE_Y * amp;
			path.style.transform = `translate(${x.toFixed(2)}px, ${y.toFixed(2)}px)`;
		});
	};

	const offMotion = motion.subscribe((ok) => {
		allowed = ok;
		if (!ok) paths.forEach((p) => (p.style.transform = ''));
		else viewport.invalidate();
	});
	const offScroll = viewport.subscribe(draw);

	return () => {
		offMotion();
		offScroll();
	};
}
