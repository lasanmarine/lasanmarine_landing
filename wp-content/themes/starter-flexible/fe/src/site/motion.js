// "Reduce motion" toggle in the footer (WCAG 2.3.3). The choice is stored per
// browser; the header applies it before first paint. Scripts that animate on
// scroll ask motionAllowed() and listen for the 'lm:motion' event.

const KEY = 'lm-motion';

export function motionAllowed() {
	if (document.documentElement.classList.contains('reduce-motion')) return false;
	return !window.matchMedia || !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

export function initMotionToggle() {
	const btn = document.querySelector('[data-motion-toggle]');
	if (!btn) return;
	const root = document.documentElement;
	const sync = () => btn.setAttribute('aria-pressed', root.classList.contains('reduce-motion') ? 'true' : 'false');
	sync();
	btn.addEventListener('click', () => {
		const reduce = !root.classList.contains('reduce-motion');
		root.classList.toggle('reduce-motion', reduce);
		try { reduce ? localStorage.setItem(KEY, 'reduce') : localStorage.removeItem(KEY); } catch (e) { /* private mode */ }
		sync();
		window.dispatchEvent(new CustomEvent('lm:motion'));
	});
}
