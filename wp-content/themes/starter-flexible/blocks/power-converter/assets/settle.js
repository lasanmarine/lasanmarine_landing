// "The number settles": when a result changes, the new value arrives with a
// short rise and fade (transform + opacity, Web Animations on the compositor)
// instead of a hard cut. Nothing about the box changes, so nothing shifts.
// Shared by the calculator islands (power-converter, shaft-diameter,
// engine-lookup) and the design brief.
//
//   <output use:settle={row.text}>   plays when the value changes, never on mount
//   enter(node)                      plays once, for a piece that was just added
import { motion } from '$lib/stores/motion.svelte.js';

/** A motion token from _easing.scss, read where it is used. */
function token(node, name, fallback) {
	const value = getComputedStyle(node).getPropertyValue(name).trim();
	return value || fallback;
}

/** Run keyframes on `node` with the --spring-snappy curve (small UI). */
export function play(node, keyframes, curve = 'snappy') {
	if (!motion.allowed || !node?.animate) return;
	// The token may come back as "380ms" or, minified, ".38s".
	const raw = token(node, `--spring-${curve}-ms`, '380ms');
	const n = parseFloat(raw);
	const duration = Number.isFinite(n) ? (raw.endsWith('ms') ? n : n * 1000) : 380;
	const easing = token(node, `--spring-${curve}`, 'ease-out');
	node.getAnimations?.().forEach((a) => a.id === 'settle' && a.cancel());
	try {
		node.animate(keyframes, { duration, easing, id: 'settle' });
	} catch {
		// An easing the engine cannot parse (an old linear()): fall back.
		node.animate(keyframes, { duration, easing: 'ease-out', id: 'settle' });
	}
}

const SETTLE = [
	{ opacity: 0.35, transform: 'translateY(0.18em)' },
	{ opacity: 1, transform: 'none' },
];

/** Svelte action: the value settles each time `value` changes. */
export function settle(node, value) {
	let last = value;
	return {
		update(next) {
			if (next === last) return;
			last = next;
			play(node, SETTLE);
		},
	};
}

/** A piece that was just added rises into place. */
export function enter(node) {
	play(
		node,
		[
			{ opacity: 0, transform: 'translateY(16px)' },
			{ opacity: 1, transform: 'none' },
		],
		'out',
	);
}
