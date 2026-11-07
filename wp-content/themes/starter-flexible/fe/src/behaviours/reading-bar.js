// The reading bar: how far through the article the reader is, shown once the
// article's own heading has scrolled off. It is moved into the header pill and
// opens as its second row, so the bar and the nav read as one piece.
import { viewport } from '../lib/stores/viewport.svelte.js';
import { clamp } from '../lib/format';

export const selector = '[data-reading-bar]';

export default function readingBar(bar) {
	const fill = document.querySelector('[data-post-progress]');
	const article = document.querySelector('.post-single, .project-single');
	if (!fill || !article) return null;

	const home = bar.parentNode;
	const next = bar.nextSibling;
	const hdr = document.querySelector('[data-hdr-bar]');
	if (hdr) {
		hdr.append(bar);
		bar.classList.add('reading-bar--docked');
	}

	const off = viewport.subscribe(({ scrollY, height }) => {
		const start = article.offsetTop;
		const distance = article.offsetHeight - height;
		const progress = distance > 0 ? (scrollY - start) / distance : 0;
		fill.style.width = `${clamp(progress * 100, 0, 100)}%`;
		const shown = scrollY > start + 80;
		if (shown === bar.hidden) bar.hidden = !shown;
	});
	return () => {
		off();
		bar.classList.remove('reading-bar--docked');
		home?.insertBefore(bar, next);
	};
}
