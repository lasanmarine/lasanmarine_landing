// Islands: Svelte components that own a piece of the page.
//
// PHP prints a shell — <div data-island="{name}"> with the component's props
// as JSON in a child <script type="application/json" data-props> — and this
// mounts the component into it. Components are loaded lazily, so a page only
// downloads the islands it actually renders. The block's island lives next to
// its PHP: blocks/{slug}/assets/island.svelte; site-wide ones in src/islands.
import { mount, unmount } from 'svelte';

const blockIslands = import.meta.glob('../../../blocks/*/assets/island.svelte');
const siteIslands = import.meta.glob('../islands/*.svelte');

const loaders = {};
for (const [path, load] of Object.entries(blockIslands)) {
	loaders[path.match(/blocks\/([^/]+)\/assets/)[1]] = load;
}
for (const [path, load] of Object.entries(siteIslands)) {
	loaders[path.match(/([^/]+)\.svelte$/)[1]] = load;
}

const mounted = new WeakMap();

function readProps(host) {
	const holder = host.querySelector(':scope > script[data-props]');
	if (!holder) return {};
	try {
		return JSON.parse(holder.textContent || '{}');
	} catch {
		return {};
	}
}

/** Mount a component by name into any element; used by behaviours too. */
export async function mountIsland(name, target, props = {}) {
	const load = loaders[name];
	if (!load) {
		console.warn(`[island] unknown island "${name}"`);
		return null;
	}
	const { default: Component } = await load();
	const instance = mount(Component, { target, props });
	return () => unmount(instance);
}

/** Mount every island shell under `root`. Resolves once all are in the DOM. */
export function mountIslands(root = document) {
	const hosts = [...root.querySelectorAll('[data-island]')].filter((host) => !mounted.has(host));
	return Promise.all(
		hosts.map(async (host) => {
			mounted.set(host, null);
			const props = readProps(host);
			// The shell may hold a server-rendered placeholder; the island replaces it.
			host.querySelectorAll(':scope > :not(script[data-props])').forEach((el) => el.remove());
			const destroy = await mountIsland(host.dataset.island, host, props);
			mounted.set(host, destroy);
			host.dataset.islandReady = '';
			return host;
		}),
	);
}

export function unmountIslands(root) {
	root.querySelectorAll?.('[data-island]').forEach((host) => {
		mounted.get(host)?.();
		mounted.delete(host);
	});
}
