// The mathematics behind the site's motion. Pure functions, no DOM: unit
// tested in tests/motion-math.test.js and used both at build time
// (scripts/easing.mjs writes the CSS easing tokens) and at run time.

export const clamp = (v, lo, hi) => Math.min(hi, Math.max(lo, v));

/** Map v from [a, b] to [0, 1], clamped. */
export const progress = (v, a, b) => clamp((v - a) / (b - a || 1), 0, 1);

/** Cubic Hermite smoothstep: C¹, zero slope at both ends. */
export const smoothstep = (t) => t * t * (3 - 2 * t);

/**
 * A damped spring released from rest at 0 toward 1, as a function of time.
 *
 *   m·x'' + c·x' + k·(x − 1) = 0,   x(0) = 0,   x'(0) = v0
 *
 * With ω₀ = √(k/m) and ζ = c / (2√(km)) the closed-form solution is
 *   ζ < 1  x = 1 − e^(−ζω₀t)·(cos ω_d t + (ζω₀ − v0)/ω_d · sin ω_d t),  ω_d = ω₀√(1−ζ²)
 *   ζ = 1  x = 1 − e^(−ω₀t)·(1 + (ω₀ − v0)·t)
 *   ζ > 1  a sum of two decaying exponentials (roots r₁, r₂ of m r² + c r + k)
 * Exact at every t, so the curve never depends on a frame rate.
 *
 * @returns {{ at: (t: number) => number, settle: number, zeta: number, omega: number }}
 *          `at(t)` with t in seconds; `settle` = time after which |1 − x| stays
 *          under `tolerance` (the envelope bound, so it holds for every later t).
 */
export function spring({ stiffness = 170, damping = 26, mass = 1, velocity = 0, tolerance = 0.001 } = {}) {
	const w0 = Math.sqrt(stiffness / mass);
	const zeta = damping / (2 * Math.sqrt(stiffness * mass));
	let at;
	let envelope; // an upper bound on |1 − x(t)|
	if (zeta < 1) {
		const wd = w0 * Math.sqrt(1 - zeta * zeta);
		const B = (zeta * w0 - velocity) / wd;
		at = (t) => 1 - Math.exp(-zeta * w0 * t) * (Math.cos(wd * t) + B * Math.sin(wd * t));
		const amp = Math.sqrt(1 + B * B);
		envelope = (t) => amp * Math.exp(-zeta * w0 * t);
	} else if (zeta === 1) {
		at = (t) => 1 - Math.exp(-w0 * t) * (1 + (w0 - velocity) * t);
		envelope = (t) => Math.exp(-w0 * t) * (1 + Math.abs(w0 - velocity) * t);
	} else {
		const s = w0 * Math.sqrt(zeta * zeta - 1);
		const r1 = -zeta * w0 + s;
		const r2 = -zeta * w0 - s;
		// x = 1 + A e^(r1 t) + C e^(r2 t), x(0)=0, x'(0)=v0
		const A = (velocity + r2) / (r1 - r2);
		const C = -1 - A;
		at = (t) => 1 + A * Math.exp(r1 * t) + C * Math.exp(r2 * t);
		envelope = (t) => (Math.abs(A) + Math.abs(C)) * Math.exp(r1 * t);
	}
	// Bisection on the (monotone) envelope for the settling time.
	let lo = 0;
	let hi = 1;
	while (envelope(hi) > tolerance && hi < 60) hi *= 2;
	for (let i = 0; i < 50; i++) {
		const mid = (lo + hi) / 2;
		if (envelope(mid) > tolerance) lo = mid;
		else hi = mid;
	}
	return { at, settle: hi, zeta, omega: w0 };
}

/**
 * Spring parameters from the two numbers a designer thinks in: how long it
 * takes to settle (seconds) and how much it bounces (0 = none, critically
 * damped; 0.3 = a visible overshoot). Bounce b maps to ζ = 1 − b; ω₀ is then
 * solved from the settling time, e^(−ζω₀T) ≈ tolerance  ⇒  ω₀ ≈ −ln(tol)/(ζT),
 * and refined by bisection against the exact settle time.
 */
