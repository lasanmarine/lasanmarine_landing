// Sticky "on this page" bar for sub-pages (the hero summary cards were retired).
//
// Sub-pages are task pages, so they scroll natively. The hero carries a row of
// summary cards — one per main section (its heading + a one-line gist), built
// from the blocks below the hero so every sub-page gets them without extra
// content. They arrive with a short staggered entrance on load. Once the hero
// has scrolled away, the same sections stay reachable from a slim bar pinned
// under the header that highlights the section being read (layer-cake scanning:
// users navigate by headings).

function slug(s) {
	return s.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/đ/g, 'd')
		.replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '').slice(0, 40);
}

function clean(el) {
	return el.textContent.replace(/\s+/g, ' ').trim();
}

function gist(el) {
	const p = el.querySelector('.copy, .lead, .prose p, p');
	let t = p ? clean(p) : '';
	if (!t) {
		// No paragraph: summarise by the names of its items instead.
		t = [...el.querySelectorAll('h3, h4')].map(clean).filter(Boolean).slice(0, 4).join(' · ');
	}
	return t.length > 90 ? `${t.slice(0, 88).replace(/\s+\S*$/, '')}…` : t;
}

export function initHeroCards() {
	const hero = document.querySelector('.block-stream > .lasanmarine-page-hero');
	const body = hero && hero.querySelector('.phero__body');
	if (!hero || !body || document.querySelector('.onpage')) return;

	const items = [];
	for (let el = hero.nextElementSibling; el && items.length < 5; el = el.nextElementSibling) {
		if (el.matches('.lasanmarine-contact-statement, .lasanmarine-cta-banner')) continue;
		const h = el.querySelector('h2, h3');
		const title = h ? clean(h) : '';
		if (!title) continue;
		if (!el.id) el.id = slug(title) || `muc-${items.length + 1}`;
		items.push({ el, id: el.id, title, gist: gist(el) });
	}
	if (items.length < 2) return;
	const en = (document.documentElement.lang || '').startsWith('en');

	// --- sticky "on this page" bar ---
	const bar = document.createElement('nav');
	bar.className = 'onpage';
	bar.setAttribute('aria-label', en ? 'Sections on this page' : 'Các phần trong trang');
	bar.innerHTML = '<div class="container onpage__in"><span class="onpage__label"></span><div class="onpage__list"></div></div>';
	bar.querySelector('.onpage__label').textContent = en ? 'On this page' : 'Trong trang';
	const list = bar.querySelector('.onpage__list');
	const links = items.map((it) => {
		const a = document.createElement('a');
		a.className = 'onpage__link';
		a.href = `#${it.id}`;
		a.textContent = it.title;
		list.appendChild(a);
		return a;
	});
	hero.after(bar);

	// Show the bar once the reader has moved past most of the hero. Measured by
	// scroll distance: a stacked (pinned) hero never leaves the viewport.
	const toggleBar = () => {
		bar.classList.toggle('is-shown', window.scrollY > hero.offsetHeight * 0.6);
	};
	window.addEventListener('scroll', toggleBar, { passive: true });
	toggleBar();

	// Highlight the section in the upper part of the screen.
	const active = new Map();
	const io = new IntersectionObserver((entries) => {
		entries.forEach((e) => active.set(e.target, e.isIntersecting));
		// Stacked sheets stay pinned under the newer ones, so the section being
		// read is the last one in view, not the first.
		const cur = [...items].reverse().find((it) => active.get(it.el));
		links.forEach((a, i) => {
			const on = !!cur && items[i] === cur;
			a.classList.toggle('is-active', on);
			if (on) {
				a.setAttribute('aria-current', 'true');
				// Keep the active chip visible in the scrollable row (phones).
				const l = a.offsetLeft - list.clientWidth / 2 + a.offsetWidth / 2;
				list.scrollTo({ left: Math.max(0, l), behavior: 'smooth' });
			} else {
				a.removeAttribute('aria-current');
			}
		});
	}, { rootMargin: '-30% 0px -60% 0px' });
	items.forEach((it) => io.observe(it.el));
}
