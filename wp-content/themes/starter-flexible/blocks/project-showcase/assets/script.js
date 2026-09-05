// Project Showcase — a one-per-view slider. The track slides; each slide
// carries its own caption and button, so nothing has to be swapped in place.
document.querySelectorAll('[data-showcase]').forEach((root) => {
	const track = root.querySelector('[data-ps-track]');
	const slides = [...root.querySelectorAll('[data-ps-slide]')];
	const dots = [...root.querySelectorAll('[data-ps-dot]')];
	const counter = root.querySelector('[data-ps-counter]');
	if (!track || slides.length < 2) return;

	const pad = (n) => String(n).padStart(2, '0');
	let at = 0;

	const render = () => {
		track.style.transform = `translateX(-${at * 100}%)`;
		slides.forEach((slide, i) => {
			slide.setAttribute('aria-hidden', String(i !== at));
			// Off-screen slides stay out of the tab order, or focus jumps to
			// a card nobody can see.
			slide.querySelectorAll('a, button').forEach((el) => {
				el.tabIndex = i === at ? 0 : -1;
			});
		});
		dots.forEach((dot, i) => dot.setAttribute('aria-selected', String(i === at)));
		if (counter) counter.textContent = `${pad(at + 1)} / ${pad(slides.length)}`;
	};

	const go = (next) => {
		at = (next + slides.length) % slides.length;
		render();
	};

	root.querySelector('[data-ps-prev]')?.addEventListener('click', () => go(at - 1));
	root.querySelector('[data-ps-next]')?.addEventListener('click', () => go(at + 1));
	dots.forEach((dot, i) => dot.addEventListener('click', () => go(i)));

	root.addEventListener('keydown', (event) => {
		if (event.key === 'ArrowLeft') go(at - 1);
		if (event.key === 'ArrowRight') go(at + 1);
	});

	// Swipe on touch, with a threshold so a scroll gesture is not read as one.
	let startX = null;
	track.addEventListener('touchstart', (e) => { startX = e.touches[0].clientX; }, { passive: true });
	track.addEventListener('touchend', (e) => {
		if (startX === null) return;
		const dx = e.changedTouches[0].clientX - startX;
		if (Math.abs(dx) > 50) go(dx < 0 ? at + 1 : at - 1);
		startX = null;
	});

	render();
});
