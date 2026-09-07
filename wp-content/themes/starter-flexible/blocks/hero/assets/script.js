// Hero — turning the slides.
//
// The photograph, the headline and the lead are three separate stacks of
// panels, all carrying the same `data-hero-panel` index, so one number moves
// all of them at once. A hero with a single slide never gets `data-hero` and
// so never reaches this file.
document.querySelectorAll('[data-hero]').forEach((hero) => {
	const dots = [...hero.querySelectorAll('[data-hero-dot]')];
	const panels = [...hero.querySelectorAll('[data-hero-panel]')];
	if (dots.length < 2) return;

	const stillness = window.matchMedia('(prefers-reduced-motion: reduce)');
	const delay = Number(hero.dataset.heroAutoplay) || 0;

	// Autoplay runs unless something says otherwise: focus inside the hero — a
	// keyboard user must not have the slide move out from under them — a
	// backgrounded tab, or a request for less motion. Hovering does not stop
	// it: nothing under the pointer moves, so there is nothing to protect.
	const holds = new Set();
	let index = 0;
	let timer = 0;

	const turning = () => delay > 0 && !stillness.matches && holds.size === 0;

	/** The sweep has to be rewound before it can run again, or it jumps. */
	const restartFill = (dot, ms) => {
		const fill = dot.querySelector('.hero__dot-fill');
		if (!fill) return;
		dot.classList.toggle('is-static', !ms);
		dot.style.setProperty('--hero-dot-ms', `${ms || 620}ms`);
		fill.style.transition = 'none';
		fill.style.transform = 'scaleX(0)';
		void fill.offsetWidth; // forces the rewind to land before the sweep
		fill.style.transition = '';
		fill.style.transform = ''; // back to the stylesheet, which fills it
	};

	const show = (next) => {
		index = (next + dots.length) % dots.length;

		panels.forEach((panel) => {
			const current = Number(panel.dataset.heroPanel) === index;
			panel.classList.toggle('is-current', current);
			panel.setAttribute('aria-hidden', current ? 'false' : 'true');
		});

		dots.forEach((dot, i) => {
			const current = i === index;
			dot.classList.toggle('is-current', current);
			dot.setAttribute('aria-selected', current ? 'true' : 'false');
			if (current) restartFill(dot, turning() ? delay : 0);
		});
	};

	const stop = () => {
		window.clearTimeout(timer);
		timer = 0;
	};

	const schedule = () => {
		stop();
		if (!turning()) return;
		timer = window.setTimeout(() => {
			show(index + 1);
			schedule();
		}, delay);
	};

	const hold = (reason, on) => {
		const before = turning();
		holds[on ? 'add' : 'delete'](reason);
		if (turning() === before) return;
		show(index);
		schedule();
	};

	hero.addEventListener('focusin', () => hold('focus', true));
	hero.addEventListener('focusout', () => {
		if (!hero.contains(document.activeElement)) hold('focus', false);
	});
	document.addEventListener('visibilitychange', () => hold('hidden', document.hidden));

	stillness.addEventListener('change', () => {
		show(index);
		schedule();
	});

	dots.forEach((dot, i) => {
		dot.addEventListener('click', () => {
			show(i);
			schedule();
		});
	});

	// Left and right move between slides once a dot has the focus.
	hero.querySelector('.hero__dots')?.addEventListener('keydown', (event) => {
		const step = { ArrowLeft: -1, ArrowRight: 1 }[event.key];
		if (!step) return;
		event.preventDefault();
		show(index + step);
		dots[index].focus();
		schedule();
	});

	show(0);
	schedule();
});
