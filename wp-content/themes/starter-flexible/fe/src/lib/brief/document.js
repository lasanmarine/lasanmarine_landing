// Design Brief — the printed document.
//
// Laid out per Nghị định 30/2020: quốc hiệu and tiêu ngữ on the right, the
// issuing body and document number on the left, the name of the document, the
// body in Roman-numbered parts, then nơi nhận and the two signatures.

const esc = (value) =>
	String(value ?? '').replace(/[&<>"]/g, (ch) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' })[ch]);

const ROMAN = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

const longDate = (date) =>
	`ngày ${String(date.getDate()).padStart(2, '0')} tháng ${date.getMonth() + 1} năm ${date.getFullYear()}`;

const STYLE = `
@page { size: A4; margin: 20mm 15mm 20mm 30mm; }
* { box-sizing: border-box; }
body { margin: 0; font-family: "Times New Roman", Times, serif; font-size: 13pt; line-height: 1.45; color: #000; }
p { margin: 0 0 6pt; }
.head { width: 100%; border-collapse: collapse; margin-bottom: 12pt; }
.head td { vertical-align: top; padding: 0; }
.head .left { width: 42%; text-align: center; }
.head .right { width: 58%; text-align: center; }
.org, .nation { font-weight: bold; text-transform: uppercase; font-size: 12pt; }
.motto { font-weight: bold; font-size: 13pt; }
.rule { width: 60%; margin: 3pt auto 6pt; border-bottom: 1px solid #000; }
.rule--wide { width: 78%; }
.no { font-size: 12pt; }
.place { font-style: italic; font-size: 13pt; }
.contact { font-size: 10pt; font-style: italic; }
h1 { margin: 16pt 0 4pt; font-size: 14pt; text-align: center; text-transform: uppercase; }
.subject { text-align: center; font-style: italic; margin-bottom: 14pt; }
.grounds { font-style: italic; margin-bottom: 10pt; }
.part { margin-bottom: 10pt; page-break-inside: auto; }
h2 { font-size: 13pt; margin: 12pt 0 4pt; text-transform: uppercase; }
h3 { font-size: 13pt; margin: 8pt 0 3pt; font-style: italic; }
h4 { font-size: 13pt; margin: 6pt 0 2pt; font-weight: normal; font-style: italic; }
table.spec { width: 100%; border-collapse: collapse; margin: 0 0 4pt; }
table.spec td { border: 1px solid #000; padding: 3pt 6pt; vertical-align: top; }
table.spec td.k { width: 45%; }
table.spec tr { page-break-inside: avoid; }
.sign { width: 100%; border-collapse: collapse; margin-top: 18pt; page-break-inside: avoid; }
.sign td { width: 50%; vertical-align: top; text-align: center; padding: 0; }
.sign .role { font-weight: bold; text-transform: uppercase; }
.sign .hint { font-style: italic; font-size: 12pt; }
.sign .space { height: 60pt; }
.recipients { margin-top: 14pt; font-size: 11pt; }
.recipients .title { font-weight: bold; font-style: italic; }
`;

/**
 * @param {object} args
 * @param {Array} args.sections   outline() result
 * @param {object} args.letterhead org, place, symbol, address, phone, email
 * @param {(name: string) => string} args.named  value of a global field
 * @param {Date} [args.today]
 */
export function documentHtml({ sections, letterhead = {}, named, today = new Date() }) {
	const org = letterhead.org || 'CÔNG TY TNHH LASAN MARINE';
	const place = letterhead.place || '';
	const symbol = letterhead.symbol || 'NVT';
	const number = named('request_no') || '......';
	const code = named('design_code');
	const customer = named('customer_name');
	const vessel = named('vessel_no');
	const requestDate = named('request_date');

	const contact = [letterhead.address, letterhead.phone && `ĐT: ${letterhead.phone}`, letterhead.email]
		.filter(Boolean)
		.join(' · ');

	const grounds = [
		`Căn cứ Đơn đề nghị thiết kế số ${esc(number)}${requestDate ? ` ngày ${esc(requestDate)}` : ''}${customer ? ` của ${esc(customer)}` : ''};`,
		'Căn cứ Quy chuẩn kỹ thuật quốc gia về phân cấp và đóng tàu cá hiện hành;',
		'Căn cứ số liệu khảo sát thực tế và thoả thuận giữa hai bên,',
	].join('<br />');

	const body = sections
		.map((section, i) => {
			const blocks = section.blocks
				.map((block) => {
					const groups = block.groups
						.map((group) => {
							const rows = group.rows
								.map(
									(row) =>
										`<tr><td class="k">${esc(row.label)}</td><td class="v">${esc(row.value)}${row.unit ? ` ${esc(row.unit)}` : ''}</td></tr>`,
								)
								.join('');
							return `${group.title ? `<h4>${esc(group.title)}</h4>` : ''}<table class="spec">${rows}</table>`;
						})
						.join('');
					return `${block.title ? `<h3>${esc(block.title)}</h3>` : ''}${groups}`;
				})
				.join('');
			return `<section class="part"><h2>${ROMAN[i] ?? i + 1}. ${esc(section.title.toUpperCase())}</h2>${blocks}</section>`;
		})
		.join('');

	const subject = [code && `Ký hiệu thiết kế: ${esc(code)}`, vessel && `Số đăng ký: ${esc(vessel)}`].filter(Boolean).join(' — ');

	return `<!doctype html>
<html lang="vi"><head><meta charset="utf-8" />
<title>Nhiệm vụ thư thiết kế${code ? ` ${esc(code)}` : ''}</title>
<style>${STYLE}</style></head>
<body>
<table class="head"><tr>
	<td class="left">
		<p class="org">${esc(org)}</p>
		<div class="rule"></div>
		<p class="no">Số: ${esc(number)}/${esc(symbol)}</p>
	</td>
	<td class="right">
		<p class="nation">Cộng hòa xã hội chủ nghĩa Việt Nam</p>
		<p class="motto">Độc lập - Tự do - Hạnh phúc</p>
		<div class="rule rule--wide"></div>
		<p class="place">${place ? `${esc(place)}, ` : ''}${longDate(today)}</p>
	</td>
</tr></table>

<h1>Nhiệm vụ thư thiết kế</h1>
<p class="subject">${subject || '&nbsp;'}</p>

<p class="grounds">${grounds}</p>
<p>Hai bên thống nhất nội dung nhiệm vụ thư thiết kế như sau:</p>

${body}

<table class="sign"><tr>
	<td>
		<p class="role">Chủ tàu / Khách hàng</p>
		<p class="hint">(Ký, ghi rõ họ tên)</p>
		<div class="space"></div>
		<p>${esc(customer)}</p>
	</td>
	<td>
		<p class="role">Đơn vị thiết kế</p>
		<p class="hint">(Ký, ghi rõ họ tên, đóng dấu)</p>
		<div class="space"></div>
		<p>${esc(named('handler'))}</p>
	</td>
</tr></table>

<div class="recipients">
	<p class="title">Nơi nhận:</p>
	<p>- Chủ tàu (để thực hiện);<br />- Trung tâm đăng kiểm (để biết);<br />- Lưu: VT, hồ sơ thiết kế.</p>
	${contact ? `<p class="contact">${esc(contact)}</p>` : ''}
</div>
</body></html>`;
}
