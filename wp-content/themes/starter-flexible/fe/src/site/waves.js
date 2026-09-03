// Scroll-linked drift for the wave marks.
//
// Each <path> in a `[data-wave]` svg is nudged along a sine of the element's
// progress through the viewport, with a phase offset per line. The lines slide
// out of step with each other, which reads as a slow swell rather than the
// whole graphic sliding.
//
// `data-wave` takes an optional amplitude multiplier: `data-wave="0.5"` for a
// mark that should barely move.

const BASE_X = 16; // viewBox units, not px — the svgs stretch to fit
const BASE_Y = 5;

export function initWaves() {
	if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

	const groups = [...document.querySelectorAll('[data-wave]')].map((svg) => ({
		svg,
		paths: [...svg.querySelectorAll('path')],
		amp: Number(svg.dataset.wave) || 1,
	}));
	if (!groups.length) return;

	let queued = false;

	const draw = () => {
		queued = false;
		const vh = window.innerHeight;

		for (const { svg, paths, amp } of groups) {
			const rect = svg.getBoundingClientRect();
			// Skip anything well outside the viewport — no work, no layout thrash.
			if (rect.bottom < -vh || rect.top > vh * 2) continue;

			// -1 above the fold, 0 centred, +1 below.
			const progress = (rect.top + rect.height / 2 - vh / 2) / vh;

			paths.forEach((path, i) => {
				const phase = i * 0.55;
				const x = Math.sin(progress * Math.PI * 1.5 + phase) * BASE_X * amp;
				const y = Math.cos(progress * Math.PI * 1.1 + phase) * BASE_Y * amp;
				path.style.transform = `translate(${x.toFixed(2)}px, ${y.toFixed(2)}px)`;
			});
		}
	};

	const schedule = () => {
		if (queued) return;
		queued = true;
		requestAnimationFrame(draw);
	};

	draw();
	window.addEventListener('scroll', schedule, { passive: true });
	window.addEventListener('resize', schedule);
}
