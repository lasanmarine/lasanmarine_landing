document.querySelectorAll('[data-power]').forEach((form) => {
	const holder = form.querySelector('[data-power-units]');
	if (!holder?.textContent) return;
	const units = JSON.parse(holder.textContent);
	const input = form.querySelector('[data-power-value]');
	const select = form.querySelector('[data-power-unit]');

	const format = (n) =>
		n.toLocaleString(document.documentElement.lang === 'en' ? 'en-US' : 'vi-VN', {
			maximumFractionDigits: 2,
		});

	const render = () => {
		const raw = Number(input?.value);
		const from = units.find((u) => u.id === select?.value);
		const valid = Number.isFinite(raw) && raw >= 0 && from;
		// Everything converts through kW as the base unit.
		const kw = valid ? raw * from.factor : NaN;

		for (const unit of units) {
			const cell = form.querySelector(`[data-power-out="${unit.id}"]`);
			if (cell) cell.textContent = valid ? format(kw / unit.factor) : '—';
		}
	};

	input?.addEventListener('input', render);
	select?.addEventListener('change', render);
	form.addEventListener('reset', () => window.setTimeout(render));
	render();
});
