<script>
	// Design Brief — the form that opens a design job.
	//
	// The form is drawn from the schema PHP builds (inc/schema.php). State is
	// one global scope plus one scope per engine (see lib/brief/model.js);
	// everything else — the design code, propeller rpm and minimum shaft
	// diameter, the outline, the text copy, the printed document — is derived
	// from it. The draft is kept in localStorage while it is written and posted
	// through Contact Form 7 when it is sent.
	import { tick, untrack } from 'svelte';
	import {
		newScope,
		engineName,
		valueOf,
		computed,
		codeOf,
		composeCode,
		collect,
		restore,
		outline,
		asText,
		modelsFor,
		formatMoney,
	} from '$lib/brief/model';
	import { documentHtml } from '$lib/brief/document';
	import { copyText } from '$lib/clipboard';
	import { printHtml } from '$lib/print';
	import { readJson, writeJson, removeKey } from '$lib/storage';

	/**
	 * @type {{
	 *   heading: string, intro: string,
	 *   schema: { sections: any[], engine: {title: string, rows: any[]}[] },
	 *   catalogue: {make: string, model: string, kw: number, rpm: number}[],
	 *   letterhead: Record<string, string>, canSend: boolean,
	 *   labels: Record<string, string>, icons: Record<string, string>
	 * }}
	 */
	let { heading, intro, schema, catalogue, letterhead, canSend, labels, icons } = $props();

	const STORAGE_KEY = `lasan-design-brief:${location.pathname}`;

	// Props are static (printed once by PHP), so they are read once.
	const initial = untrack(() => restore(schema, readJson(STORAGE_KEY, {})));
	let global = $state(initial.global);
	let engines = $state(initial.engines);
	let saved = $state(Boolean(readJson(STORAGE_KEY, {})?.fields));
	let copied = $state(false);
	let formEl = $state();
	let engineEls = $state([]);

	/* ---- editing ---------------------------------------------------------- */

	function writeDraft() {
		if (writeJson(STORAGE_KEY, collect(schema, global, engines, { url: location.href }))) saved = true;
	}

	function changed(scope, name) {
		if (scope === global && (name === 'province' || name === 'design_type')) {
			const code = composeCode(global.values.design_code, codeOf(global, 'province'), codeOf(global, 'design_type'));
			if (code !== null) global.values.design_code = code;
		}
		writeDraft();
	}

	/** Typing by hand drops a remembered catalogue code: the words are the value now. */
	function type(scope, field, value) {
		scope.values[field.name] = value;
		if (field.type === 'combo' && scope.picked[field.name] !== value) {
			delete scope.codes[field.name];
			delete scope.picked[field.name];
		}
		changed(scope, field.name);
	}

	/** Clicking a catalogue entry types it in and remembers the code behind it. */
	function pick(scope, field, option) {
		scope.values[field.name] = option.label;
		scope.codes[field.name] = option.value || option.label;
		scope.picked[field.name] = option.label;
		// Picking a model brings its power and rpm with it; typing one does not,
		// because a machine outside the catalogue has no figures to carry. A
		// shaft material brings its k3.
		const data = option.data || {};
		if (field.name === 'engine_model') {
			if (data.kw) scope.values.engine_kw = String(data.kw);
			if (data.rpm) scope.values.engine_rpm = String(data.rpm);
		}
		if (field.name === 'shaft_material' && data.k3) scope.values.k3 = String(data.k3);
		changed(scope, field.name);
	}

	function optionsOf(scope, field) {
		return field.name === 'engine_model' ? modelsFor(catalogue, scope.values.engine_make) : field.options || [];
	}

	function emptyText(scope, field) {
		if (field.name !== 'engine_model') return labels.noPresets;
		return String(scope.values.engine_make || '').trim() ? labels.noModels : labels.pickMakeFirst;
	}

	async function addEngine() {
		engines.push(newScope());
		writeDraft();
		await tick();
		engineEls[engines.length - 1]?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
	}

	function removeEngine(index) {
		if (engines.length < 2) return;
		engines.splice(index, 1);
		writeDraft();
	}

	function clearAll(e) {
		e.preventDefault();
		removeKey(STORAGE_KEY);
		global = newScope();
		engines = [newScope()];
		saved = false;
	}

	/* ---- output ----------------------------------------------------------- */

	const sections = $derived(outline(schema, global, engines, labels.engine));
	const named = (name) => valueOf(global, name).trim();

	let copyTimer = 0;
	async function copyBrief() {
		if (!(await copyText(asText(sections)))) return;
		copied = true;
		clearTimeout(copyTimer);
		copyTimer = setTimeout(() => (copied = false), 1600);
	}

	function printBrief() {
		printHtml(documentHtml({ sections, letterhead, named }));
	}

	// Contact Form 7 does the sending: the brief goes into its hidden fields and
	// its own submit is clicked. brief-json carries the whole thing.
	function send() {
		const holder = formEl?.closest('section')?.querySelector('[data-db-cf7]');
		const cf7 = holder?.querySelector('form');
		if (!cf7) return;
		const put = (name, text) => {
			const field = cf7.querySelector(`[name="${name}"]`);
			if (field) field.value = text;
		};
		put('brief-code', named('design_code') || named('vessel_no') || '—');
		put('brief-customer', named('customer_name'));
		put('brief-vessel', named('vessel_no'));
		put('brief-email', named('customer_email'));
		put('brief-body', asText(sections));
		put('brief-json', JSON.stringify(collect(schema, global, engines, { url: location.href }), null, 2));
		cf7.querySelector('.wpcf7-submit')?.click();
		holder.scrollIntoView({ behavior: 'smooth', block: 'center' });
	}
