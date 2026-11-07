<script>
	// Engine Lookup — a filterable, sortable, paginated table over the engine
	// list from Site Settings. All state is here; the visible page is a chain
	// of $derived: filters → sorted rows → current page.
	import { untrack } from 'svelte';
	import MultiSelect from '$components/MultiSelect.svelte';
	import CopyButton from '$components/CopyButton.svelte';
	import { plainNumber, toNumber } from '$lib/format';

	/**
	 * @type {{
	 *   moduleClass: string, searchId: string, rows: {make: string, model: string, kw: number|null, rpm: number|null}[],
	 *   perPage: number, modelSample: number,
	 *   columns: {key: string, label: string}[],
	 *   ranges: {key: string, label: string, unitLabel: string, units: {label: string, factor: number, is_default: boolean}[]}[],
	 *   multis: {key: string, id: string, label: string, placeholder: string, search: string, more: string, count: string}[],
	 *   labels: Record<string, string>, icons: Record<string, string>
	 * }}
	 */
	let { moduleClass, searchId, rows, perPage, modelSample, columns, ranges, multis, labels, icons } = $props();

	const byName = (a, b) => a.localeCompare(b);
	const defaultFactor = (range) => (range.units.find((u) => u.is_default) ?? range.units[0]).factor;
	const freshRanges = () =>
		Object.fromEntries(ranges.map((r) => [r.key, { min: null, max: null, factor: defaultFactor(r) }]));

	let query = $state('');
	let picked = $state({ make: [], model: [] });
	let bounds = $state(freshRanges());
	let sortKey = $state('make');
	let sortDir = $state(1);
	let page = $state(0);
	let sample = $state(shuffleSample());
	let pickers = $state({});

	// Props are static (printed once by PHP), so they are read once.
	const makes = untrack(() => [...new Set(rows.map((e) => e.make))].sort(byName));

	// Every model, sorted, once a make narrows the list; otherwise a random
	// handful so the field shows what kind of thing lives in there.
	function shuffleSample() {
		const pool = [...new Set(rows.map((e) => e.model))];
		for (let i = pool.length - 1; i > 0; i -= 1) {
			const j = Math.floor(Math.random() * (i + 1));
			[pool[i], pool[j]] = [pool[j], pool[i]];
		}
		return pool.slice(0, modelSample).sort(byName);
	}

	const modelOptions = $derived.by(() => {
		if (!picked.make.length) return sample;
		const chosen = new Set(picked.make);
		return [...new Set(rows.filter((e) => chosen.has(e.make)).map((e) => e.model))].sort(byName);
	});
	const options = $derived({ make: makes, model: modelOptions });
	const notes = $derived({ make: '', model: picked.make.length ? '' : labels.model_hint });

	const bound = (key, side) => {
		const v = toNumber(bounds[key][side]);
		return v === null ? null : v * (bounds[key].factor > 0 ? bounds[key].factor : 1);
	};
	const inRange = (value, min, max) => {
		if (typeof value !== 'number' || !Number.isFinite(value)) return min === null && max === null;
		return (min === null || value >= min) && (max === null || value <= max);
	};

	const filtered = $derived.by(() => {
		const q = query.trim().toLowerCase();
		const mk = new Set(picked.make);
		const md = new Set(picked.model);
		const limits = ranges.map((r) => [r.key, bound(r.key, 'min'), bound(r.key, 'max')]);
		return rows
			.filter((e) => !q || `${e.make} ${e.model} ${e.kw} ${e.rpm}`.toLowerCase().includes(q))
			.filter((e) => !mk.size || mk.has(e.make))
			.filter((e) => !md.size || md.has(e.model))
			.filter((e) => limits.every(([key, min, max]) => inRange(e[key], min, max)))
			.sort((a, b) => {
				const x = a[sortKey];
				const y = b[sortKey];
				if (typeof x === 'number' && typeof y === 'number') return (x - y) * sortDir;
				return String(x).localeCompare(String(y)) * sortDir;
			});
	});

	const pages = $derived(Math.max(Math.ceil(filtered.length / perPage), 1));
	const current = $derived(Math.min(page, pages - 1));
	const slice = $derived(filtered.slice(current * perPage, current * perPage + perPage));

	// Any change to the filters starts again from the first page.
	$effect(() => {
		void query;
		void picked.make.length;
		void picked.model.length;
		void JSON.stringify(bounds);
		void sortKey;
		void sortDir;
		page = 0;
	});

	// A make dropped from the selection takes its models out of the picks;
	// a model picked from the random sample stays even when it is not listed.
	function onMakeChange() {
		if (!picked.make.length) return;
		const offered = new Set(modelOptions);
		picked.model = picked.model.filter((m) => offered.has(m));
	}

	function sortBy(key) {
		sortDir = key === sortKey && sortDir === 1 ? -1 : 1;
		sortKey = key;
	}

	function reset() {
		query = '';
		picked = { make: [], model: [] };
		bounds = freshRanges();
		sample = shuffleSample();
		Object.values(pickers).forEach((p) => p?.reset());
	}

	const cellText = (v) => ((v ?? '') === '' ? null : v);
	const copyValue = (v) => (typeof v === 'number' ? plainNumber(v) : String(v));