export function springFor(duration, bounce = 0, tolerance = 0.001, launch = 0) {
	// `launch`: the initial velocity as a multiple of ω₀ — the mass is flicked,
	// not released from rest. 0 eases in from rest; 1 with no bounce gives the
	// pure exponential 1 − e^(−ω₀t), which leaves fastest and settles softest.
	const zeta = clamp(1 - bounce, 0.05, 1);
	let lo = 0.5;
	let hi = 400;
	for (let i = 0; i < 60; i++) {
		const w0 = Math.sqrt(lo * hi);
		const s = spring({ stiffness: w0 * w0, damping: 2 * zeta * w0, velocity: launch * w0, tolerance });
		if (s.settle > duration) lo = w0;
		else hi = w0;
	}
	const w0 = Math.sqrt(lo * hi);
	return { stiffness: w0 * w0, damping: 2 * zeta * w0, mass: 1, velocity: launch * w0, tolerance };
}

/**
 * Ramer–Douglas–Peucker: the fewest points whose polyline stays within
 * `epsilon` (vertically) of the sampled curve. Keeps CSS `linear()` short
 * without visible error.
 * @param {Array<[number, number]>} pts
 */
export function simplify(pts, epsilon) {
	if (pts.length < 3) return pts.slice();
	const [x0, y0] = pts[0];
	const [x1, y1] = pts[pts.length - 1];
	let worst = 0;
	let index = 0;
	for (let i = 1; i < pts.length - 1; i++) {
		const [x, y] = pts[i];
		const line = y0 + ((y1 - y0) * (x - x0)) / (x1 - x0 || 1);
		const d = Math.abs(y - line);
		if (d > worst) {
			worst = d;
			index = i;
		}
	}
	if (worst <= epsilon) return [pts[0], pts[pts.length - 1]];
	const left = simplify(pts.slice(0, index + 1), epsilon);
	const right = simplify(pts.slice(index), epsilon);
	return left.slice(0, -1).concat(right);
}

/**
 * A CSS `linear()` easing that follows `fn` on [0, 1] within `epsilon`.
 * @param {(t: number) => number} fn
 */
export function toLinear(fn, { samples = 400, epsilon = 0.002 } = {}) {
	const pts = [];
	for (let i = 0; i <= samples; i++) {
		const t = i / samples;
		pts.push([t, fn(t)]);
	}
	pts[pts.length - 1][1] = 1; // land exactly on the target
	const kept = simplify(pts, epsilon);
	const r = (n, d) => String(+n.toFixed(d));
	const stops = kept.map(([t, y], i) => {
		const pos = i === 0 || i === kept.length - 1 ? '' : ` ${r(t * 100, 2)}%`;
		return r(y, 4) + pos;
	});
	return `linear(${stops.join(', ')})`;
}

/** A spring as a CSS easing plus the duration it needs. */
export function springEasing(duration, bounce = 0, opts = {}) {
	const s = spring(springFor(duration, bounce, 0.001, opts.launch || 0));
	return { easing: toLinear((t) => s.at(t * s.settle), opts), duration: Math.round(s.settle * 1000) };
}

/**
 * Frame-rate independent exponential smoothing toward a target:
 *   x ← target + (x − target)·e^(−λ·dt)
 * the exact solution of x' = λ(target − x) over dt seconds, so 30, 60 and
 * 120 Hz screens end up on the same curve. λ = ln(2) / halfLife.
 */
export function damp(current, target, halfLife, dt) {
	if (halfLife <= 0) return target;
	return target + (current - target) * Math.exp((-Math.LN2 * dt) / halfLife);
}

/**
 * Delay for the i-th item of a staggered entrance. A linear stagger (i·step)
 * keeps the end of a long list waiting for seconds; this one starts at the
 * same pace (slope `step` at i = 0) and approaches `max` without reaching it:
 *   d(i) = max·(1 − e^(−i·step/max))
 */
export function staggerDelay(i, step = 60, max = 480) {
	return max * (1 - Math.exp((-i * step) / max));
}
