// Behaviours: plain functions that bring server-rendered markup to life.
//
// Each module exports `selector` and a default `(node) => cleanup` — the same
// shape as a Svelte attachment, so a component can also use one through
// {@attach}. Site-wide behaviours sit in src/behaviours, a block's own in
// blocks/{slug}/assets/behaviour.js. They are small, so they ship in the main
// bundle; each only runs where its selector matches.
//
// A module may export `once = true` to run a single time against `document`
// (for page-level things like analytics) instead of once per matching node.

const modules = {
	...import.meta.glob('../behaviours/*.js', { eager: true }),
	...import.meta.glob('../../../blocks/*/assets/behaviour.js', { eager: true }),
};

// Order matters for a few site behaviours (the header publishes --hdr-h that
// the stack reads), so modules may set `order`; lower runs first.
const registry = Object.entries(modules)
	.map(([path, mod]) => ({ path, ...mod }))
	.filter((mod) => typeof mod.default === 'function' && mod.selector)
	.sort((a, b) => (a.order ?? 50) - (b.order ?? 50));

const attached = new WeakMap(); // node -> Map(path -> cleanup)
let ranOnce = new Set();

function attach(node, mod) {
	let byNode = attached.get(node);
	if (!byNode) attached.set(node, (byNode = new Map()));
	if (byNode.has(mod.path)) return;
	try {
		byNode.set(mod.path, mod.default(node) || null);
	} catch (error) {
		console.error(`[behaviour] ${mod.path}`, error);
		byNode.set(mod.path, null);
	}
}

export function attachBehaviours(root = document) {
	for (const mod of registry) {
		if (mod.once) {
			if (ranOnce.has(mod.path) || !document.querySelector(mod.selector)) continue;
			ranOnce.add(mod.path);
			attach(document, mod);
			continue;
		}
		if (root !== document && root.matches?.(mod.selector)) attach(root, mod);
		root.querySelectorAll(mod.selector).forEach((node) => attach(node, mod));
	}
}

export function detachBehaviours(root) {
	const nodes = [root, ...(root.querySelectorAll?.('*') ?? [])];
	for (const node of nodes) {
		const byNode = attached.get(node);
		if (!byNode) continue;
		byNode.forEach((cleanup) => typeof cleanup === 'function' && cleanup());
		attached.delete(node);
	}
}
