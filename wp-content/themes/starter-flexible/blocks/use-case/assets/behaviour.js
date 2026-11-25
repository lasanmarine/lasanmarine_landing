// Use Case — a row of cases wider than the screen.
//
// On a desktop with motion on, the row is driven by the page scroll: the
// block grows by the row's overflow, its content pins under the header, and
// scrolling down slides the cases sideways — as far as the reader scrolls, so
// far the row moves. The arrows scroll the page by one case.
// Elsewhere (phones, reduced motion) it stays a native snap scroller with the
// arrows stepping one card.
import { on, cleanupAll } from '$lib/dom';
import { clamp } from '$lib/format';
import { viewport } from '$lib/stores/viewport.svelte.js';
import { motion } from '$lib/stores/motion.svelte.js';

export const selector = '[data-use-case]';

// Driving the row from the page scroll is retired (it stuttered on 60 Hz
// screens): the row is the native snap scroller with arrows everywhere.
const MQ = 'not all';

export default function useCase(root) {
	const track = root.querySelector('[data-uc-track]');
	const pin = root.querySelector('[data-uc-pin]');
	const prev = root.querySelector('[data-uc-prev]');
	const next = root.querySelector('[data-uc-next]');
	if (!track || !pin || !prev || !next) return null;

	const mq = window.matchMedia(MQ);
	const spacer = document.createElement('div');
	spacer.className = 'uc__run';
	spacer.setAttribute('aria-hidden', 'true');
	let scrub = false;
	let run = 0; // horizontal distance the row travels

	const step = () => {
		const card = track.firstElementChild;
		const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
		return card ? card.getBoundingClientRect().width + gap : track.clientWidth;
	};
	const max = () => Math.max(0, track.scrollWidth - track.clientWidth);

	const sync = () => {
		const m = max();
		prev.disabled = track.scrollLeft <= 2;
		next.disabled = track.scrollLeft >= m - 2;
		root.classList.toggle('uc--static', m <= 2);
	};

	// Map the page scroll onto the row. The row's overflow is cached per
	// layout (`span`); the block's top is read in the viewport store's read
	// phase, so a frame costs one layout read and one scroll write.
	let span = 0;
	const read = () => (scrub ? root.getBoundingClientRect().top : 0);
	const drive = (rootTop = read()) => {
		if (!scrub) return;
		const top = rootTop - (viewport.hdrH || 76);
		const x = clamp(-top / Math.max(run, 1), 0, 1) * span;
		if (Math.abs(track.scrollLeft - x) < 0.5) return;
		track.scrollLeft = x;
		prev.disabled = x <= 2;
		next.disabled = x >= span - 2;
	};

	const measure = () => {
		root.style.removeProperty('--uc-run');
		root.classList.remove('uc--scrub');
		spacer.remove();
		track.style.paddingRight = '';
		track.scrollLeft = 0;
		scrub = mq.matches && motion.allowed && max() > 2;
		if (scrub) {
			// Room after the last card, so the row keeps moving until that card
			// reaches the left edge before the page scrolls on.
			const last = track.lastElementChild;
			const pad = parseFloat(getComputedStyle(track).paddingRight) || 0;
			if (last) track.style.paddingRight = `${pad + Math.max(0, track.clientWidth - last.getBoundingClientRect().width - pad)}px`;
			// Scroll a little more than the row moves, so it doesn't race.
			span = max();
			run = Math.round(span * 1.4);
			root.style.setProperty('--uc-run', `${run}px`);
			root.classList.add('uc--scrub');
			pin.after(spacer);
		}
		sync();
		drive();
	};

	const go = (dir) => {
		if (!scrub) {
			track.scrollBy({ left: step() * dir, behavior: 'smooth' });
			return;
		}
		const ratio = run / Math.max(max(), 1);
		window.scrollBy({ top: step() * dir * ratio, behavior: 'smooth' });
	};

	measure();
	const ro = new ResizeObserver(() => !scrub && sync());
	ro.observe(track);

	return cleanupAll([
		on(prev, 'click', () => go(-1)),
		on(next, 'click', () => go(1)),
		on(track, 'scroll', () => !scrub && sync(), { passive: true }),
		viewport.subscribe((snap, top) => (snap.resized ? measure() : drive(top)), { read }),
		on(mq, 'change', measure),
		motion.subscribe(() => measure()),
		() => {
			ro.disconnect();
			spacer.remove();
			track.style.paddingRight = '';
			root.classList.remove('uc--scrub');
			root.style.removeProperty('--uc-run');
		},
	]);
}
