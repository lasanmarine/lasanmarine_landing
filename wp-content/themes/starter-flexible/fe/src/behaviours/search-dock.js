// Search dock: once a list's search box has scrolled away under the header,
// a compact copy of it — and of the filter chips beside it — opens as the
// header pill's second row. Typing or picking a chip there drives the
// original controls, so the list's own behaviour does all the filtering.
import { on, cleanupAll } from '../lib/dom';
import { viewport } from '../lib/stores/viewport.svelte.js';

export const selector = '[data-merge-search]';

export default function searchDock(label) {
	const input = label.querySelector('input');
	const bar = document.querySelector('[data-hdr-bar]');
	const root = label.closest('[data-project-index]') || label.parentElement;
	if (!input || !bar || bar.querySelector('.hdr-dock')) return null;
	const chips = [...root.querySelectorAll('[data-pi-filter]')];

	const dock = document.createElement('div');
	dock.className = 'hdr-dock';
	dock.innerHTML = `<div class="hdr-dock__in"><div class="hdr-dock__row">
		<label class="hdr-dock__search">${label.querySelector('svg')?.outerHTML ?? ''}<input type="search" autocomplete="off" tabindex="-1"></label>
		<div class="hdr-dock__chips" role="group"></div>
	</div></div>`;
	const copy = dock.querySelector('input');
	copy.placeholder = input.placeholder;
	copy.setAttribute('aria-label', input.placeholder);
	const group = dock.querySelector('.hdr-dock__chips');
	const twins = chips.map((chip) => {
		const b = document.createElement('button');
		b.type = 'button';
		b.className = 'hdr-dock__chip';
		b.textContent = chip.textContent.trim();
		b.tabIndex = -1;
		group.append(b);
		return b;
	});
	bar.append(dock);

	const syncChips = () =>
		twins.forEach((b, i) => b.setAttribute('aria-pressed', chips[i].getAttribute('aria-pressed') || 'false'));
	syncChips();

	const setShown = (shown) => {
		if (dock.classList.contains('is-shown') === shown) return;
		dock.classList.toggle('is-shown', shown);
		copy.tabIndex = shown ? 0 : -1;
		twins.forEach((b) => (b.tabIndex = shown ? 0 : -1));
	};

	return cleanupAll([
		viewport.subscribe(() => {
			const hdr = viewport.hdrH || 76;
			const r = root.getBoundingClientRect();
			// Out of view above, while the list itself is still on screen.
			setShown(label.getBoundingClientRect().bottom < hdr && r.bottom > hdr + 160);
		}),
		on(copy, 'input', () => {
			input.value = copy.value;
			input.dispatchEvent(new Event('input', { bubbles: true }));
		}),
		on(input, 'input', () => {
			if (copy.value !== input.value) copy.value = input.value;
		}),
		...twins.map((b, i) =>
			on(b, 'click', () => {
				chips[i].click();
				syncChips();
				// Bring the list's top into view so the result is seen.
				const y = root.getBoundingClientRect().top + window.scrollY - (viewport.hdrH || 76) - 24;
				if (window.scrollY > y) window.scrollTo({ top: y, behavior: 'smooth' });
			}),
		),
		...chips.map((c) => on(c, 'click', syncChips)),
		() => dock.remove(),
	]);
}
