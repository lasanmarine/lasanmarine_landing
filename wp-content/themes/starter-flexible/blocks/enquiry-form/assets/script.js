const toast = document.querySelector('[data-toast]');

document.querySelectorAll('[data-enquiry]').forEach((form) => {
	const error = form.querySelector('[data-enquiry-error]');

	form.addEventListener('submit', (e) => {
		e.preventDefault();
		if (!form.checkValidity()) {
			if (error) {
				error.textContent = form.dataset.errorText ?? '';
				error.hidden = false;
			}
			form.querySelector(':invalid')?.focus();
			return;
		}
		if (error) error.hidden = true;
		form.reset();

		if (toast) {
			const title = toast.querySelector('[data-toast-title]');
			if (title) title.textContent = form.dataset.toastText ?? '';
			toast.hidden = false;
			window.setTimeout(() => (toast.hidden = true), 4000);
		}
	});
});
