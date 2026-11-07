// Process Timeline — the rail fills step by step.
//
// On a desktop with motion on, the block pins under the header and the page
// scroll fills the rail from the first step to the last; once it is full the
// page moves on (lib/scrub). Elsewhere the rail fills as the steps pass a
// reading line in the upper part of the screen.
// The node on the rail's front is active, the ones behind it done.
import { viewport } from '$lib/stores/viewport.svelte.js';
import { clamp } from '$lib/format';
import { scrub } from '$lib/scrub';

export const selector = '[data-timeline]';
export const order = 50; // before stack.js sizes the sheets

export default function timeline(pin) {
	const fill = pin.querySelector('[data-timeline-fill]');
	const steps = [...pin.querySelectorAll('[data-timeline-step]')];
	const root = pin.closest('section') || pin.parentElement;
	if (!fill || !steps.length) return null;
	const track = fill.parentElement;
	let scrubbing = false;

	const mark = (active, started) =>
		steps.forEach((step, i) => {
			step.classList.toggle('is-active', started && i === active);
			step.classList.toggle('is-done', started && i < active);
		});

	// Rail height reaching the centre of step i, as a share of the track.
	const at = (i) => {
		const t = track.getBoundingClientRect();
		const s = steps[i].getBoundingClientRect();
		return clamp((s.top + 24 - t.top) / Math.max(t.height, 1), 0, 1);
	};

	const offScrub = scrub(root, {
		pin,
		run: () => {
			scrubbing = true;
			return steps.length * window.innerHeight * 0.28;
		},
		reset: () => {
			scrubbing = false;
		},
		progress: (p) => {
			// Step by step: p crosses each step in turn, the rail follows.
			const pos = p * (steps.length - 1);
			const i = Math.floor(pos);
			const f = pos - i;
			const from = at(i);
			const to = i + 1 < steps.length ? at(i + 1) : 1;
			const h = p >= 1 ? 1 : from + (to - from) * f;
			fill.style.height = `${(h * 100).toFixed(2)}%`;
			mark(Math.min(steps.length - 1, Math.round(pos)), true);
		},
	});

	const offRead = viewport.subscribe(({ height }) => {
		if (scrubbing) return;
		const r = track.getBoundingClientRect();
		if (r.bottom < -height || r.top > height * 2) return;
		const line = height * 0.55;
		fill.style.height = `${clamp((line - r.top) / Math.max(r.height, 1), 0, 1) * 100}%`;
		let active = 0;
		steps.forEach((step, i) => {
			if (step.getBoundingClientRect().top <= line) active = i;
		});
		mark(active, r.top <= line);
	});

	return () => {
		offScrub();
		offRead();
	};
}
