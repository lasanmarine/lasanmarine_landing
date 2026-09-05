// Site-wide behaviour plus every block's own script.
//
// Each blocks/{slug}/assets/script.js is written to be inert when its markup
// is absent from the page, so importing them all here costs one small bundle
// and saves a per-block enqueue. They run on import, which is safe because the
// bundle is served as a module and therefore deferred — the same guarantee the
// Astro site's inline block scripts had. Vite's own block-entry discovery reads
// fe/src/blocks rather than the theme's blocks/ directory, so this glob is what
// picks them up.
import { initHeader } from './site/header';
import { initFooter } from './site/footer';
import { initReveal } from './site/reveal';
import { initWaves } from './site/waves';
import { initPostProgress } from './site/post-progress';
import { initAos } from './site/aos';

if (import.meta.env.DEV) {
	// Production builds/enqueues independent block entries. The dev server only
	// serves main.js, so pull the same assets into that graph while developing.
	const blockScripts = import.meta.glob('../../blocks/*/assets/script.js');
	Object.values(blockScripts).forEach((load) => load());
	import('./styles/blocks.scss');
}

function onDomReady(fn) {
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', fn, { once: true });
		return;
	}
	fn();
}

onDomReady(() => {
	initHeader();
	initFooter();
	initReveal();
	initWaves();
	initPostProgress();
	initAos();
});
