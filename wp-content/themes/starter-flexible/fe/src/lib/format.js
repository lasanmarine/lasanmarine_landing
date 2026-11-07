// Numbers for people (page locale, grouped) and numbers for pasting (the
// machine's own locale, ungrouped), so a value dropped into a spreadsheet
// lands on the decimal mark that machine expects.

export const formatNumber = (n, digits, locale) => n.toLocaleString(locale, { maximumFractionDigits: digits });

export const plainNumber = (n, digits = 6) =>
	n.toLocaleString(undefined, { maximumFractionDigits: digits, useGrouping: false });

export const round = (n, digits = 0) => {
	const f = 10 ** digits;
	return Math.round(n * f) / f;
};

export const clamp = (n, min, max) => Math.min(max, Math.max(min, n));

/** A number field's value, or null when it is empty or not a number. */
export const toNumber = (raw) => {
	if (raw === null || raw === undefined || String(raw).trim() === '') return null;
	const n = Number(raw);
	return Number.isFinite(n) ? n : null;
};
