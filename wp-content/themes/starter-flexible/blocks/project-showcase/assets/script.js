document.querySelectorAll('[data-showcase]').forEach((root) => {
	const holder = root.parentElement?.querySelector('[data-ps-data]');
	if (!holder?.textContent) return;
	const items = JSON.parse(holder.textContent);
	const slides = root.querySelectorAll('[data-ps-slide]');
	const pad = (n) => String(n).padStart(2, '0');
	let at = 0;

	const fields = ['tag', 'name', 'location', 'year', 'service'];

	const render = () => {
		const item = items[at];
		slides.forEach((s, i) => s.setAttribute('data-active', String(i === at)));
		for (const key of fields) {
			const el = root.querySelector(`[data-ps-${key}]`);
			if (el) el.textContent = item[key];
		}
		const counter = root.querySelector('[data-ps-counter]');
		if (counter) counter.textContent = `${pad(at + 1)} / ${pad(items.length)}`;
	};

	root.querySelector('[data-ps-prev]')?.addEventListener('click', () => {
		at = (at - 1 + items.length) % items.length;
		render();
	});
	root.querySelector('[data-ps-next]')?.addEventListener('click', () => {
		at = (at + 1) % items.length;
		render();
	});
});
