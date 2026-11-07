// The reading bar under the header: how far through the article the reader
// is, shown once the article's own heading has scrolled off.
import { viewport } from '../lib/stores/viewport.svelte.js';
import { clamp } from '../lib/format';

export const selector = '[data-reading-bar]';

export default function readingBar(bar) {
	const fill = document.querySelector('[data-post-progress]');
	const article = document.querySelector('.post-single, .project-single');
	if (!fill || !article) return null;

	return viewport.subscribe(({ scrollY, height }) => {
		const start = article.offsetTop;
		const distance = article.offsetHeight - height;
		const progress = distance > 0 ? (scrollY - start) / distance : 0;
		fill.style.width = `${clamp(progress * 100, 0, 100)}%`;
		const shown = scrollY > start + 80;
		if (shown === bar.hidden) bar.hidden = !shown;
	});
}
