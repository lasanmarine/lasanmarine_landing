// Project Index — filter the server-rendered cards by taxonomy term and by
// the words in the search box; both apply together.
import { on, cleanupAll } from '$lib/dom';
import { name, transition } from '$lib/view-transition';

export const selector = '[data-project-index]';

// Accents off, đ → d: "vo go" finds "vỏ gỗ".
const fold = (s) =>
	s
		.toLowerCase()
		.normalize('NFD')
		.replace(/[̀-ͯ]/g, '')
		.replace(/đ/g, 'd');

export default function projectIndex(root) {
	const buttons = [...root.querySelectorAll('[data-pi-filter]')];
	const items = [...root.querySelectorAll('[data-pi-item]')];
	const search = root.querySelector('[data-pi-search]');
	const empty = root.querySelector('[data-pi-empty]');
	const count = root.querySelector('[data-pi-count]');
	if (!items.length) return null;

	// Cards slide to their new places when a filter changes (typing in the
	// search box stays instant: a transition per keystroke would lag).
	name(items, 'pi');
	const haystack = new Map(items.map((item) => [item, fold(item.textContent.replace(/\s+/g, ' '))]));
	let term = '';

	// A filter or a search lifts cards that have not made their entrance yet
	// into view. They take their place with the re-flow instead of starting an
	// entrance of their own (entrances run once, on the way down the page).
	const settle = () => {
		const waiting = items.filter((el) => el.hasAttribute('data-reveal-item') && !el.classList.contains('is-revealed'));
		if (!waiting.length) return;
		waiting.forEach((el) => {
			el.style.transition = 'none';
			el.classList.add('is-revealed');
		});
		void root.offsetWidth; // commit the end state before the transitions return
		waiting.forEach((el) => el.style.removeProperty('transition'));
	};

	const apply = () => {
		settle();
		const words = fold(search?.value ?? '').split(/\s+/).filter(Boolean);
		let shown = 0;
		items.forEach((item) => {
			const terms = (item.dataset.terms || '').split(' ');
			const text = haystack.get(item);
			const match = (!term || terms.includes(term)) && words.every((w) => text.includes(w));
			item.hidden = !match;
			if (match) shown += 1;
		});
		buttons.forEach((b) => b.setAttribute('aria-pressed', String((b.dataset.piFilter || '') === term)));
		if (empty) empty.hidden = shown > 0;
		if (count) count.textContent = `${shown} ${count.dataset.label}`;
	};

	return cleanupAll([
		...buttons.map((b) =>
			on(b, 'click', () => {
				term = b.dataset.piFilter || '';
				transition(apply);
			}),
		),
		search && on(search, 'input', apply),
	]);
}
