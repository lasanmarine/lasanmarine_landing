// Animate a change of what a list shows (a filter, a tab) with the View
// Transitions API: items that stay slide to their new places, the ones that
// leave fade out, the new ones fade in — one coherent move instead of a cut.
// Each item needs a unique `view-transition-name` (name() below). Without
// the API, or with motion off, the change simply happens.
import { motion } from './stores/motion.svelte.js';

let seq = 0;

/** Give each element a page-unique view-transition-name. */
export function name(elements, prefix = 'vt') {
	const id = `${prefix}${++seq}`;
	elements.forEach((el, i) => (el.style.viewTransitionName = `${id}-${i}`));
}

/** Run `update` inside a view transition when possible. */
export function transition(update) {
	if (!document.startViewTransition || !motion.allowed) {
		update();
		return;
	}
	document.startViewTransition(update);
}
