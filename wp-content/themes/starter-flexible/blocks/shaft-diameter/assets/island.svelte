<script>
	// Shaft Diameter — indicative minimum propeller shaft diameter.
	// Power and engine speed each carry a unit select whose value is the factor
	// back to the formula's units (kW, rpm); the formula is lib/shaft.js, the
	// same one the Design Brief uses.
	import CopyButton from '$components/CopyButton.svelte';
	import { propellerRpm, shaftDiameter } from '$lib/shaft';
	import { plainNumber, toNumber } from '$lib/format';

	/**
	 * @type {{
	 *   moduleClass: string, ids: Record<string, string>,
	 *   combos: {key: string, label: string, value: number, unitLabel: string, units: {label: string, factor: number, is_default: boolean}[]}[],
	 *   materials: {name: string, note: string, k3: number, k3Label: string}[],
	 *   labels: Record<string, string>, icons: Record<string, string>
	 * }}
	 */
	let { moduleClass, ids, combos, materials, labels, icons } = $props();

	const defaults = () => ({
		values: Object.fromEntries(combos.map((c) => [c.key, c.value])),
		factors: Object.fromEntries(combos.map((c) => [c.key, (c.units.find((u) => u.is_default) ?? c.units[0]).factor])),
		ratio: 1,
		k3: materials[0]?.k3 ?? 0,
	});

	let form = $state(defaults());

	const power = $derived((toNumber(form.values.power) ?? NaN) * form.factors.power);
	const engineRpm = $derived((toNumber(form.values.rpm) ?? NaN) * form.factors.rpm);
	const n = $derived(propellerRpm(engineRpm, toNumber(form.ratio) ?? 0));
	const d = $derived(n === null ? null : shaftDiameter(power, n, Number(form.k3)));
	const valid = $derived(n !== null && d !== null);

	const rows = $derived([
		{ id: 'prop-rpm', label: labels.propRpm, text: valid ? `${n.toFixed(1)} rpm` : '—', plain: valid ? plainNumber(n, 1) : null },
		{ id: 'result', label: labels.result, text: valid ? `${d.toFixed(1)} mm` : '—', plain: valid ? plainNumber(d, 1) : null },
	]);

	function reset(e) {
		e.preventDefault();
		form = defaults();
	}
</script>

<form class={moduleClass} novalidate onsubmit={(e) => e.preventDefault()} onreset={reset}>
	<div class="pc__grid">
		<div class="pc__inputs" data-reveal="left">
			{#each combos as combo (combo.key)}
				<div class="field">
					<label class="field__label" for={ids[combo.key]}>{combo.label}</label>
					<div class="pc__combo">
						<input
							class="field__control"
							id={ids[combo.key]}
							name={combo.key}
							type="number"
							step="any"
							min="0"
							inputmode="decimal"
							bind:value={form.values[combo.key]}
						/>
						<select class="field__control pc__unit" aria-label={combo.unitLabel} bind:value={form.factors[combo.key]}>
							{#each combo.units as unit (unit.label)}
								<option value={unit.factor}>{unit.label}</option>
							{/each}
						</select>
					</div>
				</div>
			{/each}

			<div class="field">
				<label class="field__label" for={ids.ratio}>{labels.ratio}</label>
				<input
					class="field__control"
					id={ids.ratio}
					name="ratio"
					type="number"
					step="any"
					min="0.01"
					inputmode="decimal"
					bind:value={form.ratio}
				/>
			</div>

			<p class="pc__error" hidden={valid}>{labels.error}</p>

			<fieldset class="pc__units">
				<legend class="field__label">{labels.material}</legend>
				<div class="pc__choices">
					{#each materials as material, i (i)}
						<label class="pc__choice">
							<input type="radio" name="material" value={material.k3} bind:group={form.k3} />
							<span class="sd__choice-text">
								<strong>{material.name}</strong>
								{#if material.note}<em>{material.note}</em>{/if}
							</span>
							<span class="sd__choice-k">k = {material.k3Label}</span>
						</label>
					{/each}
				</div>
			</fieldset>

			<button type="reset" class="btn btn--secondary pc__reset">
				{labels.reset}
				{@html icons.arrow}
			</button>
		</div>

		<div class="pc__results" data-reveal="right">
			<h2 class="pc__heading">{labels.results}</h2>
			<div class="pc__result-list" aria-live="polite" aria-atomic="true" data-reveal-stagger>
				{#each rows as row (row.id)}
					<div class="pc__result">
						<span class="pc__result-label">{row.label}</span>
						<output class="pc__result-value" aria-label={row.label}>{row.text}</output>
						<CopyButton value={row.plain} label={labels.copy} {icons} />
					</div>
				{/each}
			</div>
		</div>
	</div>
</form>
