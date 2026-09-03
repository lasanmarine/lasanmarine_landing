// Header behaviour: measured height, mega panel, sticky bar, mobile drawer.

export function initHeader() {
	const bar = document.querySelector('[data-hdr-bar]');
	const burger = document.querySelector('[data-burger]');
	const drawer = document.querySelector('[data-drawer]');

	// Publish the header's real height so the mega panel can size itself to the
	// space that is actually left below it.
	const header = document.querySelector('[data-header]');
	const syncHeight = () => {
		if (header) {
			document.documentElement.style.setProperty('--hdr-h', `${header.offsetHeight}px`);
		}
	};
	syncHeight();
	window.addEventListener('resize', syncHeight);
	if (header) new ResizeObserver(syncHeight).observe(header);

	// The mega panel's figure follows whichever service row is hovered.
	document.querySelectorAll('[data-mega-panel]').forEach((panel) => {
		const rows = panel.querySelectorAll('[data-mega-row]');
		const slides = panel.querySelectorAll('[data-mega-slide]');
		rows.forEach((row) => {
			const on = () => {
				rows.forEach((r) => r.setAttribute('data-active', String(r === row)));
				slides.forEach((sl) =>
					sl.setAttribute('data-active', String(sl.dataset.i === row.dataset.i)),
				);
			};
			row.addEventListener('mouseenter', on);
			row.addEventListener('focus', on);
		});
	});

	// The bar only turns opaque once the hero has scrolled past its own height.
	const sync = () => bar?.classList.toggle('is-stuck', window.scrollY > 24);
	sync();
	window.addEventListener('scroll', sync, { passive: true });

	// The drawer animates, so it stays in the tree and is toggled by attribute.
	// `inert` keeps it out of the tab order and off screen readers while closed.
	const setDrawer = (open) => {
		burger?.setAttribute('aria-expanded', String(open));
		drawer?.setAttribute('data-open', String(open));
		if (drawer) drawer.inert = !open;
		document.documentElement.toggleAttribute('data-nav-open', open);
		document.body.style.overflow = open ? 'hidden' : '';
		if (open) drawer?.querySelector('.drawer__nav a')?.focus();
		else burger?.focus();
	};

	const isOpen = () => drawer?.getAttribute('data-open') === 'true';

	burger?.addEventListener('click', () => setDrawer(!isOpen()));

	drawer?.addEventListener('click', (e) => {
		if (e.target.closest('a')) setDrawer(false);
	});

	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape' && isOpen()) setDrawer(false);
	});

	// A resize past the breakpoint leaves the drawer open over the desktop nav.
	window.matchMedia('(min-width: 1081px)').addEventListener('change', (e) => {
		if (e.matches && isOpen()) setDrawer(false);
	});
}
