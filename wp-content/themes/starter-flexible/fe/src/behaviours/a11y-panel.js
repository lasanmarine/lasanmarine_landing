// The "Hỗ trợ tiếp cận" panel (inc/accessibility.php).
//
// Each choice is a class on <html>, stored as JSON under `lm-a11y` and put
// back before the first paint by the inline script in <head>. "Stop
// animations" is the motion store's own switch, shared with the footer's
// toggle. The panel is a non-modal dialog: Escape or the close button shuts
// it and focus goes back to the trigger.
import { on, cleanupAll } from '../lib/dom';
import { motion } from '../lib/stores/motion.svelte.js';

export const selector = '[data-a11y]';

const KEY = 'lm-a11y';
const SIZES = [100, 112, 125, 140]; // % — the zoom of each text-size step
const FLAGS = ['contrast', 'gray', 'links', 'readable', 'spacing', 'cursor', 'guide'];
const html = document.documentElement;

function load() {
	try {
		return JSON.parse(localStorage.getItem(KEY) || '{}') || {};
	} catch {
		return {};
	}
}
function save(state) {
	try {
		const clean = Object.fromEntries(Object.entries(state).filter(([, v]) => v));
		if (Object.keys(clean).length) localStorage.setItem(KEY, JSON.stringify(clean));
		else localStorage.removeItem(KEY);
	} catch {
		/* private mode: the choice lasts for this page only */
	}
}

export default function a11yPanel(root) {
	const trigger = root.querySelector('[data-a11y-open]');
	const panel = root.querySelector('[data-a11y-panel]');
	const ruler = root.querySelector('[data-a11y-ruler]');
	const value = root.querySelector('[data-a11y-size-value]');
	if (!trigger || !panel) return null;

	const state = load();
	state.text = Math.min(Math.max(parseInt(state.text, 10) || 0, 0), SIZES.length - 1);

	const apply = () => {
		SIZES.forEach((_, i) => html.classList.toggle(`a11y-text-${i}`, i > 0 && i === state.text));
		FLAGS.forEach((k) => html.classList.toggle(`a11y-${k}`, !!state[k]));
		if (value) value.textContent = `${SIZES[state.text]}%`;
		root.querySelectorAll('[data-a11y-size]').forEach((b) => {
			const dir = Number(b.dataset.a11ySize);
			b.disabled = dir < 0 ? state.text === 0 : state.text === SIZES.length - 1;
		});
		root.querySelectorAll('[data-a11y-toggle]').forEach((b) => {
			const k = b.dataset.a11yToggle;
			const on_ = k === 'motion' ? motion.userReduce : !!state[k];
			b.setAttribute('aria-pressed', String(on_));
		});
		ruler?.toggleAttribute('hidden', !state.guide);
		save(state);
	};

	const open = (yes) => {
		panel.hidden = !yes;
		trigger.setAttribute('aria-expanded', String(yes));
		root.classList.toggle('is-open', yes);
		if (yes) panel.querySelector('button:not([disabled])')?.focus();
	};
	const close = (refocus = true) => {
		if (panel.hidden) return;
		open(false);
		if (refocus) trigger.focus();
	};

	// The reading guide: a clear band that follows the pointer (or the focus
	// on a keyboard), moved by transform once a frame.
	let raf = 0;
	let y = window.innerHeight / 2;
	const place = () => {
		raf = 0;
		if (ruler) ruler.style.transform = `translate3d(0, ${Math.round(y)}px, 0)`;
	};
	const follow = (e) => {
		if (!state.guide) return;
		y = e.clientY;
		if (!raf) raf = requestAnimationFrame(place);
	};
	const followFocus = (e) => {
		if (!state.guide || !(e.target instanceof Element)) return;
		const r = e.target.getBoundingClientRect();
		y = r.top + r.height / 2;
		if (!raf) raf = requestAnimationFrame(place);
	};

	apply();
	place();

	return cleanupAll([
		on(trigger, 'click', () => (panel.hidden ? open(true) : close())),
		on(root.querySelector('[data-a11y-close]'), 'click', () => close()),
		on(panel, 'keydown', (e) => {
			if (e.key === 'Escape') {
				e.stopPropagation();
				close();
			}
		}),
		on(document, 'keydown', (e) => {
			if (e.key === 'Escape' && !panel.hidden) close();
		}),
		on(document, 'pointerdown', (e) => {
			if (!panel.hidden && !root.contains(e.target)) close(false);
		}),
		...[...root.querySelectorAll('[data-a11y-size]')].map((b) =>
			on(b, 'click', () => {
				state.text = Math.min(Math.max(state.text + Number(b.dataset.a11ySize), 0), SIZES.length - 1);
				apply();
			}),
		),
		...[...root.querySelectorAll('[data-a11y-toggle]')].map((b) =>
			on(b, 'click', () => {
				const k = b.dataset.a11yToggle;
				if (k === 'motion') motion.setUserReduce(!motion.userReduce);
				else state[k] = !state[k];
				apply();
			}),
		),
		on(root.querySelector('[data-a11y-reset]'), 'click', () => {
			state.text = 0;
			FLAGS.forEach((k) => (state[k] = false));
			if (motion.userReduce) motion.setUserReduce(false);
			apply();
		}),
		motion.subscribe(() => apply()),
		on(window, 'pointermove', follow, { passive: true }),
		on(document, 'focusin', followFocus),
		() => cancelAnimationFrame(raf),
	]);
}
