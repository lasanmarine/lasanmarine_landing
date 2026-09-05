// Fills the fixed top rail on single-post pages as the article scrolls.

export function initPostProgress() {
	const bar = document.querySelector('[data-post-progress]');
	const article = document.querySelector('.post-single');
	if (!bar || !article) return;

	const update = () => {
		const start = article.offsetTop;
		const distance = article.offsetHeight - window.innerHeight;
		const progress = distance > 0 ? (window.scrollY - start) / distance : 0;
		bar.style.width = `${Math.min(100, Math.max(0, progress * 100))}%`;
	};

	update();
	window.addEventListener('scroll', update, { passive: true });
	window.addEventListener('resize', update);
}
