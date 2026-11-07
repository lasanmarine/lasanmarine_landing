// Card rows that become sliders.
//
// Put `data-slider` on a row of cards (optionally `data-slider-min="3"`: the
// smallest count that turns it into a slider; fewer stay a plain grid). The
// row becomes a native horizontal scroller with snap points — touch, trackpad
// and keys all work — and gets previous / next buttons, inserted just before
// it, that step one card and switch off at either end.
import { on, cleanupAll } from '../lib/dom';
import { isEnglish } from '../lib/i18n';

export const selector = '[data-slider]';

const ICON = (d) =>
	`<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="${d}"/></svg>`;

export default function slider(track) {
	const min = Number(track.dataset.sliderMin) || 3;
	if (track.children.length <= min) return null;

	const en = isEnglish();
	track.classList.add('is-slider');

	const nav = document.createElement('div');
	nav.className = 'slider-nav';
	nav.innerHTML =
		`<button type="button" class="icon-btn" data-dir="-1" aria-label="${en ? 'Previous' : 'Trước'}">${ICON('M15.75 19.5 8.25 12l7.5-7.5')}</button>` +
		`<button type="button" class="icon-btn" data-dir="1" aria-label="${en ? 'Next' : 'Sau'}">${ICON('m8.25 4.5 7.5 7.5-7.5 7.5')}</button>`;
	track.before(nav);
	const [prev, next] = nav.querySelectorAll('button');

	const step = () => {
		const card = track.firstElementChild;
		const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
		return card ? card.getBoundingClientRect().width + gap : track.clientWidth;
	};

	const sync = () => {
		const max = track.scrollWidth - track.clientWidth - 2;
		prev.disabled = track.scrollLeft <= 2;
		next.disabled = track.scrollLeft >= max;
		nav.hidden = max <= 0;
	};

	sync();
	const ro = new ResizeObserver(sync);
	ro.observe(track);

	return cleanupAll([
		on(nav, 'click', (e) => {
			const btn = e.target.closest('button');
			if (btn) track.scrollBy({ left: step() * Number(btn.dataset.dir), behavior: 'smooth' });
		}),
		on(track, 'scroll', sync, { passive: true }),
		() => {
			ro.disconnect();
			nav.remove();
			track.classList.remove('is-slider');
		},
	]);
}
