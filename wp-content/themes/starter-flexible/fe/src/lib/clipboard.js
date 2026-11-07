// Copy text. navigator.clipboard needs a secure context; on plain http (local
// dev, an intranet mirror) a hidden textarea and execCommand stand in for it.
export async function copyText(text) {
	try {
		await navigator.clipboard.writeText(text);
		return true;
	} catch {
		/* fall through */
	}
	const scratch = document.createElement('textarea');
	scratch.value = text;
	scratch.setAttribute('readonly', '');
	scratch.style.cssText = 'position:fixed;top:0;left:-9999px;opacity:0';
	document.body.append(scratch);
	scratch.select();
	let done = false;
	try {
		done = document.execCommand('copy');
	} catch {
		done = false;
	}
	scratch.remove();
	return done;
}

/** Copy, then add `className` to `el` for `ms` so the button can say "done". */
export async function copyWithFeedback(el, text, { className = 'is-copied', ms = 1400 } = {}) {
	if (!(await copyText(text))) return false;
	el.classList.add(className);
	clearTimeout(el._copyTimer);
	el._copyTimer = setTimeout(() => el.classList.remove(className), ms);
	return true;
}
