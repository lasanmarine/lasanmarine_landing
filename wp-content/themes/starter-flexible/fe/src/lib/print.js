// Print a standalone HTML document through an off-screen iframe: the page's
// own styling never reaches the paper and no popup is opened.
export function printHtml(html) {
	const frame = document.createElement('iframe');
	frame.setAttribute('aria-hidden', 'true');
	frame.style.cssText = 'position:fixed;right:0;bottom:0;width:0;height:0;border:0;visibility:hidden';
	frame.srcdoc = html;
	frame.addEventListener(
		'load',
		() => {
			const view = frame.contentWindow;
			let removed = false;
			const drop = () => {
				if (removed) return;
				removed = true;
				frame.remove();
			};
			view.addEventListener('afterprint', () => setTimeout(drop, 200), { once: true });
			setTimeout(drop, 60000);
			view.focus();
			view.print();
		},
		{ once: true },
	);
	document.body.append(frame);
}
