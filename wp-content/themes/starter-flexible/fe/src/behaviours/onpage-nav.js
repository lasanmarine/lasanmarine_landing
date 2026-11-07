// Sub-pages get a slim "on this page" bar pinned under the header once the
// page hero has scrolled away. The sections are read from the blocks below
// the hero (layer-cake scanning: users navigate by headings), then the bar
// itself is the OnPageNav island, mounted right after the hero.
import { mountIsland } from '../runtime/islands';
import { slugify } from '../lib/slug';
import { isEnglish } from '../lib/i18n';

export const selector = '.block-stream > .lasanmarine-page-hero';

const MAX = 5;
const text = (el) => el.textContent.replace(/\s+/g, ' ').trim();

export default function onpageNav(hero) {
	if (!hero.querySelector('.phero__body') || document.querySelector('.onpage')) return null;

	const items = [];
	for (let el = hero.nextElementSibling; el && items.length < MAX; el = el.nextElementSibling) {
		if (el.matches('.lasanmarine-contact-statement, .lasanmarine-cta-banner')) continue;
		const h = el.querySelector('h2, h3');
		const title = h ? text(h) : '';
		if (!title) continue;
		if (!el.id) el.id = slugify(title) || `muc-${items.length + 1}`;
		items.push({ id: el.id, title });
	}
	if (items.length < 2) return null;

	const en = isEnglish();
	// The bar is part of the header pill: it opens as a second row of the
	// stuck header, so the two read as one piece.
	const bar = document.querySelector('[data-hdr-bar]');
	const host = document.createElement('div');
	host.style.display = 'contents';
	if (bar) bar.append(host);
	else hero.after(host);

	let destroy = null;
	let gone = false;
	mountIsland('OnPageNav', host, {
		hero,
		items,
		ariaLabel: en ? 'Sections on this page' : 'Các phần trong trang',
	}).then((fn) => {
		if (gone) fn?.();
		else destroy = fn;
	});

	return () => {
		gone = true;
		destroy?.();
		host.remove();
	};
}
