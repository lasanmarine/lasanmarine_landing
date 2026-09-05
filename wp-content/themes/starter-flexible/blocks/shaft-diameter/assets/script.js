document.querySelectorAll('[data-shaft]').forEach((form) => {
	const out = form.querySelector('[data-shaft-result]');
	const propOut = form.querySelector('[data-shaft-prop-rpm]');
	const error = form.querySelector('[data-shaft-error]');
	const copyButtons = [...form.querySelectorAll('[data-shaft-copy]')];
	const targets = { 'prop-rpm': propOut, result: out };

	// Copied as a bare number in the *machine's* locale, so pasting into a
	// spreadsheet lands on the decimal mark that machine actually expects.
	const plain = (n) => n.toLocaleString(undefined, { maximumFractionDigits: 1, useGrouping: false });

	// Each unit select carries its own factor back to the formula's units:
	// kW for the power, rpm for the engine speed.
	const unitFactor = (selector) => {
		const select = form.querySelector(selector);
		if (!select) return 1;
		const factor = Number(select.value);
		return factor > 0 ? factor : 1;
	};

	const render = () => {
		const power =
			Number(form.querySelector('[data-shaft-power]')?.value) * unitFactor('[data-shaft-power-unit]');
		const engineRpm =
			Number(form.querySelector('[data-shaft-rpm]')?.value) * unitFactor('[data-shaft-rpm-unit]');
		const ratio = Number(form.querySelector('[data-shaft-ratio]')?.value);
		const k3 = Number(form.querySelector('[data-shaft-material]:checked')?.value);

		if (!(power > 0) || !(engineRpm > 0) || !(ratio > 0) || !(k3 > 0)) {
			if (out) {
				out.textContent = '—';
				delete out.dataset.shaftRaw;
			}
			if (propOut) {
				propOut.textContent = '—';
				delete propOut.dataset.shaftRaw;
			}
			if (error) {
				error.textContent = form.dataset.errorText ?? '';
				error.hidden = false;
			}
			copyButtons.forEach((button) => {
				button.disabled = true;
			});
			return;
		}
		if (error) error.hidden = true;

		// n = n_e / i (propeller rpm from engine rpm over the gearbox ratio),
		// then d = k3 · ∛(P/n) — per lasanmarine.com's own "Kiểm tra đường kính
		// trục chân vịt" tool and the k3 coefficient table in Site Settings.
		const n = engineRpm / ratio;
		const d = k3 * Math.cbrt(power / n);
		if (propOut) {
			propOut.textContent = `${n.toFixed(1)} rpm`;
			propOut.dataset.shaftRaw = plain(n);
		}
		if (out) {
			out.textContent = `${d.toFixed(1)} mm`;
			out.dataset.shaftRaw = plain(d);
		}
		copyButtons.forEach((button) => {
			button.disabled = false;
		});
	};

	copyButtons.forEach((button) => {
		button.addEventListener('click', async () => {
			const value = targets[button.dataset.shaftCopy]?.dataset.shaftRaw;
			if (!value) return;
			try {
				await navigator.clipboard.writeText(value);
			} catch {
				return;
			}
			button.classList.add('is-copied');
			window.clearTimeout(button._shaftCopyTimeout);
			button._shaftCopyTimeout = window.setTimeout(() => button.classList.remove('is-copied'), 1400);
		});
	});

	form.addEventListener('input', render);
	form.addEventListener('change', render);
	form.addEventListener('reset', () => window.setTimeout(render));
	render();
});
