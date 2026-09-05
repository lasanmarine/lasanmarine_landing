/* global wp, jQuery, YoastSEO */
(function () {
	'use strict';
	const name = 'lasan-rendered-blocks';
	let started = false;
	function start() {
		if (started || !window.YoastSEO || !YoastSEO.app) return;
		started = true;
		let previous = null;
		let rendered = null;
		let timer;
		let revision = 0;
		let controller;
		YoastSEO.app.registerPlugin(name, { status: 'ready' });
		YoastSEO.app.registerModification('content', function (content) {
			return rendered === null ? content : rendered;
		}, name, 10);
		function refresh() {
			const editor = wp.data.select('core/editor');
			if (!editor) return;
			const id = editor.getCurrentPostId();
			const content = editor.getEditedPostContent();
			const key = id + ':' + content;
			if (!id || key === previous) return;
			previous = key;
			rendered = null;
			const currentRevision = ++revision;
			clearTimeout(timer);
			if (controller) controller.abort();
			if (!content.includes('<!-- wp:acf/')) return;
			timer = setTimeout(async function () {
				controller = new AbortController();
				try {
					const result = await wp.apiFetch({
						path: '/lasan/v1/seo-content/' + id,
						method: 'POST',
						data: { content: content },
						signal: controller.signal
					});
					if (currentRevision !== revision) return;
					rendered = result.html;
					YoastSEO.app.pluginReloaded(name);
				} catch (error) {
					if (currentRevision !== revision || error.name === 'AbortError') return;
					// Keep native analysis available; retry on the next content edit.
					rendered = null;
					YoastSEO.app.pluginReloaded(name);
					console.warn('Lasan: could not render ACF content for Yoast.', error);
				}
			}, 700);
		}
		wp.data.subscribe(refresh);
		refresh();
	}
	jQuery(window).on('YoastSEO:ready', start);
	jQuery(start);
}());
