// Full-screen sheets that stack — and snap.
//
// Layout: every block is a sheet at least one screen tall (content centred by
// transparent borders), pinned under the bar; the next sheet glides over it
// while the covered one recedes under a paper-white veil. Long-read blocks
// (lists, forms, apps) are "flow" sheets: they scroll naturally.
//
// Navigation: scrolling is the browser's own; when the user pauses between
// two sheets the page settles softly onto one (see settle()). Long-read
// sheets never snap. The page-hero with summary cards has one extra stop.
//
// Only transform/opacity animate; every value eases toward its target each
// frame, so the motion stays continuous.

import { motionAllowed } from './motion';

const MQ = '(min-width: 768px)';
const EASE = 0.12;
const GLIDE_MS = 900;

function hdrH() {
	return parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--hdr-h')) || 76;
}
const easeInOut = (t) => (t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2);

export function initStack() {
	// Stacking runs on every page. Soft snapping stays on the home page only:
	// sub-pages are task pages, where NN/g found scroll control hurts most.
	const SNAP = document.body.classList.contains('home');
	const stream = document.querySelector('.block-stream');
	if (!stream || !window.matchMedia) return;
	const mq = window.matchMedia(MQ);
	const cards = [...stream.children].filter((el) => el.offsetHeight > 0);
	if (cards.length < 2) return;

	const state = cards.map(() => ({ cur: 0, target: 0 }));
	let raf = 0;
	let on = false;
	let stops = []; // { y, flowEnd? }, ascending
	let gliding = false;

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
		on = mq.matches && motionAllowed();
		stream.classList.toggle('is-stacked', on);
		document.documentElement.classList.toggle('is-snapping', on);
		cards.forEach(reset);
		stops = [];
		if (!on) return;
		const vh = window.innerHeight;
		const hdr = hdrH();
		const avail = vh - hdr;
		stream.style.setProperty('--avail', `${avail}px`);

		// Pass 1: size every sheet.
		cards.forEach((el, i) => {
			const h = el.offsetHeight;
			const flow = h > avail + 2;
			el.classList.toggle('is-flow', flow);
			el.style.zIndex = String(i + 1);
			if (flow) return;
			const fill = Math.max(0, (avail - h) / 2);
			el.style.setProperty('--fill', `${fill.toFixed(1)}px`);
			el.style.top = `${hdr}px`;
		});

		// Pass 2: flow positions (sticky boxes report stuck positions, so walk).
		let y = stream.getBoundingClientRect().top + window.scrollY;
		cards.forEach((el, i) => {
			const h = el.offsetHeight;
			const cs = getComputedStyle(el);
			const mb = parseFloat(cs.marginBottom) || 0;
			y += parseFloat(cs.marginTop) || 0;
			const top = Math.max(0, y - hdr);
			if (el.classList.contains('is-flow')) {
				stops.push({ y: top, flowEnd: Math.max(top, y + h - vh) });
			} else {
				stops.push({ y: i === 0 ? 0 : top });
				if (i === 0 && mb > 0) stops.push({ y: Math.round(mb * 0.9) }); // hero cards
			}
			y += h + mb;
		});
		const max = document.documentElement.scrollHeight - vh;
		stops.push({ y: max }); // the footer
		stops = stops
			.map((s) => ({ ...s, y: Math.min(s.y, max) }))
			.filter((s, i, a) => i === 0 || s.y > a[i - 1].y + 4);

		state.forEach((s) => { s.cur = 0; s.target = 0; });
		targets();
		kick();
	}

	function targets() {
		if (!on) return;
		const vh = window.innerHeight;
		const hdr = hdrH();
		cards.forEach((el, i) => {
			const next = cards[i + 1];
			if (!next) return;
			const top = next.getBoundingClientRect().top;
			const start = vh * 0.6;
			state[i].target = Math.min(1, Math.max(0, (start - top) / Math.max(1, start - hdr)));
		});
	}

	function frame() {
		raf = 0;
		if (!on) return;
		let moving = false;
		cards.forEach((el, i) => {
			const s = state[i];
			const d = s.target - s.cur;
			if (Math.abs(d) > 0.0005) { s.cur += d * EASE; moving = true; } else { s.cur = s.target; }
			const p = s.cur * s.cur * (3 - 2 * s.cur);
			el.style.transform = p ? `translate3d(0, ${(p * 36).toFixed(2)}px, 0) scale(${(1 - p * 0.1).toFixed(4)})` : '';
			el.style.setProperty('--veil', p.toFixed(3));
			// Fully covered: take it out of the picture, so it can't show through
			// the gap a long (flow) sheet leaves when it scrolls away.
			el.style.visibility = s.cur > 0.995 ? 'hidden' : '';
		});
		if (moving) kick();
	}
	function kick() { if (!raf) raf = requestAnimationFrame(frame); }

	// --- soft snap ------------------------------------------------------------
	// Scrolling stays native (wheel, trackpad momentum, scrollbar, keys, find,
	// anchors). Only when the user has stopped and the page rests between two
	// sheets does it settle onto one: forward if they moved past ~10% of the
	// gap in that direction, otherwise back. Any input cancels a settle at once.

	let glideRaf = 0;
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
			else { glideRaf = 0; gliding = false; requestAnimationFrame(() => { selfScroll = false; }); }
		};
		glideRaf = requestAnimationFrame(step);
	}

	const land = (st) => (st.flowEnd !== undefined ? st.flowEnd : st.y);

	function settle() {
		if (!SNAP || !on || dragging || gliding || !stops.length) return;
		const y = window.scrollY;
		// Inside a long-read sheet: free reading, no snapping.
		if (stops.some((st) => st.flowEnd !== undefined && y > st.y + 2 && y < st.flowEnd - 2)) return;
		let a = null;
		let b = null;
		for (const st of stops) {
			if (land(st) <= y + 1) a = land(st);
			if (st.y > y + 1) { b = st.y; break; }
		}
		if (a === null || b === null || Math.abs(y - a) < 2 || Math.abs(b - y) < 2) return;
		const frac = (y - a) / (b - a);
		const forward = dir > 0 ? frac > 0.1 : dir < 0 ? frac > 0.9 : frac > 0.5;
		glide(forward ? b : a);
	}

	window.addEventListener('scroll', () => {
		targets();
		kick();
		const y = window.scrollY;
		if (!selfScroll) {
			if (Math.abs(y - lastY) > 0.5) dir = Math.sign(y - lastY);
			clearTimeout(idle);
			idle = setTimeout(settle, 160);
		}
		lastY = y;
	}, { passive: true });

	// The user takes over instantly.
	['wheel', 'touchstart', 'keydown'].forEach((ev) => window.addEventListener(ev, () => { if (gliding) cancelGlide(); }, { passive: true }));
	window.addEventListener('pointerdown', (e) => {
		if (gliding) cancelGlide();
		// A press on the scrollbar (outside the page's client area) = dragging it.
		if (e.clientX >= document.documentElement.clientWidth) dragging = true;
	}, { passive: true });
	window.addEventListener('pointerup', () => {
		if (dragging) { dragging = false; clearTimeout(idle); idle = setTimeout(settle, 160); }
	}, { passive: true });

	let rt = 0;
	window.addEventListener('resize', () => { clearTimeout(rt); rt = setTimeout(measure, 120); });
	if (mq.addEventListener) mq.addEventListener('change', measure);
	window.addEventListener('lm:motion', measure);
	const rm = window.matchMedia('(prefers-reduced-motion: reduce)');
	if (rm.addEventListener) rm.addEventListener('change', measure);
	window.addEventListener('load', measure);
	measure();
}
