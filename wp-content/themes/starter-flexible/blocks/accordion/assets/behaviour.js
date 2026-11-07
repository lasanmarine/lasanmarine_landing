// Accordion — each panel is `hidden` until opened, so the markup works with
// scripting off; this toggles it and animates the height on the way in and
// out with the Web Animations API (skipped when motion is reduced).
import { motion } from '$lib/stores/motion.svelte.js';
import { on, cleanupAll } from '$lib/dom';

export const selector = '[data-accordion]';

const TIMING = { duration: 320, easing: 'cubic-bezier(0.2, 0.6, 0.2, 1)' };

function animateHeight(panel, from, to) {
	panel.style.overflow = 'hidden';
	const anim = panel.animate([{ height: `${from}px` }, { height: `${to}px` }], TIMING);
	const done = () => (panel.style.overflow = '');
	return anim.finished.then(done, done);
}

function open(panel) {
	panel.hidden = false;
	if (motion.allowed) animateHeight(panel, 0, panel.scrollHeight);
}

function close(panel) {
	if (!motion.allowed) {
		panel.hidden = true;
		return;
	}
	panel.getAnimations().forEach((a) => a.cancel());
	animateHeight(panel, panel.scrollHeight, 0).then(() => {
		// Reopened while closing? Then it stays.
		if (panel.dataset.state !== 'open') panel.hidden = true;
	});
}

export default function accordion(list) {
	return cleanupAll(
		[...list.querySelectorAll('.ac__trigger')].map((trigger) => {
			const panel = document.getElementById(trigger.getAttribute('aria-controls'));
			if (!panel) return null;
			return on(trigger, 'click', () => {
				const isOpen = trigger.getAttribute('aria-expanded') === 'true';
				trigger.setAttribute('aria-expanded', String(!isOpen));
				panel.dataset.state = isOpen ? 'closed' : 'open';
				if (isOpen) close(panel);
				else open(panel);
			});
		}),
	);
}
