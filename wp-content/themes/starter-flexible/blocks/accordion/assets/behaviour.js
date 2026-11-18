// Accordion — each panel is `hidden` until opened, so the markup works with
// scripting off; this toggles it. The panel is a one-row grid whose row grows
// 0fr → 1fr (style.scss, `--spring-snappy`): the browser lays it out once at
// each end instead of a script writing a height every frame.
import { motion } from '$lib/stores/motion.svelte.js';
import { on, cleanupAll } from '$lib/dom';

export const selector = '[data-accordion]';

function open(trigger, panel) {
	panel.hidden = false;
	// Lay the panel out at 0fr before the row grows, or there is nothing to
	// transition from.
	if (motion.allowed) void panel.offsetHeight;
	trigger.setAttribute('aria-expanded', 'true');
}

function close(trigger, panel) {
	trigger.setAttribute('aria-expanded', 'false');
	if (!motion.allowed) {
		panel.hidden = true;
		return;
	}
	const done = (e) => {
		if (e && (e.target !== panel || e.propertyName !== 'grid-template-rows')) return;
		panel.removeEventListener('transitionend', done);
		panel.removeEventListener('transitioncancel', done);
		// Reopened while closing? Then it stays.
		if (trigger.getAttribute('aria-expanded') !== 'true') panel.hidden = true;
	};
	panel.addEventListener('transitionend', done);
	panel.addEventListener('transitioncancel', done);
}

export default function accordion(list) {
	return cleanupAll(
		[...list.querySelectorAll('.ac__trigger')].map((trigger) => {
			const panel = document.getElementById(trigger.getAttribute('aria-controls'));
			if (!panel) return null;
			return on(trigger, 'click', () => {
				if (trigger.getAttribute('aria-expanded') === 'true') close(trigger, panel);
				else open(trigger, panel);
			});
		}),
	);
}
