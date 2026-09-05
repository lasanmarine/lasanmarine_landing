document.querySelectorAll('[data-power]').forEach((form) => {
	const holder = form.querySelector('[data-power-units]');
	if (!holder?.textContent) return;
	const units = JSON.parse(holder.textContent);
	const input = form.querySelector('[data-power-value]');
	const choices = form.querySelectorAll('[data-power-unit]');
	const error = form.querySelector('[data-power-error]');
	const precisionInput = form.querySelector('[data-power-precision]');
	if (!input || !units.length) return;
	const cells = [...form.querySelectorAll('[data-power-out]')];
	const rows = [...form.querySelectorAll('[data-power-row]')];
	const copyButtons = [...form.querySelectorAll('[data-power-copy]')];
	const locale = document.documentElement.lang.toLowerCase().startsWith('en') ? 'en-US' : 'vi-VN';
	const precisionOf = () => Math.min(6, Math.max(0, Number(precisionInput?.value) || 0));
	const format = (n) => n.toLocaleString(locale, { maximumFractionDigits: precisionOf() });
	// Copied as a bare number in the *machine's* locale, so pasting into a
	// spreadsheet lands on the decimal mark that machine actually expects.
	const formatPlain = (n) =>
		n.toLocaleString(undefined, { maximumFractionDigits: precisionOf(), useGrouping: false });

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
			if (!cell) continue;
			cell.textContent = valid ? format(kw / unit.factor) : '—';
			if (valid) {
				cell.dataset.powerRaw = formatPlain(kw / unit.factor);
			} else {
				delete cell.dataset.powerRaw;
			}
		}
		copyButtons.forEach((button) => {
			button.disabled = !valid;
		});
		rows.forEach((row) => row.classList.toggle('is-source', row.dataset.powerRow === from?.id));
	};

	copyButtons.forEach((button) => {
		button.addEventListener('click', async () => {
			const cell = cells.find((el) => el.dataset.powerOut === button.dataset.powerCopy);
			const value = cell?.dataset.powerRaw;
			if (!value) return;
			try {
				await navigator.clipboard.writeText(value);
			} catch {
				return;
			}
			button.classList.add('is-copied');
			window.clearTimeout(button._powerCopyTimeout);
			button._powerCopyTimeout = window.setTimeout(() => button.classList.remove('is-copied'), 1400);
		});
	});

	input.addEventListener('input', render);
	precisionInput?.addEventListener('input', render);
	choices.forEach((choice) => choice.addEventListener('change', render));
	form.addEventListener('submit', (event) => event.preventDefault());
	form.addEventListener('reset', () => window.setTimeout(render));
	render();
});
