document.querySelectorAll('.geo').forEach((root) => {
	const rows = root.querySelectorAll('[data-geo-row]');
	const pins = root.querySelectorAll('[data-geo-pin]');

	const show = (i) => {
		rows.forEach((r) => r.setAttribute('data-active', String(r.dataset.i === i)));
		pins.forEach((p) => p.setAttribute('data-active', String(p.dataset.i === i)));
	};

	rows.forEach((row) => {
		const on = () => show(row.dataset.i ?? '0');
		row.addEventListener('mouseenter', on);
		row.addEventListener('focus', on);
		row.addEventListener('click', on);
	});
});
