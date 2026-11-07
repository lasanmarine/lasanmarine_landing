<script>
	// Power Converter — one value in one unit, every other unit derived from it.
	// Everything shown is a $derived of three inputs: value, unit, precision.
	import { untrack } from 'svelte';
	import CopyButton from '$components/CopyButton.svelte';
	import { formatNumber, plainNumber, clamp, toNumber } from '$lib/format';
	import { pageLocale } from '$lib/i18n';

	/**
	 * @type {{
	 *   moduleClass: string, inputId: string, initialValue: number, defaultPrecision: number,
	 *   units: {id: string, label: string, factor: number, is_default: boolean}[],
	 *   labels: Record<string, string>, icons: Record<string, string>
	 * }}
	 */
	let { moduleClass, inputId, initialValue, defaultPrecision, units, labels, icons } = $props();

	const defaultUnit = () => (units.find((u) => u.is_default) ?? units[0]).id;

	// Props are static (printed once by PHP), so they seed state once.
	let raw = $state(untrack(() => initialValue));
	let unitId = $state(defaultUnit());
	let precision = $state(untrack(() => defaultPrecision));

	const locale = pageLocale();
	const digits = $derived(clamp(Number(precision) || 0, 0, 6));
	const from = $derived(units.find((u) => u.id === unitId));
	// A number input bound in Svelte hands back a number, or null when empty.
	const value = $derived(toNumber(raw));
	const kw = $derived((value ?? NaN) * (from?.factor ?? NaN));
	const valid = $derived(
		value !== null && value >= 0 && units.every((u) => u.factor > 0 && Number.isFinite(kw / u.factor)),
	);
	const results = $derived(
		units.map((u) => {
			const n = kw / u.factor;
			return {
				...u,
				text: valid ? formatNumber(n, digits, locale) : '—',
				plain: valid ? plainNumber(n, digits) : null,
			};
		}),
	);

	function reset(e) {
		e.preventDefault();
		raw = initialValue;
		unitId = defaultUnit();
		precision = defaultPrecision;
	}
</script>

<form class={moduleClass} novalidate onsubmit={(e) => e.preventDefault()} onreset={reset}>
	<div class="pc__grid">
		<div class="pc__inputs" data-reveal="left">
			<div class="field">
				<label class="field__label" for={inputId}>{labels.input}</label>
				<input
					class="field__control"
					id={inputId}
					name="value"
					type="number"
					step="any"
					min="0"
					inputmode="decimal"
					aria-describedby={`${inputId}-error`}
					aria-invalid={!valid}
					bind:value={raw}
				/>
			</div>
			<p class="pc__error" id={`${inputId}-error`} hidden={valid}>{labels.error}</p>

			<fieldset class="pc__units">
				<legend class="field__label">{labels.unit}</legend>
				<div class="pc__choices">
					{#each units as unit (unit.id)}
						<label class="pc__choice">
							<input type="radio" name="unit" value={unit.id} bind:group={unitId} />
							<span>{unit.label}</span>
						</label>
					{/each}
				</div>
			</fieldset>

			<!-- Rounding is an input, so it lives with the inputs: the two cards
			     then carry about the same weight. -->
			<p class="field__hint pc__note">
				{labels.notePre}
				<input
					type="number"
					class="pc__precision"
					min="0"
					max="6"
					step="1"
					aria-label={labels.precision}
					bind:value={precision}
				/>
				{labels.notePost}
			</p>

			<button type="reset" class="btn btn--secondary pc__reset">
				{labels.reset}
				{@html icons.arrow}
			</button>
		</div>

		<div class="pc__results" data-reveal="right">
			<h2 class="pc__heading">{labels.results}</h2>
			<div class="pc__result-list" aria-live="polite" aria-atomic="true" data-reveal-stagger>
				{#each results as row (row.id)}
					<div class="pc__result" class:is-source={row.id === unitId}>
						<span class="pc__result-label">{row.label}</span>
						<output class="pc__result-value" for={inputId} aria-label={row.label}>{row.text}</output>
						<CopyButton value={row.plain} label={labels.copy} {icons} />
					</div>
				{/each}
			</div>
		</div>
	</div>
</form>
