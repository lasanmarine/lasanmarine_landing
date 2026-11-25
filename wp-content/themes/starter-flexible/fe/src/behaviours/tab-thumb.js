// A sliding highlight under a row of tabs or filter pills.
//
// The selected pill used to switch its own background on and off, so the
// highlight jumped. Here one "thumb" lives behind the row and moves to the
// selected pill — position and size together, on the site's spring curve
// (--spring-soft: a small, damped overshoot, so it reads as one object that
// travelled, not two that blinked). The row may wrap, so it moves in x and y.
//
// Works for any row whose selected item says so in ARIA or data: the on-page
// bar (aria-current), Project Index and Insights filters (aria-pressed),
// Document Center (data-active).
import { on, cleanupAll } from '../lib/dom';

export const selector = '.onpage__list, .pi__filters, [data-doc-filters]';

const ACTIVE = '[aria-current="true"], [aria-pressed="true"], [data-active="true"], [aria-selected="true"]';

export default function tabThumb(row) {
	const thumb = document.createElement('span');
	thumb.className = 'tab-thumb';
	thumb.setAttribute('aria-hidden', 'true');

	// The thumb takes the selected pill's own colour, read before the pills
	// hand their background over to it.
	const first = row.querySelector(ACTIVE);
	if (first) {
		const bg = getComputedStyle(first).backgroundColor;
		if (bg && !/rgba\(0, 0, 0, 0\)|transparent/.test(bg)) row.style.setProperty('--thumb-bg', bg);
		row.style.setProperty('--thumb-r', getComputedStyle(first).borderRadius);
	}
	row.prepend(thumb);
	row.classList.add('has-tab-thumb');

	let placed = false;
	const place = (animate) => {
		const el = row.querySelector(ACTIVE);
		if (!el || !el.offsetWidth) {
			thumb.classList.remove('is-on');
			return;
		}
		// offset* are relative to the row (position: relative), so a wrapped
		// second line is just a larger y.
		thumb.classList.toggle('is-still', !animate || !placed);
		thumb.style.transform = `translate(${el.offsetLeft}px, ${el.offsetTop}px)`;
		thumb.style.width = `${el.offsetWidth}px`;
		thumb.style.height = `${el.offsetHeight}px`;
		thumb.classList.add('is-on');
		placed = true;
	};

	place(false);

	// Selection changes arrive as attribute changes, whoever makes them (a
	// behaviour, or the Svelte island of the on-page bar).
	// (The thumb's own class changes are ignored, or placing it would loop.)
	const mo = new MutationObserver((records) => {
		if (records.some((r) => r.target !== thumb)) place(true);
	});
	mo.observe(row, { subtree: true, attributes: true, attributeFilter: ['aria-current', 'aria-pressed', 'data-active', 'aria-selected', 'class'], childList: true });
	// A new line break or font load moves the pills: follow without animating.
	const ro = new ResizeObserver(() => place(false));
	ro.observe(row);

	return cleanupAll([
		() => mo.disconnect(),
		() => ro.disconnect(),
		on(window, 'load', () => place(false)),
		() => {
			thumb.remove();
			row.classList.remove('has-tab-thumb');
			row.style.removeProperty('--thumb-bg');
			row.style.removeProperty('--thumb-r');
		},
	]);
}
