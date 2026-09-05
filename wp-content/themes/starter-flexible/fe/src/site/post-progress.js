// The reading bar under the header: how far through the article the reader is,
// with the title and byline for context once the real heading has scrolled off.

export function initPostProgress() {
	const bar = document.querySelector('[data-reading-bar]');
	const fill = document.querySelector('[data-post-progress]');
	const article = document.querySelector('.post-single, .project-single');
	if (!bar || !fill || !article) return;

	// The bar sits directly under the fixed header, whose height changes when
	// it sticks — so it is read from the same custom property the header sets.
	const update = () => {
		const start = article.offsetTop;
		const distance = article.offsetHeight - window.innerHeight;
		const progress = distance > 0 ? (window.scrollY - start) / distance : 0;
		const pct = Math.min(100, Math.max(0, progress * 100));
		fill.style.width = `${pct}%`;

		// It appears only once the article's own header is out of the way,
		// so it never doubles up with the title on screen.
		const shown = window.scrollY > start + 80;
		if (shown === bar.hidden) bar.hidden = !shown;
	};

	update();
	window.addEventListener('scroll', update, { passive: true });
	window.addEventListener('resize', update);
}
