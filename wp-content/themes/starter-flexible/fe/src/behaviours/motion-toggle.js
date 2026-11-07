// The footer's "reduce motion" switch. State lives in the motion store; this
// only wires the button and keeps aria-pressed in step.
import { motion } from '../lib/stores/motion.svelte.js';
import { on, cleanupAll } from '../lib/dom';

export const selector = '[data-motion-toggle]';

export default function motionToggle(btn) {
	const sync = () => btn.setAttribute('aria-pressed', String(motion.userReduce));
	return cleanupAll([
		motion.subscribe(sync),
		on(btn, 'click', () => motion.setUserReduce(!motion.userReduce)),
	]);
}