</script>

<div class={moduleClass}>
	<div class="pc__grid el__grid">
		<div class="pc__inputs" data-reveal="left">
			<div class="field">
				<label class="field__label sr-only" for={searchId}>{labels.search}</label>
				<input class="field__control" id={searchId} type="search" placeholder={labels.search_hint} bind:value={query} />
			</div>

			{#each multis as multi (multi.key)}
				<MultiSelect
					bind:this={pickers[multi.key]}
					bind:selected={picked[multi.key]}
					id={multi.id}
					label={multi.label}
					placeholder={multi.placeholder}
					searchLabel={multi.search}
					more={multi.more}
					countOnly={multi.count}
					clearLabel={labels.clear}
					noneFound={labels.none_found}
					options={options[multi.key]}
					note={notes[multi.key]}
					caret={icons.caret}
					onchange={multi.key === 'make' ? onMakeChange : undefined}
				/>
			{/each}

			{#each ranges as range (range.key)}
				<div class="field">
					<span class="field__label">{range.label}</span>
					<div class="pc__range">
						<input
							class="field__control"
							type="number"
							min="0"
							step="any"
							inputmode="decimal"
							placeholder={labels.from}
							aria-label={`${range.label} — ${labels.from}`}
							bind:value={bounds[range.key].min}
						/>
						<span class="pc__range-sep" aria-hidden="true">–</span>
						<input
							class="field__control"
							type="number"
							min="0"
							step="any"
							inputmode="decimal"
							placeholder={labels.to}
							aria-label={`${range.label} — ${labels.to}`}
							bind:value={bounds[range.key].max}
						/>
						<select class="field__control pc__unit" aria-label={range.unitLabel} bind:value={bounds[range.key].factor}>
							{#each range.units as unit (unit.label)}
								<option value={unit.factor}>{unit.label}</option>
							{/each}
						</select>
					</div>
				</div>
			{/each}

			<button type="button" class="btn btn--secondary pc__reset" onclick={reset}>
				{labels.reset}
				{@html icons.arrow}
			</button>
		</div>

		<div class="pc__results" data-reveal="right">
			<div class="el__head">
				<h2 class="pc__heading">{labels.results}</h2>
				<span class="meta"><span>{filtered.length}</span> {labels.rows_found}</span>
			</div>

			<div class="el__scroll">
				<table class="el__table">
					<thead>
						<tr>
							{#each columns as column (column.key)}
								<th
									scope="col"
									aria-sort={sortKey === column.key ? (sortDir === 1 ? 'ascending' : 'descending') : undefined}
								>
									<button type="button" onclick={() => sortBy(column.key)}>
										{column.label}
										<span class="el__arrow" aria-hidden="true">
											{@html icons.sort}{@html icons.asc}{@html icons.desc}
										</span>
									</button>
								</th>
							{/each}
						</tr>
					</thead>
					<tbody>
						{#each slice as engine, i (`${engine.make}|${engine.model}|${i}`)}
							<tr>
								{#each columns as column (column.key)}
									{@const value = cellText(engine[column.key])}
									<td>
										<div class="el__cell">
											<span>{value ?? '—'}</span>
											{#if value !== null}
												<CopyButton
													class="pc__copy el__copy"
													value={copyValue(value)}
													label={`${labels.copy}: ${copyValue(value)}`}
													icons={{ copy: icons.copySm, check: icons.checkSm }}
												/>
											{/if}
										</div>
									</td>
								{/each}
							</tr>
						{/each}
					</tbody>
				</table>
			</div>

			<p class="el__empty" hidden={filtered.length > 0}>{labels.no_results}</p>

			<div class="el__pager" hidden={filtered.length <= perPage}>
				<button type="button" class="icon-btn icon-btn--sm" aria-label={labels.prev} disabled={current === 0} onclick={() => (page = current - 1)}>
					{@html icons.prev}
				</button>
				<span class="meta">{current + 1} / {pages}</span>
				<button
					type="button"
					class="icon-btn icon-btn--sm"
					aria-label={labels.next}
					disabled={current >= pages - 1}
					onclick={() => (page = current + 1)}
				>
					{@html icons.next}
				</button>
			</div>
		</div>
	</div>
</div>
