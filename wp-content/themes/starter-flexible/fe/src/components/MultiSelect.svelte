<script>
	// A searchable, multi-select popover over a list of strings. The trigger
	// reads like a <select>; the panel holds a filter box and one checkbox per
	// option. `selected` is bindable: the parent owns the selection.
	//
	// The trigger's label names as many picks as fit, then "và %d khác"; how
	// many fit is a question only the rendered box can answer, so it is written
	// longest-first and shortened until it stops overflowing.

	/**
	 * @type {{
	 *   id: string, label: string, placeholder: string, searchLabel: string,
	 *   more: string, countOnly: string, clearLabel: string, noneFound: string,
	 *   options: string[], note?: string, selected: string[], caret: string,
	 *   onchange?: (selected: string[]) => void
	 * }}
	 */
	let {
		id,
		label,
		placeholder,
		searchLabel,
		more,
		countOnly,
		clearLabel,
		noneFound,
		options,
		note = '',
		selected = $bindable([]),
		caret,
		onchange,
	} = $props();

	let open = $state(false);
	let query = $state('');
	let root = $state();
	let trigger = $state();
	let valueEl = $state();
	let searchEl = $state();

	const shown = $derived.by(() => {
		const q = query.trim().toLowerCase();
		return q ? options.filter((o) => o.toLowerCase().includes(q)) : options;
	});

	const labelFor = (names, count) => {
		const rest = names.length - count;
		if (count === 0) return countOnly.replace('%d', String(names.length));
		const head = names.slice(0, count).join(', ');
		return rest > 0 ? `${head} ${more.replace('%d', String(rest))}` : head;
	};

	function fitLabel() {
		if (!valueEl) return;
		if (!selected.length) {
			valueEl.textContent = placeholder;
			return;
		}
		for (let n = selected.length; n >= 0; n -= 1) {
			valueEl.textContent = labelFor(selected, n);
			// A hidden or not-yet-laid-out box measures 0: take the first candidate.
			if (valueEl.clientWidth === 0 || valueEl.scrollWidth <= valueEl.clientWidth) return;
		}
	}

	$effect(() => {
		void selected.length;
		void selected.join('|');
		fitLabel();
	});

	$effect(() => {
		if (!trigger || !('ResizeObserver' in window)) return;
		const ro = new ResizeObserver(fitLabel);
		ro.observe(trigger);
		return () => ro.disconnect();
	});

	$effect(() => {
		if (open) searchEl?.focus();
	});

	function toggle(option, checked) {
		selected = checked ? [...selected, option] : selected.filter((s) => s !== option);
		onchange?.(selected);
	}

	function clear() {
		selected = [];
		onchange?.(selected);
	}

	function onDocClick(e) {
		if (open && root && !root.contains(e.target)) open = false;
	}

	function onKeydown(e) {
		if (e.key !== 'Escape' || !open) return;
		open = false;
		trigger?.focus();
	}

	export function reset() {
		query = '';
		open = false;
	}
</script>

<svelte:document onclick={onDocClick} />

<div class="field">
	<span class="field__label" id={`${id}-label`}>{label}</span>
	<div class="pc__multi" bind:this={root} onkeydown={onKeydown} role="presentation">
		<button
			type="button"
			class="field__control pc__multi-trigger"
			class:is-empty={selected.length === 0}
			{id}
			aria-expanded={open}
			aria-haspopup="dialog"
			aria-labelledby={`${id}-label ${id}`}
			bind:this={trigger}
			onclick={() => (open = !open)}
		>
			<span class="pc__multi-value" bind:this={valueEl}>{placeholder}</span>
			<span class="pc__multi-caret" aria-hidden="true">{@html caret}</span>
		</button>
		<div class="pc__multi-pop" role="dialog" aria-label={label} hidden={!open}>
			<input
				class="field__control pc__multi-search"
				type="search"
				placeholder={searchLabel}
				aria-label={searchLabel}
				bind:value={query}
				bind:this={searchEl}
			/>
			{#if note}
				<p class="pc__multi-note">{note}</p>
			{/if}
			<div class="pc__multi-list">
				{#each shown as option (option)}
					<label class="pc__multi-option">
						<input
							type="checkbox"
							value={option}
							checked={selected.includes(option)}
							onchange={(e) => toggle(option, e.currentTarget.checked)}
						/>
						<span>{option}</span>
					</label>
				{:else}
					<p class="pc__multi-empty">{noneFound}</p>
				{/each}
			</div>
			<div class="pc__multi-foot">
				<button type="button" class="pc__multi-clear" onclick={clear}>{clearLabel}</button>
			</div>
		</div>
	</div>
</div>
