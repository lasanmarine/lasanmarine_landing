// Project Index — filter the grid by taxonomy term, entirely on the client.
document.querySelectorAll('[data-project-index]').forEach((root) => {
	const buttons = [...root.querySelectorAll('[data-pi-filter]')];
	const items = [...root.querySelectorAll('[data-pi-item]')];
	const empty = root.querySelector('[data-pi-empty]');
	const count = root.querySelector('[data-pi-count]');
	if (!buttons.length || !items.length) return;

	const apply = (term) => {
		let shown = 0;
		items.forEach((item) => {
			const terms = (item.dataset.terms || '').split(' ').filter(Boolean);
			const match = !term || terms.includes(term);
			item.hidden = !match;
			if (match) shown += 1;
		});
		buttons.forEach((button) => {
			button.setAttribute('aria-pressed', String((button.dataset.piFilter || '') === term));
		});
		if (empty) empty.hidden = shown > 0;
		if (count) count.textContent = `${shown} ${count.dataset.label}`;
	};

	buttons.forEach((button) => {
		button.addEventListener('click', () => apply(button.dataset.piFilter || ''));
	});
});
