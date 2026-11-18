// Scroll reveal for the whole site — and the per-element entrances the tool
// blocks used to get from AOS.
//
//   [data-reveal="up|left|right|scale|fade"]  an element arrives as one piece
//   [data-reveal-stagger="selector"]          its children (or the matches of
//                                             the selector) arrive in turn
//
// Nothing is hidden before the first paint: what is on screen at load is
// shown as it is (no entrance on first contentful paint), and `reveal-on`
// is set here, after what is in view has been marked revealed. Everything is
// revealed once and then unobserved.

import { staggerDelay } from '../lib/motion-math';

export const selector = '[data-reveal], [data-reveal-stagger]';
export const order = 10;

// Stagger: the first items follow each other STEP ms apart; the delay then
// bends toward MAX and never reaches it (lib/motion-math staggerDelay), where
// a linear stagger capped at an index used to stop dead.
const STAGGER_STEP = 60;
const STAGGER_MAX = 480;

let io = null;

/**
 * The step at which each child enters.
 *   (default)  document order: 0, 1, 2, …
 *   "grid"     a diagonal wave across a grid: row + column, so a bento or a
 *              matrix fills from its top-left corner outward instead of
 *              reading like a list. Rows and columns are found by clustering
 *              the children's offsets (a wrapped flex row works too).
 *   "together" all at once (a set that reads as one picture).
 * @returns {number[]}
 */
function orderOf(children, mode) {
	if (mode === 'together') return children.map(() => 0);
	if (mode !== 'grid') return children.map((_, i) => i);
	const rank = (values) => {
		const sorted = [...new Set(values.map((v) => Math.round(v / 8)))].sort((a, b) => a - b);
		return values.map((v) => sorted.indexOf(Math.round(v / 8)));
	};
	const rows = rank(children.map((c) => c.offsetTop));
	const cols = rank(children.map((c) => c.offsetLeft));
	return children.map((_, i) => rows[i] + cols[i]);
}

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
		const order = orderOf(children, node.dataset.revealOrder);
		children.forEach((child, i) => {
			if (!child.hasAttribute('data-reveal-item')) child.setAttribute('data-reveal-item', '');
			i = order[i];
			child.style.setProperty('--reveal-delay', `${Math.round(staggerDelay(i, STAGGER_STEP, STAGGER_MAX))}ms`);
			targets.push(child);
		});
	}

	// What the reader already sees has been painted (first contentful paint,
	// largest paint): it stays as it is — revealed at once, no entrance. Only
	// what is still below the screen is hidden, out of sight, to arrive later.
	// This runs before the next paint, so nothing visible ever blinks.
	const vh = window.innerHeight;
	const pending = [];
	for (const el of targets) {
		const r = el.getBoundingClientRect();
		if (r.top < vh && r.bottom > 0) {
			el.classList.add('is-revealed', 'reveal-instant');
			instant.add(el);
		} else {
			pending.push(el);
		}
	}
	document.documentElement.classList.add('reveal-on');
	flushInstant();

	const obs = observer();
	pending.forEach((el) => obs.observe(el));
	return () => pending.forEach((el) => obs.unobserve(el));
}

// `reveal-instant` holds back the reveal transition for the frame in which
// the element is armed, then goes, so its own hover/press transitions work.
const instant = new Set();
let instantQueued = false;
function flushInstant() {
	if (instantQueued) return;
	instantQueued = true;
	requestAnimationFrame(() =>
		requestAnimationFrame(() => {
			instant.forEach((el) => el.classList.remove('reveal-instant'));
			instant.clear();
			instantQueued = false;
		}),
	);
}
