document.querySelectorAll('[data-timeline]').forEach((track) => {
	const fill = track.querySelector('[data-timeline-fill]');
	if (!fill) return;
	const vertical = () => window.matchMedia('(max-width: 640px)').matches;

	// Fills in step with how far the block has travelled through the viewport.
	const update = () => {
		const r = track.getBoundingClientRect();
		const progress = (window.innerHeight * 0.75 - r.top) / Math.max(r.height, 1);
		const pct = Math.min(Math.max(progress, 0), 1) * 100;
		if (vertical()) {
			fill.style.height = `${pct}%`;
			fill.style.width = '';
		} else {
			fill.style.width = `${pct}%`;
			fill.style.height = '';
		}
		track.classList.toggle('pt--lit', pct > 4);
	};

	update();
	window.addEventListener('scroll', update, { passive: true });
	window.addEventListener('resize', update);
});
