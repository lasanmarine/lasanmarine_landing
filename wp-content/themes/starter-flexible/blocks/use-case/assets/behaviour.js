// Use Case — a slider of cases. The track is a native horizontal scroller
// with snap points (touch, trackpad and keyboard all work as is); the arrows
// step one card and switch off at either end.
import { on, cleanupAll } from '$lib/dom';

export const selector = '[data-use-case]';

export default function useCaseSlider(root) {
	const track = root.querySelector('[data-uc-track]');
	const prev = root.querySelector('[data-uc-prev]');
	const next = root.querySelector('[data-uc-next]');
	if (!track || !prev || !next) return null;

	const step = () => {
		const card = track.firstElementChild;
		const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
		return card ? card.getBoundingClientRect().width + gap : track.clientWidth;
	};

	const sync = () => {
		const max = track.scrollWidth - track.clientWidth - 2;
		prev.disabled = track.scrollLeft <= 2;
		next.disabled = track.scrollLeft >= max;
		root.classList.toggle('uc--static', max <= 0);
	};

	sync();
	const ro = new ResizeObserver(sync);
	ro.observe(track);

	return cleanupAll([
		on(prev, 'click', () => track.scrollBy({ left: -step(), behavior: 'smooth' })),
		on(next, 'click', () => track.scrollBy({ left: step(), behavior: 'smooth' })),
		on(track, 'scroll', sync, { passive: true }),
		() => ro.disconnect(),
	]);
}
