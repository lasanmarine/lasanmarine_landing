// Header behaviour: measured height, sticky bar, the bar's dropdown panels and
// the full-screen nav that stands in for them on a narrow screen.
//
// A top-level item with children opens its panel on hover; the same item also
// opens it on the first tap or click, and only navigates on the second, so a
// touch device — which has no hover to give — can still reach the children.

export function initHeader() {
	const bar = document.querySelector('[data-hdr-bar]');
	const header = document.querySelector('[data-header]');
	const toggle = document.querySelector('[data-nav-toggle]');
	const nav = document.querySelector('[data-nav]');

	// Publish the header's real height so the overlay can start below the bar.
	const syncHeight = () => {
		if (header) {
			document.documentElement.style.setProperty('--hdr-h', `${header.offsetHeight}px`);
		}
	};
	syncHeight();
	window.addEventListener('resize', syncHeight);
	if (header) new ResizeObserver(syncHeight).observe(header);

	// The bar only turns opaque once the page has scrolled past the hero's top.
	const syncStuck = () => bar?.classList.toggle('is-stuck', window.scrollY > 24);
	syncStuck();
	window.addEventListener('scroll', syncStuck, { passive: true });

	/* ---- the bar's dropdown panels ---- */

	const panelStrip = document.querySelector('[data-panels]');
	const triggers = [...document.querySelectorAll('[data-panel-open]')];

	if (panelStrip && triggers.length) {
		const panels = [...panelStrip.querySelectorAll('[data-panel]')];
		let closeTimer = null;

		const showPanel = (id) => {
			clearTimeout(closeTimer);
			panels.forEach((p) => {
				p.dataset.open = String(p.dataset.panel === id);
			});
			triggers.forEach((t) => {
				t.setAttribute('aria-expanded', String(t.dataset.panelOpen === id));
			});
			panelStrip.dataset.open = String(Boolean(id));
			document.documentElement.setAttribute('data-panel-open', String(Boolean(id)));
		};

		const hidePanel = () => showPanel(null);
		// Leaving the bar for the panel (or back) crosses a gap of dead pixels,
		// so closing waits a beat rather than snapping shut under the cursor.
		const hideSoon = () => {
			clearTimeout(closeTimer);
			closeTimer = setTimeout(hidePanel, 180);
		};
		const openId = () => panels.find((p) => p.dataset.open === 'true')?.dataset.panel ?? null;

		triggers.forEach((trigger) => {
			const id = trigger.dataset.panelOpen;
			trigger.addEventListener('pointerenter', (e) => {
				if (e.pointerType !== 'touch') showPanel(id);
			});
			trigger.addEventListener('focus', () => showPanel(id));
			// An item with a panel is a switch, not a destination: clicking it
			// only ever opens or closes the panel. The section's own page is
			// reached through the "Xem tất cả" link inside the panel.
			trigger.addEventListener('click', (e) => {
				e.preventDefault();
				if (openId() === id) hidePanel();
				else showPanel(id);
			});
		});

		document.querySelector('[data-bar-nav]')?.addEventListener('pointerleave', hideSoon);
		panelStrip.addEventListener('pointerenter', () => clearTimeout(closeTimer));
		panelStrip.addEventListener('pointerleave', hideSoon);

		document.addEventListener('keydown', (e) => {
			if (e.key !== 'Escape' || !openId()) return;
			const trigger = triggers.find((t) => t.dataset.panelOpen === openId());
			hidePanel();
			trigger?.focus();
		});

		// Tabbing past the last link in a panel, or clicking anywhere else on
		// the page, ends the panel the same way moving the pointer away does.
		document.addEventListener('focusin', (e) => {
			if (openId() && !e.target.closest('[data-panels], [data-panel-open]')) hidePanel();
		});
		document.addEventListener('click', (e) => {
			if (openId() && !e.target.closest('[data-panels], [data-panel-open]')) hidePanel();
		});
	}

	if (!nav || !toggle) return;

	let restoreFocus = null;

	const setNav = (open) => {
		if (nav.dataset.open === String(open)) return;
		nav.dataset.open = String(open);
		nav.inert = !open;
		toggle.setAttribute('aria-expanded', String(open));
		document.documentElement.setAttribute('data-nav-open', String(open));
		document.body.style.overflow = open ? 'hidden' : '';

		if (open) {
			restoreFocus = document.activeElement;
			// The list is what the overlay is for, so land on it rather than on
			// the control the visitor just pressed.
			nav.querySelector('.navx__item')?.focus({ preventScroll: true });
		} else {
			(restoreFocus instanceof HTMLElement ? restoreFocus : toggle).focus({ preventScroll: true });
			restoreFocus = null;
		}
	};

	const isOpen = () => nav.dataset.open === 'true';

	toggle.addEventListener('click', () => setNav(!isOpen()));

	// A link inside the overlay navigates; close first so a same-page anchor
	// does not scroll behind a panel that is still covering it.
	nav.addEventListener('click', (e) => {
		if (e.target.closest('a')) setNav(false);
	});

	document.addEventListener('keydown', (e) => {
		if (e.key !== 'Escape' || !isOpen()) return;
		// Escape steps back one level: out of a section first, then the overlay.
		if (openSub) closeSub();
		else setNav(false);
	});

	// On a phone a section with pages opens them as a page of its own, slid in
	// over the list; the back button (or Escape) returns to the list.
	const subToggles = [...nav.querySelectorAll('[data-sub-toggle]')];
	const behind = () => [...nav.querySelectorAll('.navx__item, [data-sub-toggle], .navx__foot')];
	let openSub = null;

	const closeSub = ({ focus = true } = {}) => {
		if (!openSub) return;
		const { btn, sub } = openSub;
		sub.dataset.open = 'false';
		sub.inert = true;
		btn.setAttribute('aria-expanded', 'false');
		behind().forEach((el) => (el.inert = false));
		nav.dataset.subOpen = 'false';
		openSub = null;
		if (focus) btn.focus({ preventScroll: true });
	};

	const showSub = (btn) => {
		const sub = document.getElementById(btn.getAttribute('aria-controls'));
		if (!sub) return;
		closeSub({ focus: false });
		behind().forEach((el) => (el.inert = true));
		sub.inert = false;
		sub.dataset.open = 'true';
		sub.scrollTop = 0;
		btn.setAttribute('aria-expanded', 'true');
		nav.dataset.subOpen = 'true';
		openSub = { btn, sub };
		sub.querySelector('[data-sub-back]')?.focus({ preventScroll: true });
	};

	subToggles.forEach((btn) => btn.addEventListener('click', () => showSub(btn)));
	nav.querySelectorAll('[data-sub-back]').forEach((back) => back.addEventListener('click', () => closeSub()));

	// Closing the overlay always lands back on the list next time.
	toggle.addEventListener('click', () => {
		if (!isOpen()) closeSub({ focus: false });
	});

	// Tab must not walk out of an open overlay and into the page behind it.
	nav.addEventListener('keydown', (e) => {
		if (e.key !== 'Tab' || !isOpen()) return;
		const focusable = [...nav.querySelectorAll('a[href], button:not([disabled])')].filter(
			// A closed drawer's links still have a box; visibility is what hides them.
			(el) => el.offsetParent !== null && getComputedStyle(el).visibility !== 'hidden',
		);
		if (!focusable.length) return;
		const first = focusable[0];
		const last = focusable.at(-1);
		if (e.shiftKey && document.activeElement === first) {
			e.preventDefault();
			last.focus();
		} else if (!e.shiftKey && document.activeElement === last) {
			e.preventDefault();
			first.focus();
		}
	});
}
