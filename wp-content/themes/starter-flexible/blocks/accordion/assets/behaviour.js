// Accordion — each panel is `hidden` until opened, so the markup works with
// scripting off; this toggles it and animates the height on the way in and
// out with the Web Animations API (skipped when motion is reduced).
import { motion } from '$lib/stores/motion.svelte.js';
import { on, cleanupAll } from '$lib/dom';

export const selector = '[data-accordion]';

const TIMING = { duration: 360, easing: 'cubic-bezier(0.22, 1, 0.36, 1)' };

function animateHeight(panel, from, to) {
	panel.getAnimations().forEach((a) => a.cancel());
	const anim = panel.animate(
		[
			{ height: `${from}px`, opacity: from ? 1 : 0 },
			{ height: `${to}px`, opacity: to ? 1 : 0 },
		],
		TIMING,
	);
	return anim.finished.catch(() => {});
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
	animateHeight(panel, panel.offsetHeight, 0).then(() => {
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
