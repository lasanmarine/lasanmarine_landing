const box = document.querySelector('[data-lightbox]');
const holder = box?.querySelector('[data-lightbox-data]');
if (box && holder?.textContent) {
	const items = JSON.parse(holder.textContent);
	const pad = (n) => String(n).padStart(2, '0');
	const stage = box.querySelector('[data-lightbox-label]');
	let at = 0;

	const render = () => {
		const item = items[at];
		box.querySelector('[data-lightbox-counter]').textContent =
			`${pad(at + 1)} / ${pad(items.length)}`;
		// With a picture attached the stage shows it; otherwise it falls back to
		// the placeholder label, exactly as the static site does.
		if (item.full) {
			stage.textContent = '';
			const img = document.createElement('img');
			img.src = item.full;
			img.alt = item.caption ?? '';
			stage.appendChild(img);
		} else {
			stage.textContent = item.placeholder;
		}
		box.querySelector('[data-lightbox-caption]').textContent = item.caption;
	};

	const open = (i) => {
		at = i;
		render();
		box.hidden = false;
		document.body.style.overflow = 'hidden';
	};
	const close = () => {
		box.hidden = true;
		document.body.style.overflow = '';
	};
	const step = (d) => {
		at = (at + d + items.length) % items.length;
		render();
	};

	document.querySelectorAll('[data-gallery-open]').forEach((btn) => {
		btn.addEventListener('click', () => open(Number(btn.dataset.i ?? 0)));
	});
	box.querySelector('[data-lightbox-close]')?.addEventListener('click', close);
	box.querySelector('[data-lightbox-prev]')?.addEventListener('click', () => step(-1));
	box.querySelector('[data-lightbox-next]')?.addEventListener('click', () => step(1));
	box.addEventListener('click', (e) => {
		if (e.target === box) close();
	});
	document.addEventListener('keydown', (e) => {
		if (box.hidden) return;
		if (e.key === 'Escape') close();
		if (e.key === 'ArrowLeft') step(-1);
		if (e.key === 'ArrowRight') step(1);
	});
}
