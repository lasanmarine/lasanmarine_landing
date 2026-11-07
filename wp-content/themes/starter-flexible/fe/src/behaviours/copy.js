// Copy-to-clipboard buttons in server markup (the footer's tax code and
// account number): `data-copy` holds the value, `[data-copy-label]` inside
// swaps to `data-copied` for a moment.
import { copyText } from '../lib/clipboard';
import { on } from '../lib/dom';

export const selector = '[data-copy]';

export default function copy(btn) {
	const label = btn.querySelector('[data-copy-label]');
	const original = label?.textContent ?? '';
	let timer = 0;

	const off = on(btn, 'click', async () => {
		if (!(await copyText(btn.dataset.copy ?? ''))) return;
		if (label) label.textContent = btn.dataset.copied ?? original;
		btn.dataset.state = 'done';
		clearTimeout(timer);
		timer = setTimeout(() => {
			if (label) label.textContent = original;
			delete btn.dataset.state;
		}, 1800);
	});

	return () => {
		off();
		clearTimeout(timer);
	};
}
