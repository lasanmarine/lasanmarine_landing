// App Embed — "Mở toàn màn hình" opens the embedded app over the whole
// screen on this same page and URL, rather than sending the reader off to the
// app's own address. The Fullscreen API is used where it exists; otherwise
// (iPhone Safari) the frame is laid over the page with a close button.
// Any `[data-app-fullscreen]` link on the page (the hero's button too) opens it.
import { on, cleanupAll } from '$lib/dom';

export const selector = '[data-app-embed]';

export default function appEmbed(box) {
	const close = box.querySelector('[data-app-close]');
	const frame = box.querySelector('iframe');
	if (frame) frame.loading = 'eager';

	const setOverlay = (onOff) => {
		box.classList.toggle('is-full', onOff);
		document.documentElement.classList.toggle('has-app-full', onOff);
		if (close) close.hidden = !onOff;
	};

	const open = (e) => {
		e.preventDefault();
		if (box.requestFullscreen) {
			box.requestFullscreen().then(() => setOverlay(true)).catch(() => setOverlay(true));
		} else setOverlay(true);
	};
	const exit = () => {
		if (document.fullscreenElement) document.exitFullscreen();
		setOverlay(false);
	};

	return cleanupAll([
		...[...document.querySelectorAll('[data-app-fullscreen]')].map((a) => on(a, 'click', open)),
		close && on(close, 'click', exit),
		on(document, 'fullscreenchange', () => !document.fullscreenElement && setOverlay(false)),
		on(document, 'keydown', (e) => e.key === 'Escape' && box.classList.contains('is-full') && exit()),
	]);
}
