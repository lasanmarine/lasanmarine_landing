// Process Timeline — the rail fills as the steps pass a reading line in the
// upper part of the screen; the step on that line is active, the ones above
// it done, and the aside shows which step of how many is being read.
import { viewport } from '$lib/stores/viewport.svelte.js';
import { clamp } from '$lib/format';

export const selector = '[data-timeline]';

export default function timeline(root) {
	const fill = root.querySelector('[data-timeline-fill]');
	const steps = [...root.querySelectorAll('[data-timeline-step]')];
	const current = root.querySelector('[data-timeline-current]');
	if (!fill || !steps.length) return null;

	const track = fill.parentElement;

	return viewport.subscribe(({ height }) => {
		const r = track.getBoundingClientRect();
		if (r.bottom < -height || r.top > height * 2) return;
		const line = height * 0.55;

		// Fill the rail down to the reading line.
		const pct = clamp((line - r.top) / Math.max(r.height, 1), 0, 1) * 100;
		fill.style.height = `${pct}%`;

		let active = 0;
		steps.forEach((step, i) => {
			if (step.getBoundingClientRect().top <= line) active = i;
		});
		const started = r.top <= line;
		steps.forEach((step, i) => {
			step.classList.toggle('is-active', started && i === active);
			step.classList.toggle('is-done', started && i < active);
		});
		if (current) current.textContent = String(active + 1);
	});
}
