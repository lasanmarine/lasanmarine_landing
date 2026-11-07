// localStorage that never throws (private windows, blocked storage).
export function readJson(key, fallback) {
	try {
		const raw = localStorage.getItem(key);
		return raw ? JSON.parse(raw) : fallback;
	} catch {
		return fallback;
	}
}

export function writeJson(key, value) {
	try {
		localStorage.setItem(key, JSON.stringify(value));
		return true;
	} catch {
		return false;
	}
}

export function removeKey(key) {
	try {
		localStorage.removeItem(key);
	} catch {
		/* nothing to clear */
	}
}
