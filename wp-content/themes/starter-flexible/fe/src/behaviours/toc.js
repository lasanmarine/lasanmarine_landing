// Article contents: the entry for the section being read is marked current,
// and on a narrow screen the box folds shut so it does not push the article
// down past the first screen.
export const selector = '[data-toc]';

export default function toc(list) {
	const box = list.closest('details');
	if (box && window.matchMedia('(max-width: 960px)').matches) box.open = false;

	const links = [...list.querySelectorAll('a[href^="#"]')];
	const targets = links
		.map((link) => document.getElementById(decodeURIComponent(link.hash.slice(1))))
		.filter(Boolean);
	if (!targets.length) return null;

	const mark = (id) => links.forEach((link) => link.setAttribute('aria-current', String(link.hash.slice(1) === id)));

	// The current section is the last heading that has passed the top third.
	const io = new IntersectionObserver(
		() => {
			const line = window.innerHeight * 0.33;
			const passed = targets.filter((t) => t.getBoundingClientRect().top <= line);
			mark((passed.at(-1) ?? targets[0]).id);
		},
		{ rootMargin: '0px 0px -60% 0px' },
	);
	targets.forEach((t) => io.observe(t));
	return () => io.disconnect();
}
