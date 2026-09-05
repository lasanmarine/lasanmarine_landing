// AOS — scroll animations driven by `data-aos` attributes in block markup.
//
// The theme's own [data-reveal] system (see site/reveal.js) still handles the
// site-wide block reveals; AOS is here for the per-element effects inside the
// tool blocks, which want their own direction and delay per element.
import AOS from 'aos';
import 'aos/dist/aos.css';

export function initAos() {
	if (!document.querySelector('[data-aos]')) return;
	// Honour the OS setting: AOS hides elements until they animate in, so it
	// must not run at all rather than run instantly.
	if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

	AOS.init({
		duration: 600,
		easing: 'ease-out-cubic',
		offset: 60,
		once: true,
		disable: 'phone',
	});

	// Filtering and pagination change the page height under AOS's cached
	// offsets, so recompute them once things settle.
	window.addEventListener('load', () => AOS.refresh());
}
