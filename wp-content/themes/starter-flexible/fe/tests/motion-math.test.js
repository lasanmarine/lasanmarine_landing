import { describe, it, expect } from 'vitest';
import { spring, springFor, simplify, toLinear, springEasing, damp, staggerDelay, smoothstep, progress } from '../src/lib/motion-math';

/** Numerical solution of m x'' + c x' + k (x − 1) = 0 (RK4), for checking the closed form. */
function integrate({ stiffness: k, damping: c, mass: m = 1, velocity = 0 }, T, dt = 1e-4) {
	let x = 0;
	let v = velocity;
	const a = (x, v) => (-k * (x - 1) - c * v) / m;
	for (let t = 0; t < T - 1e-12; t += dt) {
		const k1x = v, k1v = a(x, v);
		const k2x = v + (dt / 2) * k1v, k2v = a(x + (dt / 2) * k1x, v + (dt / 2) * k1v);
		const k3x = v + (dt / 2) * k2v, k3v = a(x + (dt / 2) * k2x, v + (dt / 2) * k2v);
		const k4x = v + dt * k3v, k4v = a(x + dt * k3x, v + dt * k3v);
		x += (dt / 6) * (k1x + 2 * k2x + 2 * k3x + k4x);
		v += (dt / 6) * (k1v + 2 * k2v + 2 * k3v + k4v);
	}
	return x;
}

describe('spring', () => {
	for (const [label, p] of [
		['under-damped', { stiffness: 170, damping: 12 }],
		['critically damped', { stiffness: 100, damping: 20 }],
		['over-damped', { stiffness: 100, damping: 40 }],
		['with initial velocity', { stiffness: 200, damping: 18, velocity: 5 }],
	]) {
		it(`closed form matches the ODE (${label})`, () => {
			const s = spring(p);
			for (const t of [0, 0.05, 0.2, 0.5, 1]) expect(s.at(t)).toBeCloseTo(integrate(p, t), 4);
		});
	}

	it('starts at 0 and stays within tolerance after settle', () => {
		const s = spring({ stiffness: 170, damping: 12, tolerance: 0.001 });
		expect(s.at(0)).toBeCloseTo(0, 12);
		for (let t = s.settle; t < s.settle + 2; t += 0.01) expect(Math.abs(1 - s.at(t))).toBeLessThanOrEqual(0.001 + 1e-9);
	});

	it('critically damped never overshoots', () => {
		const s = spring({ stiffness: 100, damping: 20 });
		for (let t = 0; t < 3; t += 0.005) expect(s.at(t)).toBeLessThanOrEqual(1 + 1e-12);
	});

	it('springFor hits the requested duration and bounce', () => {
		const p = springFor(0.8, 0);
		expect(spring(p).settle).toBeCloseTo(0.8, 2);
		expect(spring(p).zeta).toBeCloseTo(1, 6);
		const b = springFor(0.6, 0.3);
		expect(spring(b).zeta).toBeCloseTo(0.7, 6);
		const s = spring(b);
		let peak = 0;
		for (let t = 0; t < s.settle; t += 0.001) peak = Math.max(peak, s.at(t));
		expect(peak).toBeGreaterThan(1); // it does overshoot
	});
});

describe('linear() easing', () => {
	it('RDP keeps the polyline within epsilon of the samples', () => {
		const pts = Array.from({ length: 201 }, (_, i) => [i / 200, Math.sin((i / 200) * Math.PI)]);
		const kept = simplify(pts, 0.01);
		expect(kept.length).toBeLessThan(40);
		for (const [x, y] of pts) {
			const j = kept.findIndex(([kx]) => kx >= x);
			const [x1, y1] = kept[Math.max(0, j - 1)];
			const [x2, y2] = kept[Math.max(1, j)];
			const line = y1 + ((y2 - y1) * (x - x1)) / (x2 - x1 || 1);
			expect(Math.abs(line - y)).toBeLessThanOrEqual(0.01 + 1e-9);
		}
	});

	it('produces a valid, short CSS function ending at 1', () => {
		const { easing, duration } = springEasing(0.9, 0);
		expect(easing).toMatch(/^linear\(0, .*, 1\)$/);
		expect(easing.split(',').length).toBeLessThan(40);
		expect(duration).toBe(900);
		expect(toLinear((t) => t)).toBe('linear(0, 1)');
	});
});

describe('helpers', () => {
	it('damp is frame-rate independent', () => {
		let a = 0;
		for (let i = 0; i < 60; i++) a = damp(a, 1, 0.1, 1 / 60); // 60 Hz for 1 s
		let b = 0;
		for (let i = 0; i < 144; i++) b = damp(b, 1, 0.1, 1 / 144); // 144 Hz for 1 s
		expect(a).toBeCloseTo(b, 10);
		expect(damp(0, 1, 0.1, 0.1)).toBeCloseTo(0.5, 10); // one half-life
	});

	it('staggerDelay starts at `step` per item and never passes `max`', () => {
		expect(staggerDelay(0)).toBe(0);
		expect(staggerDelay(1, 60, 480)).toBeCloseTo(480 * (1 - Math.exp(-0.125)), 10); // ≈ 56.4
		for (let i = 0; i < 200; i++) expect(staggerDelay(i, 60, 480)).toBeLessThan(480);
		expect(staggerDelay(5) - staggerDelay(4)).toBeGreaterThan(staggerDelay(15) - staggerDelay(14));
	});

	it('smoothstep and progress', () => {
		expect(smoothstep(0)).toBe(0);
		expect(smoothstep(0.5)).toBe(0.5);
		expect(smoothstep(1)).toBe(1);
		expect(progress(5, 0, 10)).toBe(0.5);
		expect(progress(-5, 0, 10)).toBe(0);
	});
});

describe('launched spring', () => {
	it('critical damping with launch 1 is the pure exponential 1 − e^(−ω₀t)', () => {
		const p = springFor(0.9, 0, 0.001, 1);
		const s = spring(p);
		const w0 = Math.sqrt(p.stiffness);
		for (const t of [0.01, 0.1, 0.3, 0.6]) expect(s.at(t)).toBeCloseTo(1 - Math.exp(-w0 * t), 10);
		expect(s.settle).toBeCloseTo(0.9, 2);
	});
});
