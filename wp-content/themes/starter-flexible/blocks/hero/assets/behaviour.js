// Hero — turning the slides.
//
// The photograph, the headline and the lead are three separate stacks of
// panels carrying the same `data-hero-panel` index, so one number moves all of
// them. A hero with a single slide never gets `data-hero`.
//
// Autoplay runs unless something holds it: focus inside the hero (a keyboard
// user must not have the slide move out from under them), a backgrounded tab,
// or a request for less motion. Hover does not hold it: nothing under the
// pointer moves, so there is nothing to protect.
import { motion } from '$lib/stores/motion.svelte.js';
import { on, cleanupAll } from '$lib/dom';

export const selector = '[data-hero]';

export default function hero(root) {
	const dots = [...root.querySelectorAll('[data-hero-dot]')];
	const panels = [...root.querySelectorAll('[data-hero-panel]')];
	if (dots.length < 2) return null;

	const delay = Number(root.dataset.heroAutoplay) || 0;
	const holds = new Set();
	let index = 0;
	let timer = 0;

	const turning = () => delay > 0 && motion.allowed && holds.size === 0;

	/** The sweep has to be rewound before it can run again, or it jumps. */
	const restartFill = (dot, ms) => {
		const fill = dot.querySelector('.hero__dot-fill');
		if (!fill) return;
		dot.classList.toggle('is-static', !ms);
		dot.style.setProperty('--hero-dot-ms', `${ms || 620}ms`);
		fill.style.transition = 'none';
		fill.style.transform = 'scaleX(0)';
		void fill.offsetWidth; // the rewind lands before the sweep
		fill.style.transition = '';
		fill.style.transform = '';
	};

	const show = (next) => {
		index = (next + dots.length) % dots.length;
		panels.forEach((panel) => {
			const current = Number(panel.dataset.heroPanel) === index;
			panel.classList.toggle('is-current', current);
			panel.setAttribute('aria-hidden', String(!current));
		});
		dots.forEach((dot, i) => {
			const current = i === index;
			dot.classList.toggle('is-current', current);
			dot.setAttribute('aria-selected', String(current));
			if (current) restartFill(dot, turning() ? delay : 0);
		});
	};

	const stop = () => {
		clearTimeout(timer);
		timer = 0;
	};

	const schedule = () => {
		stop();
		if (!turning()) return;
		timer = setTimeout(() => {
			show(index + 1);
			schedule();
		}, delay);
	};

	const restart = () => {
		show(index);
		schedule();
	};

	const hold = (reason, held) => {
		const before = turning();
		holds[held ? 'add' : 'delete'](reason);
		if (turning() !== before) restart();
	};

	const dotsBar = root.querySelector('.hero__dots');

	show(0);

	return cleanupAll([
		on(root, 'focusin', () => hold('focus', true)),
		on(root, 'focusout', () => !root.contains(document.activeElement) && hold('focus', false)),
		on(document, 'visibilitychange', () => hold('hidden', document.hidden)),
		motion.subscribe(restart),
		...dots.map((dot, i) =>
			on(dot, 'click', () => {
				show(i);
				schedule();
			}),
		),
		// Left and right move between slides once a dot has the focus.
		dotsBar &&
			on(dotsBar, 'keydown', (e) => {
				const step = { ArrowLeft: -1, ArrowRight: 1 }[e.key];
				if (!step) return;
				e.preventDefault();
				show(index + step);
				dots[index].focus();
				schedule();
			}),
		stop,
	]);
}
