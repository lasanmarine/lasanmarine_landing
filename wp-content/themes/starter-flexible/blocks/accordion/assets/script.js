// Accordion — the panel is `hidden` until opened, so the markup still works
// with scripting off; this only adds the height transition on the way in and
// out. Inert when no [data-accordion] is on the page.
const REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)');

function setPanelHeight(panel, from, to, done) {
	panel.style.overflow = 'hidden';
	panel.style.height = `${from}px`;
	// Force a reflow so the browser has a start value to animate away from.
	void panel.offsetHeight;
	panel.style.transition = 'height 320ms cubic-bezier(0.2, 0.6, 0.2, 1)';
	panel.style.height = `${to}px`;

	const finish = () => {
		panel.style.transition = '';
		panel.style.height = '';
		panel.style.overflow = '';
		panel.removeEventListener('transitionend', onEnd);
		if (done) done();
	};
	const onEnd = (event) => {
		if (event.target === panel && event.propertyName === 'height') finish();
	};

	panel.addEventListener('transitionend', onEnd);
	// A panel that never transitions (display swap, reduced motion) still ends.
	window.setTimeout(finish, 420);
}

function openPanel(panel) {
	panel.hidden = false;
	if (REDUCED.matches) return;
	setPanelHeight(panel, 0, panel.scrollHeight);
}

function closePanel(panel) {
	if (REDUCED.matches) {
		panel.hidden = true;
		return;
	}
	setPanelHeight(panel, panel.scrollHeight, 0, () => {
		panel.hidden = true;
	});
}

document.querySelectorAll('[data-accordion]').forEach((list) => {
	list.querySelectorAll('.ac__trigger').forEach((trigger) => {
		const panel = document.getElementById(trigger.getAttribute('aria-controls'));
		if (!panel) return;

		trigger.addEventListener('click', () => {
			const open = trigger.getAttribute('aria-expanded') === 'true';
			trigger.setAttribute('aria-expanded', String(!open));
			if (open) closePanel(panel);
			else openPanel(panel);
		});
	});
});
