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
import { motion } from '$lib/stores/motion.svelte.js';

export const selector = '[data-timeline]';

export default function timeline(pin) {
	const fill = pin.querySelector('[data-timeline-fill]');
	const steps = [...pin.querySelectorAll('[data-timeline-step]')];
	const root = pin.closest('section') || pin.parentElement;
	if (!fill || !steps.length) return null;
	const track = fill.parentElement;
	let scrubbing = false;

	// A node pops as the rail reaches it (scale .6 → 1 on the soft spring).
	// Nodes reached at load are not animated: nothing moves at first paint.
	const reached = steps.map(() => false);
	let live = false;
	requestAnimationFrame(() => requestAnimationFrame(() => (live = true)));
	const pop = (step) => {
		const dot = step.querySelector('.pt__dot');
		if (!dot || !motion.allowed) return;
		const css = getComputedStyle(dot);
		dot.animate([{ scale: '0.6' }, { scale: '1' }], {
			duration: parseFloat(css.getPropertyValue('--spring-soft-ms')) || 600,
			easing: css.getPropertyValue('--spring-soft').trim() || 'ease-out',
		});
	};

	let marked = false;
	const mark = (active, started) => {
		const animate = live && marked;
		marked = true;
		steps.forEach((step, i) => {
			const on = started && i <= active;
			step.classList.toggle('is-active', started && i === active);
			step.classList.toggle('is-done', started && i < active);
			if (on && !reached[i] && animate) pop(step);
			reached[i] = on;
		});
	};

	// Rail height reaching the centre of step i, as a share of the track.
	// Measured once per layout (both move together while pinned, so the
	// ratio is constant) instead of twice per step on every frame.
	let stops = null;
	const at = (i) => {
		if (!stops) {
			const t = track.getBoundingClientRect();
			stops = steps.map((step) => clamp((step.getBoundingClientRect().top + 24 - t.top) / Math.max(t.height, 1), 0, 1));
		}
		return stops[i];
	};

	const offScrub = scrub(root, {
		pin,
		run: () => {
			scrubbing = true;
			stops = null;
			return steps.length * window.innerHeight * 0.28;
		},
		reset: () => {
			scrubbing = false;
			stops = null;
		},
		progress: (p) => {
			// Step by step: p crosses each step in turn, the rail follows.
			const pos = p * (steps.length - 1);
			const i = Math.floor(pos);
			const f = pos - i;
			const from = at(i);
			const to = i + 1 < steps.length ? at(i + 1) : 1;
			const h = p >= 1 ? 1 : from + (to - from) * f;
			fill.style.transform = `scaleY(${h.toFixed(4)})`;
			mark(Math.min(steps.length - 1, Math.round(pos)), true);
		},
	});

	// Read phase: the rail and the steps' tops; nothing is written here.
	const read = ({ height }) => {
		if (scrubbing) return null;
		const r = track.getBoundingClientRect();
		if (r.bottom < -height || r.top > height * 2) return null;
		return { r, tops: steps.map((step) => step.getBoundingClientRect().top) };
	};
	const offRead = viewport.subscribe(
		({ height }, m) => {
			if (scrubbing || !m) return;
			const { r, tops } = m;
			const line = height * 0.55;
			fill.style.transform = `scaleY(${clamp((line - r.top) / Math.max(r.height, 1), 0, 1).toFixed(4)})`;
			let active = 0;
			tops.forEach((top, i) => {
				if (top <= line) active = i;
			});
			mark(active, r.top <= line);
		},
		{ read },
	);

	return () => {
		offScrub();
		offRead();
	};
}
