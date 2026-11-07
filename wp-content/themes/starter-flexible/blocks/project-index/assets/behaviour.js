// Project Index — filter the server-rendered cards by taxonomy term and by
// the words in the search box; both apply together.
import { on, cleanupAll } from '$lib/dom';

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

	const haystack = new Map(items.map((item) => [item, fold(item.textContent.replace(/\s+/g, ' '))]));
	let term = '';

	const apply = () => {
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
				apply();
			}),
		),
		search && on(search, 'input', apply),
	]);
}
