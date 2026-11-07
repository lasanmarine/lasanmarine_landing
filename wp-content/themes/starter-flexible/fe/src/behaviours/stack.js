// Full-screen sheets that stack — and, on the home page, snap.
//
// Layout: every block is a sheet at least one screen tall (content centred by
// transparent borders), pinned under the bar; the next sheet glides over it
// while the covered one recedes under a paper-white veil. Long-read blocks
// (lists, forms, apps) are "flow" sheets: they scroll naturally.
//
// Navigation: scrolling is the browser's own. When the user pauses between two
// sheets the page settles softly onto one (settle()). Flow sheets never snap.
// Soft snapping stays on the home page: sub-pages are task pages, where NN/g
// found scroll control hurts most.
//
// Only transform/opacity animate; every value eases toward its target each
// frame, so the motion stays continuous. Scroll and resize come from the
// shared viewport store; the easing loop is this module's own.
import { viewport } from '../lib/stores/viewport.svelte.js';
import { motion } from '../lib/stores/motion.svelte.js';
import { on, cleanupAll } from '../lib/dom';

export const selector = '.block-stream';
export const order = 90; // after the header has published --hdr-h

const MQ = '(min-width: 1024px) and (min-height: 640px)'; // same as _sheets.scss
const GLIDE_MS = 900;
const easeInOut = (t) => (t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2);

