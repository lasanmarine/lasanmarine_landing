// Scroll reveal for the whole site — and the per-element entrances the tool
// blocks used to get from AOS.
//
//   [data-reveal="up|left|right|scale|fade"]  an element arrives as one piece
//   [data-reveal-stagger="selector"]          its children (or the matches of
//                                             the selector) arrive in turn
//
// The primer in inc/theme.php adds `reveal-on` to <html> before first paint
// and drops it again unless `window.__revealReady` is set in time.
// Everything is revealed once and then unobserved.

export const selector = '[data-reveal], [data-reveal-stagger]';
export const order = 10;

const STAGGER_STEP_CAP = 12; // past this the delay stops growing

let io = null;

function observer() {
	if (io) return io;
	io = new IntersectionObserver(
		(entries) => {
			for (const entry of entries) {
				if (!entry.isIntersecting) continue;
				entry.target.classList.add('is-revealed');
				io.unobserve(entry.target);
			}
		},
		{ rootMargin: '0px 0px -10% 0px', threshold: 0.05 },
	);
	return io;
}

function enabled() {
	// AOS-style hiding must not happen at all for a reader who asked the OS for
	// less motion; the footer toggle is honoured by CSS instead.
	if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) {
		document.documentElement.classList.remove('reveal-on');
		return false;
	}
	window.__revealReady = true;
	return true;
}

export default function reveal(node) {
	if (!enabled()) return null;
	const targets = [];

	if (node.hasAttribute('data-reveal')) targets.push(node);

	if (node.hasAttribute('data-reveal-stagger')) {
		const sel = node.dataset.revealStagger?.trim();
		const children = sel ? [...node.querySelectorAll(sel)] : [...node.children];
		children.forEach((child, i) => {
			child.setAttribute('data-reveal-item', '');
			// Cap the index so a long list does not end on a multi-second delay.
			child.style.setProperty('--reveal-i', String(Math.min(i, STAGGER_STEP_CAP)));
			targets.push(child);
		});
	}

	const obs = observer();
	targets.forEach((el) => obs.observe(el));
	return () => targets.forEach((el) => obs.unobserve(el));
}
