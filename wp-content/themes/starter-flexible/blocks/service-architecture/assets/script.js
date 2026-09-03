document.querySelectorAll('[data-service-arch]').forEach((root) => {
	const rows = root.querySelectorAll('[data-service-row]');
	const slides = root.querySelectorAll('[data-service-slide]');

	const show = (i) => {
		rows.forEach((r) => r.setAttribute('data-active', String(r.dataset.i === i)));
		slides.forEach((s) => s.setAttribute('data-active', String(s.dataset.i === i)));
	};

	rows.forEach((row) => {
		row.addEventListener('mouseenter', () => show(row.dataset.i ?? '0'));
		row.addEventListener('focus', () => show(row.dataset.i ?? '0'));
	});
});
