import { describe, it, expect } from 'vitest';
import {
	newScope,
	valueOf,
	composeCode,
	middleOf,
	collect,
	restore,
	outline,
	asText,
	modelsFor,
	formatMoney,
} from '../src/lib/brief/model';
import { documentHtml } from '../src/lib/brief/document';

const row = (fields, title = '') => ({ title, cols: fields.length, fields });

const schema = {
	sections: [
		{
			title: 'Khách hàng',
			rows: [row([{ name: 'customer_name', label: 'Họ và tên' }], 'Định danh')],
		},
		{
			title: 'Thông tin chung',
			rows: [row([{ name: 'design_code', label: 'Ký hiệu thiết kế' }, { name: 'request_no', label: 'Số đơn' }])],
		},
		{ title: 'Máy', engines: true, rows: [] },
	],
	engine: [
		{
			title: 'Thông số máy',
			rows: [
				row(
					[
						{ name: 'engine_kw', label: 'Công suất', type: 'number', unit: 'kW' },
						{ name: 'engine_rpm', label: 'Số vòng quay', type: 'number', unit: 'rpm' },
						{ name: 'gear_ratio', label: 'Tỉ số truyền', type: 'number' },
					],
					'Công suất & vòng quay',
				),
				row([
					{ name: 'k3', label: 'Hệ số K3', type: 'number' },
					{ name: 'prop_rpm', label: 'Số vòng quay chân vịt', type: 'number', unit: 'rpm', readonly: true },
					{ name: 'shaft_dmin', label: 'Đường kính tối thiểu', type: 'number', unit: 'mm', readonly: true },
				]),
			],
		},
	],
};

function filled() {
	const global = newScope();
	global.values.customer_name = 'Nguyễn Văn A';
	global.values.request_no = '12';
	const engine = newScope();
	Object.assign(engine.values, { engine_kw: '750', engine_rpm: '1800', gear_ratio: '3', k3: '100' });
	engine.codes.engine_kw = 'X';
	const second = newScope();
	second.values.engine_kw = '200';
	return { global, engines: [engine, second] };
}

describe('brief model', () => {
	it('computes propeller rpm and minimum shaft diameter per engine', () => {
		const { engines } = filled();
		expect(valueOf(engines[0], 'prop_rpm')).toBe('600');
		expect(valueOf(engines[0], 'shaft_dmin')).toBe(String(Math.round(100 * Math.cbrt(750 / 600))));
		expect(valueOf(engines[1], 'shaft_dmin')).toBe('');
	});

	it('composes the design code around the typed middle number', () => {
		expect(middleOf('KH-123-TK')).toBe('123');
		expect(composeCode('', 'KH', 'TK')).toBe('KH-000000-TK');
		expect(composeCode('KH-123-TK', 'BĐ', 'TK')).toBe('BĐ-123-TK');
		expect(composeCode('x', '', '')).toBeNull();
	});

	it('collects the same keys as the old DOM script, and restores from them', () => {
		const { global, engines } = filled();
		const brief = collect(schema, global, engines, { now: new Date('2026-01-01T00:00:00Z'), url: 'u' });
		expect(brief.engines).toBe(2);
		expect(brief.fields).toMatchObject({
			customer_name: 'Nguyễn Văn A',
			engine1__engine_kw: '750',
			engine1__prop_rpm: '600',
			engine2__engine_kw: '200',
		});
		expect(brief.units.engine1__engine_kw).toBe('kW');
		expect(brief.codes.engine1__engine_kw).toBe('X');

		const back = restore(schema, brief);
		expect(back.engines).toHaveLength(2);
		expect(back.global.values.customer_name).toBe('Nguyễn Văn A');
		expect(back.engines[0].values.engine_rpm).toBe('1800');
		expect(back.engines[0].codes.engine_kw).toBe('X');
		expect(back.engines[0].picked.engine_kw).toBe('750');
		// Computed fields are never restored as values.
		expect(back.engines[0].values.prop_rpm).toBeUndefined();
	});

	it('restores an empty draft as one blank engine', () => {
		const back = restore(schema, {});
		expect(back.engines).toHaveLength(1);
	});

	it('outlines only what was answered and writes it as text', () => {
		const { global, engines } = filled();
		const sections = outline(schema, global, engines);
		expect(sections.map((s) => s.title)).toEqual(['Khách hàng', 'Thông tin chung', 'Máy']);
		expect(sections[2].blocks.map((b) => b.title)).toEqual(['Máy 1', 'Máy 2']);
		const text = asText(sections);
		expect(text).toContain('KHÁCH HÀNG');
		expect(text).toContain('  · Định danh');
		expect(text).toContain('    Công suất: 750 kW');
	});

	it('offers the models of the make in the box', () => {
		const catalogue = [
			{ make: 'Yanmar', model: '6AYM', kw: 500, rpm: 1900 },
			{ make: 'Cummins', model: 'KTA19', kw: 450, rpm: 1800 },
		];
		expect(modelsFor(catalogue, ' yanmar ')).toEqual([{ value: '6AYM', label: '6AYM', data: { kw: 500, rpm: 1900 } }]);
		expect(modelsFor(catalogue, '')).toEqual([]);
	});

	it('formats the fee as money', () => {
		expect(formatMoney('1234567')).toBe((1234567).toLocaleString('vi-VN'));
		expect(formatMoney('')).toBe('');
	});
});

describe('brief document', () => {
	it('prints the letterhead, parts and escaped values', () => {
		const { global, engines } = filled();
		global.values.customer_name = 'A <b>';
		const sections = outline(schema, global, engines);
		const html = documentHtml({
			sections,
			letterhead: { org: 'LASAN', symbol: 'NVT-LSM', place: 'Khánh Hòa' },
			named: (n) => valueOf(global, n).trim(),
			today: new Date(2026, 10, 7),
		});
		expect(html).toContain('Số: 12/NVT-LSM');
		expect(html).toContain('Khánh Hòa, ngày 07 tháng 11 năm 2026');
		expect(html).toContain('<h2>I. KHÁCH HÀNG</h2>');
		expect(html).toContain('A &lt;b&gt;');
		expect(html).not.toContain('A <b>');
	});
});
