// Endless decorative animations rest while they are off screen.
//
// A looping animation of background-position or box-shadow is repainted on the
// main thread every frame, visible or not; left running it competes with the
// scroll for the whole visit. The element gets `is-offscreen` while it is out
// of view and _motion.scss pauses it. Without this script nothing is paused.

export const selector = '.ftr__wordmark, .io__arrow';

let io = null;

function observer() {
	if (io) return io;
	io = new IntersectionObserver(
		(entries) => {
			for (const entry of entries) entry.target.classList.toggle('is-offscreen', !entry.isIntersecting);
		},
		{ rootMargin: '10% 0px' },
	);
	return io;
}

export default function offscreen(node) {
	if (!('IntersectionObserver' in window)) return null;
	const obs = observer();
	obs.observe(node);
	return () => {
		obs.unobserve(node);
		node.classList.remove('is-offscreen');
	};
}
