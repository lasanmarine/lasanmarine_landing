<script>
	// The sticky "on this page" bar. Shown once the reader has moved past most
	// of the hero (measured by scroll distance: a stacked, pinned hero never
	// leaves the viewport); highlights the section in the upper part of the
	// screen and keeps that chip in view in the scrollable row on phones.
	import { viewport } from '../lib/stores/viewport.svelte.js';

	/** @type {{ hero: HTMLElement, items: {id: string, title: string}[], ariaLabel: string }} */
	let { hero, items, ariaLabel } = $props();

	let list = $state();
	let links = $state([]);
	let current = $state(null);
	let visible = new Map();

	const shown = $derived(viewport.scrollY > hero.offsetHeight * 0.6);

	$effect(() => {
		// Make sure the shared pipeline is running so scrollY stays current.
		return viewport.subscribe(() => {});
	});

	$effect(() => {
		const sections = items.map((it) => document.getElementById(it.id)).filter(Boolean);
		const io = new IntersectionObserver(
			(entries) => {
				entries.forEach((e) => visible.set(e.target.id, e.isIntersecting));
				// Stacked sheets stay pinned under the newer ones, so the section
				// being read is the last one in view, not the first.
				current = [...items].reverse().find((it) => visible.get(it.id))?.id ?? null;
			},
			{ rootMargin: '-30% 0px -60% 0px' },
		);
		sections.forEach((s) => io.observe(s));
		return () => io.disconnect();
	});

	$effect(() => {
		const i = items.findIndex((it) => it.id === current);
		const a = links[i];
		if (!a || !list) return;
		const left = a.offsetLeft - list.clientWidth / 2 + a.offsetWidth / 2;
		list.scrollTo({ left: Math.max(0, left), behavior: 'smooth' });
	});
</script>

<nav class="onpage" class:is-shown={shown} aria-label={ariaLabel}>
	<div class="onpage__in">
		<div class="onpage__list" bind:this={list}>
			{#each items as item, i (item.id)}
				<a
					class="onpage__link"
					class:is-active={current === item.id}
					href={`#${item.id}`}
					aria-current={current === item.id ? 'true' : undefined}
					bind:this={links[i]}>{item.title}</a
				>
			{/each}
		</div>
	</div>
</nav>
