// Copy-to-clipboard for the tax code and the account number.

export function initFooter() {
	document.querySelectorAll('[data-copy]').forEach((btn) => {
		const label = btn.querySelector('[data-copy-label]');
		const original = label?.textContent ?? '';

		btn.addEventListener('click', async () => {
			const value = btn.dataset.copy ?? '';
			// The site is served over https, where the Clipboard API is available;
			// if it is ever blocked the button simply does nothing rather than
			// falling back to the deprecated execCommand path.
			try {
				await navigator.clipboard.writeText(value);
			} catch {
				return;
			}

			if (label) label.textContent = btn.dataset.copied ?? original;
			btn.dataset.state = 'done';
			window.setTimeout(() => {
				if (label) label.textContent = original;
				delete btn.dataset.state;
			}, 1800);
		});
	});
}
