// The one entry for every script on the site.
//
//   1. Behaviours attach to the markup PHP rendered.
//   2. Islands mount; once each is in the DOM, behaviours run again over it,
//      so a reveal or a copy button inside an island works the same way.
//   3. In the block editor, ACF re-renders a block's preview on every change;
//      the old instance is torn down and the new markup booted.
import { attachBehaviours, detachBehaviours } from './behaviours';
import { mountIslands, unmountIslands } from './islands';

async function boot(root = document) {
	attachBehaviours(root);
	const hosts = await mountIslands(root);
	hosts.forEach((host) => attachBehaviours(host));
}

function onReady(fn) {
	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', fn, { once: true });
	else fn();
}

onReady(() => {
	boot();

	const acf = window.acf;
	if (acf?.addAction) {
		acf.addAction('render_block_preview', ($el) => {
			const el = $el?.[0] ?? $el;
			if (!(el instanceof Element)) return;
			detachBehaviours(el);
			unmountIslands(el);
			boot(el);
		});
	}
});
