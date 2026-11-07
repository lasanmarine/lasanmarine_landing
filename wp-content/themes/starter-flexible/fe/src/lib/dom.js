// Small helpers every behaviour reaches for.

/** addEventListener that returns its own remover; collect them for cleanup. */
export function on(target, type, fn, options) {
	target.addEventListener(type, fn, options);
	return () => target.removeEventListener(type, fn, options);
}

/** One cleanup that runs a list of them (falsy entries are skipped). */
export const cleanupAll = (list) => () => list.forEach((fn) => typeof fn === 'function' && fn());

export const $$ = (root, selector) => [...root.querySelectorAll(selector)];
