<script>
	// A copy button for one value: icon swaps to a check for a moment once the
	// value is on the clipboard (styled by `.is-copied` in the tool CSS).
	import { copyText } from '../lib/clipboard';

	/** @type {{ value: string|null, label: string, icons: {copy: string, check: string}, class?: string, ms?: number }} */
	let { value, label, icons, class: className = 'pc__copy', ms = 1400 } = $props();

	let copied = $state(false);
	let timer = 0;

	async function copy() {
		if (value === null || value === undefined || value === '') return;
		if (!(await copyText(String(value)))) return;
		copied = true;
		clearTimeout(timer);
		timer = setTimeout(() => (copied = false), ms);
	}

	$effect(() => () => clearTimeout(timer));
</script>

<button type="button" class={className} class:is-copied={copied} aria-label={label} disabled={value === null || value === ''} onclick={copy}>
	{@html icons.copy}
	{@html icons.check}
</button>
