// Scroll-reveal for the whole site.
//
// Two levels:
//   [data-reveal]          — a block arrives as one piece.
//   [data-reveal-stagger]  — its children arrive one after another. The value
//                            is a CSS selector scoped to that container; leave
//                            it empty to use the direct children.
//
// Everything is revealed once and then unobserved.

const STAGGER_STEP_CAP = 12; // past this the delay stops growing

function markStaggerItems(root) {
	const items = [];

	root.querySelectorAll('[data-reveal-stagger]').forEach((group) => {
		const selector = group.dataset.revealStagger?.trim();
		const children = selector
			? group.querySelectorAll(selector)
			: Array.from(group.children);

		children.forEach((child, i) => {
			child.setAttribute('data-reveal-item', '');
			// Cap the index so a long list does not end on a multi-second delay.
			child.style.setProperty('--reveal-i', String(Math.min(i, STAGGER_STEP_CAP)));
			items.push(child);
		});
	});

	return items;
}

export function initReveal() {
	const root = document.documentElement;
	const staggered = markStaggerItems(document);
	const blocks = Array.from(document.querySelectorAll('[data-reveal]'));
	const targets = [...blocks, ...staggered];
	if (!targets.length) return;

	if (
		window.matchMedia('(prefers-reduced-motion: reduce)').matches ||
		!('IntersectionObserver' in window)
	) {
		root.classList.remove('reveal-on');
		return;
	}

	window.__revealReady = true;

	const io = new IntersectionObserver(
		(entries) => {
			for (const entry of entries) {
				if (!entry.isIntersecting) continue;
				entry.target.classList.add('is-revealed');
				io.unobserve(entry.target);
			}
		},
		{ rootMargin: '0px 0px -10% 0px', threshold: 0.05 },
	);

	targets.forEach((el) => io.observe(el));
}
