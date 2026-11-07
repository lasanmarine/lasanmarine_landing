// Behaviour events for GA4. They answer the questions from the scroll study:
// how far people read, which blocks they actually see, what they click.
//   scroll_depth   { percent: 25|50|75|100 }
//   section_view   { section: 'service-architecture', index }
//   cta_click      { label, type, href, section }
//   onpage_nav     { label, source: 'hero_card'|'sticky_bar' }
import { viewport } from '../lib/stores/viewport.svelte.js';
import { track, blockName } from '../lib/analytics';
import { on, cleanupAll } from '../lib/dom';

export const selector = 'body';
export const once = true;

export default function analytics() {
	// Scroll depth, each threshold once per page view.
	const marks = [25, 50, 75, 100];
	const sent = new Set();
	// The first call runs inside subscribe() (a short page is already at
	// 100%), before offScroll is assigned: declare it first, unsubscribe after.
	let offScroll = null;
	let done = false;
	offScroll = viewport.subscribe(({ scrollY, height }) => {
		const max = document.documentElement.scrollHeight - height;
		const pct = max > 0 ? (scrollY / max) * 100 : 100;
		marks.forEach((m) => {
			if (pct >= m - 1 && !sent.has(m)) {
				sent.add(m);
				track('scroll_depth', { percent: m });
			}
		});
		if (sent.size === marks.length) {
			done = true;
			if (offScroll) {
				offScroll();
				offScroll = null;
			}
		}
	});
	if (done && offScroll) {
		offScroll();
		offScroll = null;
	}

	// Sections seen (half on screen), once each.
	const blocks = [...document.querySelectorAll('.block-stream > [class*="lasanmarine-"]')];
	let io = null;
	if ('IntersectionObserver' in window && blocks.length) {
		io = new IntersectionObserver(
			(entries) => {
				entries.forEach((e) => {
					if (!e.isIntersecting) return;
					io.unobserve(e.target);
					track('section_view', { section: blockName(e.target), index: blocks.indexOf(e.target) + 1 });
				});
			},
			{ threshold: 0.5 },
		);
		blocks.forEach((b) => io.observe(b));
	}

	// Clicks on buttons and in-page navigation.
	const offClick = on(
		document,
		'click',
		(e) => {
			const a = e.target.closest?.('a, button');
			if (!a) return;
			const label = (a.textContent || '').replace(/\s+/g, ' ').trim().slice(0, 80);
			if (a.matches('.onpage__link')) {
				track('onpage_nav', { label, source: 'sticky_bar' });
			} else if (a.matches('[data-cta], .btn, .hdr__cta, .link')) {
				track('cta_click', {
					label,
					type: a.dataset.cta || 'link',
					href: a.getAttribute('href') || '',
					section: blockName(a.closest('.block-stream > *')) || 'header',
				});
			}
		},
		{ capture: true },
	);

	return cleanupAll([() => offScroll?.(), () => io?.disconnect(), offClick]);
}
