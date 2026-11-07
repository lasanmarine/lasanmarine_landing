// One answer to "may this animate?": the OS setting plus the footer's
// "reduce motion" toggle (WCAG 2.3.3), which the header applies as a class on
// <html> before first paint and which is stored per browser.
//
// Components read `motion.allowed` reactively; behaviours use
// `motion.subscribe(fn)`, which calls back now and on every change.

const KEY = 'lm-motion';
const media =
	typeof window !== 'undefined' && window.matchMedia ? window.matchMedia('(prefers-reduced-motion: reduce)') : null;

class Motion {
	osReduce = $state(media?.matches ?? false);
	userReduce = $state(
		typeof document !== 'undefined' && document.documentElement.classList.contains('reduce-motion'),
	);
	#listeners = new Set();

	constructor() {
		media?.addEventListener?.('change', (e) => {
			this.osReduce = e.matches;
			this.#emit();
		});
	}

	get allowed() {
		return !this.osReduce && !this.userReduce;
	}

	setUserReduce(reduce) {
		this.userReduce = reduce;
		document.documentElement.classList.toggle('reduce-motion', reduce);
		try {
			if (reduce) localStorage.setItem(KEY, 'reduce');
			else localStorage.removeItem(KEY);
		} catch {
			/* private mode */
		}
		this.#emit();
	}

	subscribe(fn) {
		this.#listeners.add(fn);
		fn(this.allowed);
		return () => this.#listeners.delete(fn);
	}

	#emit() {
		this.#listeners.forEach((fn) => fn(this.allowed));
	}
}

export const motion = new Motion();
