document.querySelectorAll('[data-shaft]').forEach((form) => {
	const out = form.querySelector('[data-shaft-result]');
	const error = form.querySelector('[data-shaft-error]');

	const render = () => {
		const power = Number(form.querySelector('[data-shaft-power]')?.value);
		const rpm = Number(form.querySelector('[data-shaft-rpm]')?.value);
		const k3 = Number(form.querySelector('[data-shaft-material]:checked')?.value);

		if (!(power > 0) || !(rpm > 0) || !(k3 > 0)) {
			if (out) out.textContent = '—';
			if (error) {
				error.textContent = form.dataset.errorText ?? '';
				error.hidden = false;
			}
			return;
		}
		if (error) error.hidden = true;

		// d = k3 · ∛(P/n), per the class-society coefficient table in Site
		// Settings → Tools → Vật liệu trục chân vịt. Indicative only.
		const d = k3 * Math.cbrt(power / rpm);
		if (out) out.textContent = `${d.toFixed(1)} mm`;
	};

	form.addEventListener('input', render);
	form.addEventListener('change', render);
	form.addEventListener('reset', () => window.setTimeout(render));
	render();
});
