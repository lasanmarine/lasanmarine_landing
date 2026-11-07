import { describe, it, expect } from 'vitest';
import { propellerRpm, shaftDiameter } from '../src/lib/shaft';
import { toNumber, round, plainNumber } from '../src/lib/format';
import { slugify } from '../src/lib/slug';

describe('shaft', () => {
	it('propeller rpm is engine rpm over the ratio', () => {
		expect(propellerRpm(1800, 3)).toBe(600);
		expect(propellerRpm(1800, 0)).toBeNull();
		expect(propellerRpm(0, 2)).toBeNull();
	});

	it('d = k3 · ∛(P/n)', () => {
		// The Shaft Diameter tool's defaults: 750 kW, 1800 rpm, ratio 1, k3 = 100.
		expect(shaftDiameter(750, 1800, 100)).toBeCloseTo(100 * Math.cbrt(750 / 1800), 10);
		expect(shaftDiameter(750, 0, 100)).toBeNull();
		expect(shaftDiameter(0, 600, 100)).toBeNull();
	});
});

describe('format', () => {
	it('reads number fields, empty as null', () => {
		expect(toNumber('')).toBeNull();
		expect(toNumber(null)).toBeNull();
		expect(toNumber('abc')).toBeNull();
		expect(toNumber('12.5')).toBe(12.5);
		expect(toNumber(0)).toBe(0);
	});

	it('rounds and prints plain numbers without grouping', () => {
		expect(round(1.2345, 2)).toBe(1.23);
		expect(plainNumber(1234567.891, 2)).not.toMatch(/[,.\s]\d{3}[,.\s]/);
	});
});

describe('slug', () => {
	it('drops Vietnamese marks', () => {
		expect(slugify('Đội ngũ kỹ sư')).toBe('doi-ngu-ky-su');
	});
});