export default function stack(stream) {
	if (!window.matchMedia) return null;
	// Soft snapping is off everywhere: the home page scrolls like the others.
	const SNAP = false;
	const mq = window.matchMedia(MQ);
	const cards = [...stream.children].filter((el) => el.offsetHeight > 0);
	if (cards.length < 2) return null;

	const state = cards.map(() => ({ cur: 0, target: 0 }));
	let raf = 0;
	let active = false;
	let stops = []; // { y, flowEnd? }, ascending

	const hdrH = () => viewport.hdrH || 76;

	function reset(el) {
		el.classList.remove('is-flow');
		el.style.removeProperty('--fill');
		el.style.top = '';
		el.style.zIndex = '';
		el.style.transform = '';
		el.style.removeProperty('--veil');
		el.style.visibility = '';
	}

	function measure() {
		active = mq.matches && motion.allowed;
		stream.classList.toggle('is-stacked', active);
		document.documentElement.classList.toggle('is-snapping', active);
		cards.forEach(reset);
		stream.style.paddingTop = '';
		stops = [];
		if (!active) return;
		const vh = window.innerHeight;
		const hdr = hdrH();
		// The first sheet is pinned at the bar's foot; if the stream starts under
		// the bar, pad it so that is also where the sheet sits in the flow —
		// otherwise the next sheet starts a bar-height too early and covers the
		// first one's bottom edge.
		// (A stream that already clears the bar with its own top padding, as
		// on a page that opens with the page hero, needs nothing.)
		const lead = parseFloat(getComputedStyle(stream).paddingTop) || 0;
		const natural = stream.getBoundingClientRect().top + window.scrollY + lead;
		if (natural < hdr) stream.style.paddingTop = `${lead + hdr - natural}px`;
		const avail = vh - hdr;
		stream.style.setProperty('--avail', `${avail}px`);

		// Pass 1: size every sheet. Each one is a screen tall (_sheets.scss);
		// only a block whose content is taller than that scrolls as a flow sheet.
		cards.forEach((el, i) => {
			const h = el.offsetHeight;
			const flow = h > avail + 2;
			el.classList.toggle('is-flow', flow);
			el.style.zIndex = String(i + 1);
			if (flow) {
				// A long sheet scrolls through, then holds with its end on the
				// bottom of the screen for the dwell (the stream's gap) while the
				// next one slides over it.
				el.style.top = `${Math.round(vh - h)}px`;
				return;
			}
			el.style.setProperty('--fill', `${Math.max(0, (avail - h) / 2).toFixed(1)}px`);
			el.style.top = `${hdr}px`;
		});

		// Pass 2: flow positions (sticky boxes report stuck positions, so walk).
		// Sheets are spaced by the stream's gap, never by margins.
		const sc = getComputedStyle(stream);
		const gapY = parseFloat(sc.rowGap) || 0;
		let y = stream.getBoundingClientRect().top + window.scrollY + (parseFloat(sc.paddingTop) || 0);
		cards.forEach((el, i) => {
			const h = el.offsetHeight;
			const top = Math.max(0, y - hdr);
			if (el.classList.contains('is-flow')) {
				stops.push({ y: top, flowEnd: Math.max(top, y + h - vh) });
			} else {
				stops.push({ y: i === 0 ? 0 : top });
			}
			y += h + gapY;
		});
		const max = document.documentElement.scrollHeight - vh;
		stops.push({ y: max }); // the footer
		stops = stops
			.map((s) => ({ ...s, y: Math.min(s.y, max) }))
			.filter((s, i, a) => i === 0 || s.y > a[i - 1].y + 4);

		state.forEach((s) => {
			s.cur = 0;
			s.target = 0;
			s.drawn = false;
		});
		targets();
		kick();
	}

	function targets() {
		if (!active) return;
		const vh = window.innerHeight;
		const hdr = hdrH();
		cards.forEach((el, i) => {
			const next = cards[i + 1];
			if (!next) return;
			// Measure where the next sheet sits in the flow, not where its own
			// recede transform has nudged it (translateY up to 36px).
			const n = state[i + 1];
			const np = n ? n.cur * n.cur * (3 - 2 * n.cur) : 0;
			const top = next.getBoundingClientRect().top - np * 36;
			const start = vh * 0.6;
			state[i].target = Math.min(1, Math.max(0, (start - top) / Math.max(1, start - hdr)));
		});
	}

	function frame() {
		raf = 0;
		if (!active) return;
		let moving = false;
		cards.forEach((el, i) => {
			const s = state[i];
			// Locked to the scroll (no trailing ease): the sheet moves exactly
			// with the finger or wheel, like Apple's scroll-linked pages.
			if (s.cur === s.target && s.drawn) return;
			s.cur = s.target;
			s.drawn = true;
			const p = s.cur * s.cur * (3 - 2 * s.cur);
			el.style.transform = p ? `translate3d(0, ${(p * 36).toFixed(2)}px, 0) scale(${(1 - p * 0.08).toFixed(4)})` : '';
			el.style.setProperty('--veil', p.toFixed(3));
			// Only sheets that are moving get a compositor layer.
			el.style.willChange = p > 0 && p < 1 ? 'transform' : '';
			// Fully covered: take it out of the picture, so it can't show through
			// the gap a long (flow) sheet leaves when it scrolls away.
			// (The pinned next sheet sits a few px under the bar, so a covered
			// sheet tops out just short of 1; count 0.97 as covered.)
			el.style.visibility = p > 0.97 ? 'hidden' : '';
		});
		if (moving) kick();
	}
	const kick = () => {
		if (!raf) raf = requestAnimationFrame(frame);
	};

	/* ---- soft snap ------------------------------------------------------- */
	// Scrolling stays native (wheel, trackpad momentum, scrollbar, keys, find,
	// anchors). Only when the user has stopped between two sheets does it settle
	// onto one: forward if they moved past ~10% of the gap in that direction,
	// otherwise back. Any input cancels a settle at once.

	let glideRaf = 0;
	let gliding = false;
	let selfScroll = false;
	let lastY = window.scrollY;
	let dir = 0;
	let idle = 0;
	let dragging = false;

	function cancelGlide() {
		if (glideRaf) cancelAnimationFrame(glideRaf);
		glideRaf = 0;
		gliding = false;
		selfScroll = false;
	}

	function glide(to) {
		const from = window.scrollY;
		if (Math.abs(to - from) < 2) return;
		cancelGlide();
		gliding = true;
		const t0 = performance.now();
		const dur = Math.min(GLIDE_MS, 380 + Math.abs(to - from) * 0.45);
		const step = (now) => {
			const t = Math.min(1, (now - t0) / dur);
			selfScroll = true;
			window.scrollTo(0, from + (to - from) * easeInOut(t));
			if (t < 1) glideRaf = requestAnimationFrame(step);
			else {
				glideRaf = 0;
				gliding = false;
				requestAnimationFrame(() => (selfScroll = false));
			}
		};
		glideRaf = requestAnimationFrame(step);
	}

	const land = (st) => (st.flowEnd !== undefined ? st.flowEnd : st.y);

	function settle() {
		if (!SNAP || !active || dragging || gliding || !stops.length) return;
		const y = window.scrollY;
		// Inside a long-read sheet: free reading, no snapping.
		if (stops.some((st) => st.flowEnd !== undefined && y > st.y + 2 && y < st.flowEnd - 2)) return;
		let a = null;
		let b = null;
		for (const st of stops) {
			if (land(st) <= y + 1) a = land(st);
			if (st.y > y + 1) {
				b = st.y;
				break;
			}
		}
		if (a === null || b === null || Math.abs(y - a) < 2 || Math.abs(b - y) < 2) return;
		const frac = (y - a) / (b - a);
		const forward = dir > 0 ? frac > 0.1 : dir < 0 ? frac > 0.9 : frac > 0.5;
		glide(forward ? b : a);
	}

	const onScroll = ({ scrollY: y }) => {
		targets();
		kick();
		if (!selfScroll) {
			if (Math.abs(y - lastY) > 0.5) dir = Math.sign(y - lastY);
			clearTimeout(idle);
			idle = setTimeout(settle, 160);
		}
		lastY = y;
	};

	let resizeTimer = 0;
	const onResize = () => {
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(measure, 120);
	};

	const takeOver = () => gliding && cancelGlide();

	measure();

	// A block that grows after load (a filter shows more cards, a question
	// opens, a late image) must be re-sized, or it stays pinned as a one-screen
	// sheet and the next sheet covers what no longer fits. Watch the content,
	// not the sheet itself, whose centring borders measure() rewrites.
	let lastSizes = new Map();
	const grown = new ResizeObserver((entries) => {
		let changed = false;
		for (const e of entries) {
			const h = Math.round(e.contentRect.height);
			if (lastSizes.get(e.target) !== h) {
				if (lastSizes.has(e.target)) changed = true;
				lastSizes.set(e.target, h);
			}
		}
		if (changed) onResize();
	});
	cards.forEach((card) => [...card.children].forEach((child) => grown.observe(child)));

	return cleanupAll([
		() => grown.disconnect(),
		viewport.subscribe((snap) => (snap.resized ? onResize() : onScroll(snap)), { immediate: false }),
		...['wheel', 'touchstart', 'keydown'].map((ev) => on(window, ev, takeOver, { passive: true })),
		on(
			window,
			'pointerdown',
			(e) => {
				takeOver();
				// A press outside the page's client area is a grab of the scrollbar.
				if (e.clientX >= document.documentElement.clientWidth) dragging = true;
			},
			{ passive: true },
		),
		on(
			window,
			'pointerup',
			() => {
				if (!dragging) return;
				dragging = false;
				clearTimeout(idle);
				idle = setTimeout(settle, 160);
			},
			{ passive: true },
		),
		on(mq, 'change', measure),
		motion.subscribe(() => measure()),
		on(window, 'load', measure),
		() => {
			cancelGlide();
			cancelAnimationFrame(raf);
			clearTimeout(idle);
			clearTimeout(resizeTimer);
			cards.forEach(reset);
			stream.style.paddingTop = '';
			stream.classList.remove('is-stacked');
		},
	]);
}
