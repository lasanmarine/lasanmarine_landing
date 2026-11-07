// Header: measured height, sticky bar, the bar's dropdown panels and the
// full-screen nav that stands in for them on a narrow screen.
//
// Runs first (order 0): it publishes --hdr-h, which the stack and the
// reading bar read through the viewport store.
import { viewport } from '../lib/stores/viewport.svelte.js';
import { on, cleanupAll, $$ } from '../lib/dom';

export const selector = '[data-header]';
export const order = 0;

export default function header(root) {
	return cleanupAll([measure(root), stickyBar(), panels(), overlay()]);
}

/* ---- height + sticky ---------------------------------------------------- */

function measure(root) {
	// The on-page row opens inside the header pill as the reader scrolls; it
	// overlays the page rather than pushing sheets, so it is not counted.
	const sync = () => viewport.setHeaderHeight(root.offsetHeight - (root.querySelector('.onpage')?.offsetHeight ?? 0));
	sync();
	const ro = new ResizeObserver(sync);
	ro.observe(root);
	return () => ro.disconnect();
}

function stickyBar() {
	const bar = document.querySelector('[data-hdr-bar]');
	if (!bar) return null;
	const header = bar.closest('[data-header]') ?? bar;
	const footer = document.querySelector('footer, .ftr');
	let lastY = window.scrollY;

	// The bar turns opaque once the page has scrolled past the hero's top.
	// Reaching the footer, it slides away so the footer has the whole screen;
	// the first scroll back up brings it straight back.
	return viewport.subscribe(({ scrollY, height }) => {
		bar.classList.toggle('is-stuck', scrollY > 24);
		const down = scrollY > lastY + 1;
		const up = scrollY < lastY - 1;
		const atFooter = !!footer && footer.getBoundingClientRect().top < height * 0.85;
		if (up || !atFooter) header.classList.remove('is-tucked');
		else if (down && atFooter) header.classList.add('is-tucked');
		lastY = scrollY;
	});
}

/* ---- the bar's dropdown panels ------------------------------------------ */

// An item with a panel is a switch, not a destination: hover or focus opens
// it, a click toggles it, and the section's own page is reached through the
// "Xem tất cả" link inside the panel. A touch device, which has no hover,
// still reaches the children through the click.
function panels() {
	const strip = document.querySelector('[data-panels]');
	const triggers = $$(document, '[data-panel-open]');
	if (!strip || !triggers.length) return null;

	const items = $$(strip, '[data-panel]');
	let current = null;
	let closeTimer = 0;

	const show = (id) => {
		clearTimeout(closeTimer);
		current = id;
		items.forEach((p) => (p.dataset.open = String(p.dataset.panel === id)));
		triggers.forEach((t) => t.setAttribute('aria-expanded', String(t.dataset.panelOpen === id)));
		strip.dataset.open = String(Boolean(id));
		document.documentElement.setAttribute('data-panel-open', String(Boolean(id)));
	};
	const hide = () => show(null);
	// Leaving the bar for the panel (or back) crosses a gap of dead pixels, so
	// closing waits a beat rather than snapping shut under the cursor.
	const hideSoon = () => {
		clearTimeout(closeTimer);
		closeTimer = setTimeout(hide, 180);
	};
	const outside = (target) => !target.closest('[data-panels], [data-panel-open]');

	const offs = triggers.flatMap((trigger) => {
		const id = trigger.dataset.panelOpen;
		return [
			on(trigger, 'pointerenter', (e) => e.pointerType !== 'touch' && show(id)),
			on(trigger, 'focus', () => show(id)),
			on(trigger, 'click', (e) => {
				e.preventDefault();
				if (current === id) hide();
				else show(id);
			}),
		];
	});

	const barNav = document.querySelector('[data-bar-nav]');
	return cleanupAll([
		...offs,
		barNav && on(barNav, 'pointerleave', hideSoon),
		on(strip, 'pointerenter', () => clearTimeout(closeTimer)),
		on(strip, 'pointerleave', hideSoon),
		on(document, 'keydown', (e) => {
			if (e.key !== 'Escape' || !current) return;
			const trigger = triggers.find((t) => t.dataset.panelOpen === current);
			hide();
			trigger?.focus();
		}),
		// Tabbing past the last link, or clicking anywhere else, ends the panel
		// the same way moving the pointer away does.
		on(document, 'focusin', (e) => current && outside(e.target) && hide()),
		on(document, 'click', (e) => current && outside(e.target) && hide()),
		() => clearTimeout(closeTimer),
	]);
}

/* ---- the full-screen nav ------------------------------------------------ */

function overlay() {
	const toggle = document.querySelector('[data-nav-toggle]');
	const nav = document.querySelector('[data-nav]');
	if (!nav || !toggle) return null;

	let restoreFocus = null;
	let openSub = null; // { btn, sub }

	const isOpen = () => nav.dataset.open === 'true';
	const behind = () => $$(nav, '.navx__item, [data-sub-toggle], .navx__foot');

	const setNav = (open) => {
		if (isOpen() === open) return;
		nav.dataset.open = String(open);
		nav.inert = !open;
		toggle.setAttribute('aria-expanded', String(open));
		document.documentElement.setAttribute('data-nav-open', String(open));
		document.body.style.overflow = open ? 'hidden' : '';

		if (open) {
			// Closing the overlay always lands back on the list next time.
			closeSub({ focus: false });
			restoreFocus = document.activeElement;
			// The list is what the overlay is for, so land on it rather than on
			// the control the visitor just pressed.
			nav.querySelector('.navx__item')?.focus({ preventScroll: true });
		} else {
			(restoreFocus instanceof HTMLElement ? restoreFocus : toggle).focus({ preventScroll: true });
			restoreFocus = null;
		}
	};

	// On a phone a section with pages opens them as a page of its own, slid
	// in over the list; the back button (or Escape) returns to the list.
	function closeSub({ focus = true } = {}) {
		if (!openSub) return;
		const { btn, sub } = openSub;
		sub.dataset.open = 'false';
		sub.inert = true;
		btn.setAttribute('aria-expanded', 'false');
		behind().forEach((el) => (el.inert = false));
		nav.dataset.subOpen = 'false';
		openSub = null;
		if (focus) btn.focus({ preventScroll: true });
	}

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

	// Tab must not walk out of an open overlay into the page behind it.
	const trapTab = (e) => {
		if (e.key !== 'Tab' || !isOpen()) return;
		const focusable = $$(nav, 'a[href], button:not([disabled])').filter(
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
	};

	return cleanupAll([
		on(toggle, 'click', () => setNav(!isOpen())),
		// A link inside the overlay navigates; close first so a same-page anchor
		// does not scroll behind a panel that is still covering it.
		on(nav, 'click', (e) => e.target.closest('a') && setNav(false)),
		on(document, 'keydown', (e) => {
			if (e.key !== 'Escape' || !isOpen()) return;
			// Escape steps back one level: out of a section first, then the overlay.
			if (openSub) closeSub();
			else setNav(false);
		}),
		...$$(nav, '[data-sub-toggle]').map((btn) => on(btn, 'click', () => showSub(btn))),
		...$$(nav, '[data-sub-back]').map((back) => on(back, 'click', () => closeSub())),
		on(nav, 'keydown', trapTab),
	]);
}
