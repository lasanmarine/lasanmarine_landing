// Behaviour events for GA4 (through gtag or the GTM dataLayer already on the
// page — no extra service). They answer the questions from the scroll study:
// how far people read, which blocks they actually see, what they click.
//   scroll_depth   { percent: 25|50|75|100 }
//   section_view   { section: 'service-architecture', index }
//   cta_click      { label, href, section }
//   onpage_nav     { label, source: 'hero_card'|'sticky_bar' }

function send(name, params) {
	params.page_path = location.pathname;
	if (typeof window.gtag === 'function') window.gtag('event', name, params);
	else (window.dataLayer = window.dataLayer || []).push({ event: name, ...params });
}

const blockName = (el) => ((el && el.className.toString().match(/lasanmarine-([a-z-]+)/)) || [])[1] || 'other';

export function initAnalytics() {
	// Scroll depth, each threshold once per page view.
	const marks = [25, 50, 75, 100];
	const sent = new Set();
	const onScroll = () => {
		const max = document.documentElement.scrollHeight - window.innerHeight;
		const pct = max > 0 ? (window.scrollY / max) * 100 : 100;
		marks.forEach((m) => { if (pct >= m - 1 && !sent.has(m)) { sent.add(m); send('scroll_depth', { percent: m }); } });
		if (sent.size === marks.length) window.removeEventListener('scroll', onScroll);
	};
	window.addEventListener('scroll', onScroll, { passive: true });

	// Sections seen (half on screen), once each.
	const blocks = [...document.querySelectorAll('.block-stream > [class*="lasanmarine-"]')];
	if ('IntersectionObserver' in window && blocks.length) {
		const io = new IntersectionObserver((entries) => {
			entries.forEach((e) => {
				if (!e.isIntersecting) return;
				io.unobserve(e.target);
				send('section_view', { section: blockName(e.target), index: blocks.indexOf(e.target) + 1 });
			});
		}, { threshold: 0.5 });
		blocks.forEach((b) => io.observe(b));
	}

	// Clicks on buttons and in-page navigation.
	document.addEventListener('click', (e) => {
		const a = e.target.closest && e.target.closest('a, button');
		if (!a) return;
		const label = (a.textContent || '').replace(/\s+/g, ' ').trim().slice(0, 80);
		if (a.matches('.phero__card, .onpage__link')) {
			send('onpage_nav', { label, source: a.matches('.phero__card') ? 'hero_card' : 'sticky_bar' });
		} else if (a.matches('[data-cta], .btn, .hdr__cta, .link')) {
			send('cta_click', { label, type: a.dataset.cta || 'link', href: a.getAttribute('href') || '', section: blockName(a.closest('.block-stream > *')) || 'header' });
		}
	}, { capture: true });
}
