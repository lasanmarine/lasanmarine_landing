// The page's single scroll / resize pipeline.
//
// Before, every effect kept its own scroll listener and measured the window on
// its own. Now one passive listener batches into one animation frame and all
// subscribers get the same snapshot:
//   { scrollY, height, width, hdrH, scrolled, resized }
// Components can also read `viewport.scrollY` and friends reactively.

class Viewport {
	scrollY = $state(0);
	height = $state(0);
	width = $state(0);
	hdrH = $state(76);

	#subs = new Set();
	#queued = false;
	#scrolled = false;
	#resized = false;
	#started = false;

	#readHdr() {
		return parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--hdr-h')) || 76;
	}

	#flush = () => {
		this.#queued = false;
		this.scrollY = window.scrollY;
		if (this.#resized) {
			this.height = window.innerHeight;
			this.width = window.innerWidth;
			this.hdrH = this.#readHdr();
		}
		const snap = this.snapshot({ scrolled: this.#scrolled, resized: this.#resized });
		this.#scrolled = false;
		this.#resized = false;
		this.#subs.forEach((fn) => fn(snap));
	};

	#queue() {
		if (this.#queued) return;
		this.#queued = true;
		requestAnimationFrame(this.#flush);
	}

	#start() {
		if (this.#started || typeof window === 'undefined') return;
		this.#started = true;
		this.scrollY = window.scrollY;
		this.height = window.innerHeight;
		this.width = window.innerWidth;
		this.hdrH = this.#readHdr();
		window.addEventListener(
			'scroll',
			() => {
				this.#scrolled = true;
				this.#queue();
			},
			{ passive: true },
		);
		window.addEventListener('resize', () => {
			this.#resized = true;
			this.#queue();
		});
	}

	snapshot(extra = {}) {
		return { scrollY: this.scrollY, height: this.height, width: this.width, hdrH: this.hdrH, ...extra };
	}

	/** The header publishes its measured height through here. */
	setHeaderHeight(px) {
		document.documentElement.style.setProperty('--hdr-h', `${px}px`);
		if (px !== this.hdrH) {
			this.hdrH = px;
			this.#resized = true;
			this.#queue();
		}
	}

	/** Re-run subscribers on the next frame as if the window had resized. */
	invalidate() {
		this.#resized = true;
		this.#queue();
	}

	/** Call `fn(snapshot)` now and on every frame the page scrolled or resized. */
	subscribe(fn, { immediate = true } = {}) {
		this.#start();
		this.#subs.add(fn);
		if (immediate) fn(this.snapshot({ scrolled: false, resized: true }));
		return () => this.#subs.delete(fn);
	}
}

export const viewport = new Viewport();
