document.querySelectorAll('[data-power]').forEach((form) => {
	const holder = form.querySelector('[data-power-units]');
	if (!holder?.textContent) return;
	const units = JSON.parse(holder.textContent);
	const input = form.querySelector('[data-power-value]');
	const choices = form.querySelectorAll('[data-power-unit]');
	const error = form.querySelector('[data-power-error]');
	if (!input || !units.length) return;
	const cells = [...form.querySelectorAll('[data-power-out]')];
	const rows = [...form.querySelectorAll('[data-power-row]')];
	const locale = document.documentElement.lang.toLowerCase().startsWith('en') ? 'en-US' : 'vi-VN';
	const format = (n) => n.toLocaleString(locale, { maximumFractionDigits: 2 });

	const render = () => {
		const raw = Number(input.value);
		const selected = form.querySelector('[data-power-unit]:checked');
		const from = units.find((u) => u.id === selected?.value);
		const kw = raw * (from?.factor ?? NaN);
		const valid = input.value.trim() !== '' && Number.isFinite(raw) && raw >= 0 &&
			units.every((u) => u.factor > 0 && Number.isFinite(kw / u.factor));
		input.setAttribute('aria-invalid', String(!valid));
		if (error) error.hidden = valid;
		for (const unit of units) {
			const cell = cells.find((el) => el.dataset.powerOut === unit.id);
			if (cell) cell.textContent = valid ? format(kw / unit.factor) : '—';
		}
		rows.forEach((row) => row.classList.toggle('is-source', row.dataset.powerRow === from?.id));
	};

	input.addEventListener('input', render);
	choices.forEach((choice) => choice.addEventListener('change', render));
	form.addEventListener('submit', (event) => event.preventDefault());
	form.addEventListener('reset', () => window.setTimeout(render));
	render();
});
