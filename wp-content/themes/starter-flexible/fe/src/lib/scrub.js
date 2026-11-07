// Scroll-scrubbed blocks: on a desktop with motion on, a block's content pins
// under the header while the page scrolls through a "run" of extra height,
// and the scroll position across that run is reported as 0 → 1.
//
//   scrub(root, { pin, run: () => px, progress: (p) => {}, reset: () => {} })
//
// The run is a spacer inserted after the pin, inside the block's content box
// (a sticky child can only travel within its parent's content box).
// Elsewhere (phones, reduced motion) nothing pins: `reset()` is called and the
// block is left in its static form. Returns a cleanup.
import { on, cleanupAll } from './dom';
import { clamp } from './format';
import { viewport } from './stores/viewport.svelte.js';
import { motion } from './stores/motion.svelte.js';

const MQ = '(min-width: 1024px) and (min-height: 640px)';

export function scrub(root, { pin, run, progress, reset = () => {} }) {
	const mq = window.matchMedia(MQ);
	const spacer = document.createElement('div');
	spacer.className = 'scrub-run';
	spacer.setAttribute('aria-hidden', 'true');
	let active = false;
	let distance = 0;

	const drive = () => {
		if (!active) return;
		// The spacer stays in the flow, so it shows where the pin would be
		// without sticking; how far the pin has been held is the difference.
		const natural = spacer.getBoundingClientRect().top - pin.offsetHeight;
		const travelled = (parseFloat(getComputedStyle(pin).top) || 0) - natural;
		progress(clamp(travelled / Math.max(distance, 1), 0, 1));
	};

	const measure = () => {
		root.classList.remove('is-scrub');
		spacer.remove();
		reset();
		active = mq.matches && motion.allowed;
		if (active) {
			distance = Math.max(0, Math.round(run()));
			if (distance < 8) active = false;
		}
		if (active) {
			spacer.style.height = `${distance}px`;
			pin.after(spacer);
			root.classList.add('is-scrub');
		}
		drive();
	};

	measure();
	return cleanupAll([
		viewport.subscribe((snap) => (snap.resized ? measure() : drive())),
		on(mq, 'change', measure),
		motion.subscribe(() => measure()),
		() => {
			spacer.remove();
			root.classList.remove('is-scrub');
			reset();
		},
	]);
}
