document.querySelectorAll('[data-shaft]').forEach((form) => {
	const out = form.querySelector('[data-shaft-result]');
	const error = form.querySelector('[data-shaft-error]');

	const render = () => {
		const power = Number(form.querySelector('[data-shaft-power]')?.value);
		const rpm = Number(form.querySelector('[data-shaft-rpm]')?.value);
		const rm = Number(form.querySelector('[data-shaft-material]:checked')?.value);

		if (!(power > 0) || !(rpm > 0) || !(rm > 0)) {
			if (out) out.textContent = '—';
			if (error) {
				error.textContent = form.dataset.errorText ?? '';
				error.hidden = false;
			}
			return;
		}
		if (error) error.hidden = true;

		// d = F · k · ∛( (P/n) · 560/(Rm+160) ), with F = 100 and k = 1.0 for a
		// solid shaft without a hollow bore. Indicative only.
		const F = 100;
		const k = 1;
		const d = F * k * Math.cbrt((power / rpm) * (560 / (rm + 160)));
		if (out) out.textContent = `${d.toFixed(1)} mm`;
	};

	form.addEventListener('input', render);
	form.addEventListener('change', render);
	form.addEventListener('reset', () => window.setTimeout(render));
	render();
});
