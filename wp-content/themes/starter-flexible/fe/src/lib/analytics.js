// GA4 events through gtag or the GTM dataLayer already on the page.
export function track(name, params = {}) {
	const payload = { ...params, page_path: location.pathname };
	if (typeof window.gtag === 'function') window.gtag('event', name, payload);
	else (window.dataLayer = window.dataLayer || []).push({ event: name, ...payload });
}

/** `lasanmarine-{slug}` on the block wrapper names the section. */
export const blockName = (el) =>
	((el && el.className.toString().match(/lasanmarine-([a-z-]+)/)) || [])[1] || 'other';