</script>

{#snippet field(scope, f, name)}
	{@const id = `db-${name}`}
	{@const value = valueOf(scope, f.name)}
	{@const isComputed = computed(scope, f.name) !== undefined}
	<div
		class="field db__field"
		class:db__field--combo={f.type === 'combo'}
		data-db-field
		data-name={name}
		data-label={f.label}
		data-unit={f.unit || undefined}
	>
		<label class="field__label" for={id}>{f.label}</label>

		{#if f.type === 'textarea'}
			<textarea class="field__control" {id} {name} rows="3" {value} oninput={(e) => type(scope, f, e.currentTarget.value)}
			></textarea>
		{:else if f.type === 'combo'}
			{@const options = optionsOf(scope, f)}
			<div class="db__control">
				<input
					class="field__control"
					{id}
					{name}
					type="text"
					autocomplete="off"
					placeholder={f.placeholder || labels.comboHint}
					{value}
					oninput={(e) => type(scope, f, e.currentTarget.value)}
				/>
			</div>
			<div class="db__presets" class:db__presets--scroll={f.scroll}>
				{#each options as option (option.value + option.label)}
					<button
						type="button"
						class="db__preset"
						class:is-picked={option.label === value.trim()}
						onclick={() => pick(scope, f, option)}>{option.label}</button
					>
				{:else}
					<p class="db__presets-empty">{f.empty || emptyText(scope, f)}</p>
				{/each}
			</div>
		{:else}
			<div class="db__control" class:db__control--unit={f.unit}>
				<input
					class="field__control"
					{id}
					{name}
					type={f.type}
					step={f.type === 'number' ? 'any' : undefined}
					inputmode={f.type === 'number' ? 'decimal' : undefined}
					readonly={f.readonly || isComputed}
					{value}
					oninput={(e) => type(scope, f, e.currentTarget.value)}
					onblur={f.name === 'fee'
						? (e) => {
								const formatted = formatMoney(e.currentTarget.value);
								if (formatted !== value) type(scope, f, formatted);
							}
						: undefined}
				/>
				{#if f.unit}<span class="db__unit">{f.unit}</span>{/if}
			</div>
		{/if}

		{#if f.hint}<span class="field__hint">{f.hint}</span>{/if}
	</div>
{/snippet}

{#snippet rows(list, scope, nameOf)}
	{#each list as row, r (r)}
		<div class="db__row-group">
			{#if row.title}<span class="db__row-title">{row.title}</span>{/if}
			<div class={`db__row db__row--${row.cols}`}>
				{#each row.fields as f (f.name)}
					{@render field(scope, f, nameOf(f.name))}
				{/each}
			</div>
		</div>
	{/each}
{/snippet}

<form class="db__form" novalidate bind:this={formEl} onsubmit={(e) => e.preventDefault()} onreset={clearAll}>
	<header class="db__intro">
		{#if heading.trim()}<h2 class="h3">{heading}</h2>{/if}
		{#if intro}<p class="copy">{intro}</p>{/if}
	</header>

	{#each schema.sections as section, s (s)}
		<fieldset class="db__section">
			<!-- The legend names the group for assistive tech; the visible head is a
			     grid column of its own, which a rendered <legend> cannot be. -->
			<legend class="sr-only">{section.title}</legend>
			<div class="db__section-head" aria-hidden="true">
				<p class="db__legend">{section.title}</p>
				{#if section.note}<p class="db__note">{section.note}</p>{/if}
			</div>
			<div class="db__section-body">
			{#if section.engines}
				<div class="db__engines">
					{#each engines as engine, i (engine)}
						<fieldset class="db__engine" bind:this={engineEls[i]}>
							<legend class="db__engine-title">{labels.engine} <span>{i + 1}</span></legend>
							{#if engines.length > 1}
								<button type="button" class="db__engine-remove" aria-label={labels.removeEngine} onclick={() => removeEngine(i)}>
									{@html icons.close}
								</button>
							{/if}
							{#each schema.engine as group, g (g)}
								<h3 class="db__sub">{group.title}</h3>
								{@render rows(group.rows, engine, (base) => engineName(i, base))}
							{/each}
						</fieldset>
					{/each}
				</div>
				<button type="button" class="btn btn--secondary btn--sm db__add" onclick={addEngine}>
					{labels.addEngine}
					{@html icons.plus}
				</button>
			{:else}
				{@render rows(section.rows, global, (base) => base)}
			{/if}
			</div>
		</fieldset>
	{/each}

	<footer class="db__actions">
		<button type="button" class="btn" class:is-copied={copied} onclick={copyBrief}>
			{labels.copy}
			{@html icons.arrow}
		</button>
		<button type="button" class="btn btn--secondary" onclick={printBrief}>{labels.print}</button>
		{#if canSend}
			<button type="button" class="btn btn--secondary" onclick={send}>{labels.send}</button>
		{/if}
		<button type="reset" class="btn btn--ghost">{labels.clear}</button>
		<span class="db__saved" hidden={!saved}>{labels.saved}</span>
	</footer>
</form>
