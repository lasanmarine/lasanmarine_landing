# Kế hoạch chuyển frontend sang Svelte 5

Ngày lập: 2026-11-07. Phạm vi: theme `starter-flexible`.

> **Trạng thái 2026-11-07: đã thực hiện xong pha 0–5 trên nhánh `feat/svelte`.** Khác kế hoạch: behaviour là module JS thuần (không `$effect.root`), dùng `subscribe()` của store; code dùng chung tách vào `dist/core.js`; công cụ Vitest chưa có `@testing-library/svelte`, test phủ phần lõi thuần. Cách tổ chức hiện hành xem `fe/README.md`.

## 0. Tóm tắt

| | |
| --- | --- |
| **Giữ nguyên** | ACF field groups, `block.json`, pipeline PHP (`Abstract_Block` → `render.php`), toàn bộ `style.scss`, markup SSR của những phần cần SEO/LCP, Contact Form 7, static export |
| **Viết lại** | Toàn bộ JS: 12 `blocks/*/assets/script.js` + 11 module `fe/src/site/*.js` + cấu hình Vite + cách PHP enqueue |
| **Kiến trúc đích** | Hai tầng trên một runtime chung: **Island** (component Svelte sở hữu DOM) và **Behaviour** (hàm gắn lên DOM do PHP render), dùng chung stores (runes) và lib thuần |
| **Stack** | Svelte 5 (runes) · Vite 7 · `@sveltejs/vite-plugin-svelte` 6 · Vitest 3 · bỏ `alpinejs`, bỏ `aos` |
| **Lộ trình** | 6 pha, ≈ 13 ngày công, mỗi pha merge được vào `main` (deploy tự động) |

## 1. Hiện trạng

### 1.1 Code JS

| Nhóm | File | Dòng | Ghi chú |
| --- | --- | --- | --- |
| Site | `fe/src/site/stack.js` | 222 | Sheet stacking + soft snap, rAF riêng |
| Site | `fe/src/site/header.js` | 194 | Sticky bar, mega panel, overlay nav, focus trap |
| Site | `fe/src/site/hero-cards.js` | 93 | Tự tạo DOM thanh "Trong trang" |
| Site | `reveal.js` `waves.js` `toc.js` `post-progress.js` `analytics.js` `footer.js` `motion.js` `aos.js` | 311 | |
| Block | `design-brief` | 659 | State nằm trong DOM, clone `<template>`, in iframe, bridge CF7 |
| Block | `engine-lookup` | 358 | Multi-select tự viết, bảng client-render, phân trang |
| Block | `hero` `shaft-diameter` `power-converter` `accordion` `project-showcase` | 371 | |
| Block | `project-index` `process-timeline` `document-center` `geo-operations` `service-architecture` | 102 | |

### 1.2 Vấn đề thiết kế cần sửa khi viết lại

1. **7 scroll listener độc lập** (stack, waves, process-timeline, post-progress, hero-cards, header, analytics), mỗi cái tự đo `innerHeight`, `--hdr-h`.
2. **Logic lặp**: công thức `d = k3·∛(P/n)` ở shaft-diameter và design-brief; copy-to-clipboard ở footer, power-converter, shaft-diameter, engine-lookup, design-brief; hover-select ở geo-operations và service-architecture giống hệt nhau.
3. **State trong DOM**: design-brief gom dữ liệu bằng `querySelectorAll('[data-db-field]')`, đánh lại tên field khi thêm/xoá máy, restore bằng cách dispatch `input` event.
4. **Reduced motion** xử lý theo 3 kiểu khác nhau (`motionAllowed()`, `matchMedia` trực tiếp, event `lm:motion`).
5. **Dependency**: `alpinejs` không dùng; `aos` chỉ phục vụ `data-aos` trong 3 block tool, trùng vai với `[data-reveal]`.
6. **PHP quét thư mục `dist`** để đoán file nào thuộc block nào thay vì đọc `manifest.json` (Vite đã bật `manifest: true`).

## 2. Quyết định kiến trúc

### 2.1 Vì sao không chuyển toàn bộ markup sang Svelte

WordPress chạy PHP, không có Node lúc runtime nên không SSR được Svelte. Nếu để Svelte render hero, project cards, danh sách tài liệu thì `<h1>`, ảnh LCP và link nội bộ chỉ xuất hiện sau khi JS chạy: mất SEO, LCP xấu đi, layout shift. Vì vậy:

- **Markup có giá trị SEO/LCP ở lại `render.php`**. Svelte chỉ gắn hành vi lên đó (tầng Behaviour).
- **UI tương tác thuần công cụ** (bảng tra, bộ chuyển đổi, form nhiệm vụ thư) chuyển hẳn thành component Svelte (tầng Island). Những phần này hiện đã client-render hoặc không có giá trị index.

### 2.2 Tầng Island

```
blocks/engine-lookup/
  appearances/default/render.php   ← shell: <section>, heading, <div data-island="engine-lookup">, props JSON
  assets/island.svelte             ← component, dùng lại class CSS cũ (pc__*, el__*)
  assets/style.scss                ← không đổi
  inc/helpers.php                  ← build mảng props (đã có sẵn rows_json, labels, units)
```

- PHP in `<div data-island="{slug}"><script type="application/json" data-props>{…}</script></div>`. Runtime đọc props, `mount(Component, { target, props })` (API Svelte 5).
- Labels, đơn vị, số liệu, chuỗi i18n đều đến từ PHP qua props. Component không chứa chuỗi tiếng Việt/Anh cứng.
- Component **không dùng `<style>` scoped** cho class của block; style ở lại `style.scss` để CSS không đổi và không sinh chunk CSS phụ.
- Trước khi mount, PHP in sẵn khung tĩnh (heading, mô tả) bên ngoài island để tránh nhảy layout; island nên có `min-height` trong SCSS.

### 2.3 Tầng Behaviour

Một behaviour là hàm `(node, props) => cleanup`, đúng chữ ký attachment của Svelte 5. Nhờ vậy cùng một hàm:

- gọi trực tiếp lên DOM PHP từ registry (`behaviours.js`),
- hoặc dùng trong component bằng `{@attach hoverSelect}`.

Bên trong, behaviour dùng được rune stores vì bọc trong `$effect.root()`:

```js
// blocks/hero/assets/behaviour.js
import { motion } from '$lib/stores/motion.svelte.js';
export const selector = '[data-hero]';
export default function heroSlider(node) {
  return $effect.root(() => {
    let index = $state(0);
    $effect(() => { /* áp index lên [data-hero-panel], dots … */ });
    $effect(() => { if (!motion.allowed) stop(); });
    return () => { /* gỡ listener */ };
  });
}
```

Markup PHP của các block tầng này **không cần sửa**: registry bám vào hook `data-*` đã có (`[data-hero]`, `[data-accordion]`, `[data-showcase]`…).

### 2.4 Runtime (`fe/src/runtime/`)

| File | Nhiệm vụ |
| --- | --- |
| `boot.js` | Entry: gọi `mountIslands(document)` và `attachBehaviours(document)` sau DOM ready; trong ACF editor lắng `acf.addAction('render_block_preview')` để mount lại preview |
| `islands.js` | `import.meta.glob('../../blocks/*/assets/island.svelte')` + `../islands/*.svelte` (site). Lazy: chỉ `import()` component khi trang có `[data-island=…]`. Giữ `WeakSet` để không mount hai lần, trả về `unmount()` |
| `behaviours.js` | Glob `blocks/*/assets/behaviour.js` + `fe/src/behaviours/*.js`; mỗi module export `selector` và default function. Gắn lên mọi node khớp, lưu cleanup trên node |

### 2.5 Stores dùng chung (`fe/src/lib/stores/*.svelte.js`)

| Store | Thay thế | Nội dung |
| --- | --- | --- |
| `motion.svelte.js` | `motion.js`, event `lm:motion`, các `matchMedia` rải rác | `allowed` (`$derived` từ `prefers-reduced-motion` + class `reduce-motion`), `toggle()`, ghi `localStorage` |
| `viewport.svelte.js` | 7 scroll listener | `scrollY`, `innerHeight`, `innerWidth`, `hdrH` (đọc `--hdr-h`), `mq.desktop`; một `scroll` passive + một `resize` + `ResizeObserver` header, cập nhật qua rAF |
| `raf.svelte.js` | vòng lặp riêng của stack/waves | `schedule(fn)`: gom mọi hiệu ứng theo frame vào một `requestAnimationFrame` |

### 2.6 Lib thuần, không phụ thuộc DOM (`fe/src/lib/*.js`)

`clipboard.js` (copy + fallback textarea), `format.js` (số theo locale, số "thô" để dán vào bảng tính), `units.js` (hệ số kW/HP/PS, rpm), `shaft.js` (`propRpm`, `shaftDiameter` dùng chung cho 2 block), `storage.js` (localStorage an toàn), `i18n.js` (locale từ `<html lang>`), `analytics.js` (`track(name, params)` qua gtag/dataLayer), `slug.js`.

Đây là phần có unit test.

### 2.7 Component dùng chung (`fe/src/components/`)

`CopyButton.svelte` (icon + trạng thái copied), `MultiSelect.svelte` (tách từ engine-lookup, label tự rút gọn theo bề rộng), `NumberField.svelte`, `UnitSelect.svelte`, `Pager.svelte`.

### 2.8 Build & PHP

**Vite** (`fe/vite.config.js`):

- Entry duy nhất `src/main.js` (import SCSS + `runtime/boot.js`). Bỏ `getBlockAssetsEntries()` cho JS; **giữ** phần sinh `styles/blocks.scss` và entry CSS per block như hiện nay.
- Chunk của island/behaviour đặt tên theo `facadeModuleId` để giữ layout `dist/blocks/{slug}/assets/island.js` và `dist/islands/{name}.js`; PHP vẫn suy ra slug từ đường dẫn.
- `svelte({ compilerOptions: { runes: true } })`; alias `$lib` → `fe/src/lib`.
- Dev server: không cần glob riêng nữa, `boot.js` đã lazy-load mọi thứ.

**PHP** (`inc/vite.php`):

- Đọc `dist/.vite/manifest.json` thay vì `find_files_recursive` cho JS: enqueue `app.js` (+ `app.css`, vendor import), và với mỗi slug trong `starter_flexible_page_block_slugs()` in `<link rel="modulepreload">` cho chunk `blocks/{slug}/assets/island` hoặc `behaviour` nếu có trong manifest. Tránh một round-trip khi lazy import.
- Phần inline CSS của block dùng: giữ nguyên.
- Editor: `inc/assets.php` vẫn enqueue `app.js`/`vendor.js`; `boot.js` tự nhận biết `window.acf`.

**Tooling**: `tools/dump-blocks-md.php` dòng 207 đổi điều kiện "Có JavaScript riêng" sang kiểm tra `island.svelte` hoặc `behaviour.js`. `tools/export-static.mjs` cần gom thêm toàn bộ `dist/blocks/**/*.js` và `dist/islands/*.js` vì crawler không thấy dynamic import (mitigate một phần nhờ modulepreload).

### 2.9 Test

- **Vitest** + `@testing-library/svelte` trong `fe/`: lib thuần (shaft, units, format, brief outline/text/document HTML), MultiSelect, EngineLookup filter/sort/paging, PowerConverter, DesignBrief state & draft.
- Checklist thủ công mỗi block (mục 7). Lighthouse trước/sau trên trang chủ, trang tool, một bài viết.

## 3. Bản đồ chuyển đổi

### 3.1 Site-wide

| Hiện tại | Đích | Loại | Ghi chú |
| --- | --- | --- | --- |
| `site/motion.js` | `lib/stores/motion.svelte.js` + `behaviours/motion-toggle.js` | store + behaviour | Nút toggle ở footer bám `[data-motion-toggle]` |
| `site/header.js` | `behaviours/header-bar.js`, `header-panels.js`, `header-overlay.js` | 3 behaviour | Tách sticky / mega panel / overlay + focus trap; dùng `viewport` store |
| `site/footer.js` | `behaviours/copy.js` | behaviour | `[data-copy]`; dùng `lib/clipboard.js` |
| `site/reveal.js` + `site/aos.js` | `behaviours/reveal.js` | behaviour | Gộp: `data-aos="fade-left"` → `data-reveal="left"`; bỏ thư viện AOS và CSS của nó; sửa 3 file render.php đang dùng `data-aos` |
| `site/waves.js` | `behaviours/waves.js` | behaviour | Dùng `raf` + `viewport` |
| `site/post-progress.js` | `behaviours/reading-bar.js` | behaviour | |
| `site/toc.js` | `behaviours/toc.js` | behaviour | |
| `site/stack.js` | `behaviours/stack.js` | behaviour | Lớn nhất; giữ nguyên thuật toán, chỉ đổi nguồn scroll/raf sang store. Chuyển sau cùng trong pha 1 |
| `site/hero-cards.js` | `islands/OnPageNav.svelte` + `behaviours/onpage-nav.js` | island | Behaviour quét DOM sau `.lasanmarine-page-hero` lấy items rồi `mount(OnPageNav)`; đây là chỗ duy nhất site-wide tự tạo DOM nên hợp island |
| `site/analytics.js` | `lib/analytics.js` + `behaviours/analytics.js` | lib + behaviour | Islands gọi `track()` trực tiếp thay vì nhờ click delegation |

### 3.2 Blocks

| Block | Loại | File mới | Markup PHP | Ghi chú |
| --- | --- | --- | --- | --- |
| accordion | behaviour | `assets/behaviour.js` | giữ | Dùng Web Animations API cho height thay vì transition inline |
| hero | behaviour | `assets/behaviour.js` | giữ | Slider, autoplay, holds (focus/hidden), phím mũi tên |
| project-showcase | behaviour | `assets/behaviour.js` | giữ | Slider + swipe |
| project-index | behaviour | `assets/behaviour.js` | giữ | Lọc theo term; cards SSR |
| document-center | behaviour | `assets/behaviour.js` | giữ | Lọc nhóm; link tài liệu SSR |
| geo-operations | behaviour | `assets/behaviour.js` | giữ | Cả hai dùng chung `behaviours/hover-select.js` (`rows`, `targets`, attr `data-active`) |
| service-architecture | behaviour | `assets/behaviour.js` | giữ | |
| process-timeline | behaviour | `assets/behaviour.js` | giữ | Dùng `viewport` store |
| power-converter | **island** | `assets/island.svelte` | shell + props | Props: `units`, `labels`, `precision`; kết quả `$derived` |
| shaft-diameter | **island** | `assets/island.svelte` | shell + props | Props: units, materials (k3), labels; dùng `lib/shaft.js` |
| engine-lookup | **island** | `assets/island.svelte` + `components/MultiSelect.svelte` | shell + props | Props: `rows`, `perPage`, `modelSample`, `columns`, `ranges`, `labels`. Filter/sort/page là `$derived` từ state |
| design-brief | **island** | `assets/island.svelte` + `lib/brief/*.js` | shell + props + CF7 ẩn | Xem 3.3 |
| 24 block còn lại | — | — | giữ | Không có JS, không đụng |

### 3.3 Design Brief (riêng vì lớn nhất)

- **Định nghĩa form** chuyển từ PHP emit HTML (`starter_flexible_design_brief_row()`) sang PHP build JSON: `sections[] → rows[] → fields[] { name, label, unit, type, presets[] }`, cộng `engineTemplate`, `catalogue`, `letterhead`. Chuỗi i18n và Site Settings vẫn ở PHP.
- **State**: `brief = $state({ fields: {}, codes: {}, engines: [{ make, model, kw, rpm, ratio, k3, material }] })`. Không còn `renumber()`, không clone `<template>`: `{#each brief.engines as engine, i}` tự đánh số.
- **Derived**: `designCode` (province + số giữa + loại thiết kế), `propRpm`/`dmin` mỗi máy (từ `lib/shaft.js`), `outline` (chỉ field có giá trị), `asText`, `documentHtml`.
- **Draft**: `$effect` debounce 300 ms ghi `localStorage` (`lib/storage.js`); restore là gán state một lần, không dispatch event.
- **In**: `lib/brief/document.js` (hàm thuần trả HTML, có test) + `lib/print.js` (iframe off-screen).
- **Gửi**: form CF7 ẩn vẫn do PHP render trong shell; island điền `brief-*` và click `.wpcf7-submit` như hiện nay.
- **Fallback**: nếu island chưa mount, PHP in thông báo "Cần bật JavaScript" trong `<noscript>`.

## 4. Lộ trình theo pha

Làm trên nhánh `feat/svelte`, mỗi pha một PR vào `main`. Trong suốt pha 0 → 4 hai hệ cùng tồn tại: `script.js` cũ vẫn build/enqueue như hiện nay cho block chưa chuyển; block nào chuyển xong thì xoá `script.js` của nó.

### Pha 0. Nền tảng (≈ 1.5 ngày)

1. Nâng Vite 7, thêm `svelte@5`, `@sveltejs/vite-plugin-svelte@6`, `vitest@3`, `@testing-library/svelte`, `jsdom`. Gỡ `alpinejs`.
2. Tạo `fe/src/runtime/`, `fe/src/lib/`, `fe/src/behaviours/`, `fe/src/islands/`, `fe/src/components/`; alias `$lib`.
3. Sửa `vite.config.js`: entry `main.js`, chunk naming theo slug, giữ sinh `blocks.scss`, vẫn tạo entry `script.js` cho block cũ (xoá dần).
4. `inc/vite.php`: enqueue theo `manifest.json` + modulepreload; giữ inline CSS.
5. Một island thử (`islands/Ping.svelte`) và một behaviour thử để xác nhận: prod build, dev HMR, ACF editor preview, static export.
6. Cập nhật `tools/dump-blocks-md.php`, `fe/README.md`.

**DoD**: trang chạy y hệt trước, `npm run build` xanh, Lighthouse không giảm, CI deploy ok.

### Pha 1. Stores + site-wide (≈ 3 ngày)

1. `motion`, `viewport`, `raf` stores; `lib/clipboard`, `format`, `i18n`, `analytics`, `storage`.
2. Chuyển theo thứ tự: motion-toggle → copy → reading-bar → toc → waves → reveal (gộp AOS, sửa 3 render.php, gỡ `aos`) → header (3 behaviour) → analytics → OnPageNav island → stack.
3. Xoá `fe/src/site/`, `blocks-entry.js`.

**DoD**: chỉ còn 1 scroll listener trong app; checklist a11y header (Esc, Tab trap, aria-expanded) đạt; reduced-motion tắt mọi hiệu ứng.

### Pha 2. Block behaviours (≈ 2 ngày)

accordion, hero, project-showcase, project-index, document-center, hover-select (geo-operations + service-architecture), process-timeline. Xoá 8 `script.js`.

**DoD**: markup PHP không đổi (diff render.php = 0), checklist mục 7 từng block.

### Pha 3. Tool islands (≈ 3.5 ngày)

1. `lib/units.js`, `lib/shaft.js` + test.
2. `CopyButton`, `NumberField`, `UnitSelect`, `Pager`, `MultiSelect` + test.
3. power-converter → shaft-diameter → engine-lookup: `helpers.php` build props, `render.php` thành shell, `island.svelte`.
4. Xoá 3 `script.js`.

**DoD**: kết quả số trùng khớp với bản cũ trên bộ giá trị mẫu; copy ra số thô đúng locale máy; bàn phím/aria như cũ.

### Pha 4. Design Brief (≈ 3 ngày)

Theo 3.3. Test: outline/asText/documentHtml với fixture; draft round-trip; thêm/xoá máy; gửi CF7 trên staging.

### Pha 5. Dọn dẹp & đo (≈ 1 ngày)

Gỡ nhánh code cũ trong `vite.config.js` và `inc/vite.php`, regenerate `BLOCKS.md`, cập nhật README, so sánh bundle size và Lighthouse, ghi memory.

## 5. Rủi ro và cách xử lý

| Rủi ro | Xử lý |
| --- | --- |
| Island render chậm → nhảy layout | PHP in heading/intro ngoài island; `min-height` cho island trong SCSS; modulepreload chunk block đang dùng |
| Static export thiếu chunk lazy | Export gom toàn bộ `dist/blocks/**/*.js`, `dist/islands/*.js`; kiểm tra bằng `tools/check-static-export.py` |
| ACF editor preview không có JS sau khi re-render | `boot.js` hook `acf.addAction('render_block_preview')`; chấp nhận preview tĩnh nếu phức tạp |
| `$effect.root` rò rỉ khi DOM bị thay | Runtime lưu cleanup trên node, `MutationObserver` trong editor gọi cleanup khi node rời DOM |
| Svelte 5 cần trình duyệt ES2020+ | Code hiện tại đã dùng `?.`, `.at()`, `inert` nên không giảm độ tương thích |
| Deploy tự động trên `main` | Chỉ merge PR khi pha đạt DoD; backup tự động trong `deploy.yml` đã có |
| Kích thước bundle | Svelte 5 runtime ≈ 10–15 kB gz, bù lại gỡ AOS (JS + CSS) và alpinejs; đo ở pha 5 |

## 6. Ngoài phạm vi

- `apps/mo-phong-on-dinh-tau`, `apps/suc-can-cong-suat`: app React build sẵn, nhúng iframe qua block `app-embed`. Giữ nguyên.
- Nâng Tailwind 4, thay Contact Form 7, đổi markup/CSS của block.

## 7. Checklist nghiệm thu mỗi block

- [ ] Hành vi bằng bản cũ (danh sách tương tác liệt kê trong PR)
- [ ] Bàn phím: Tab, Esc, mũi tên như cũ; `aria-expanded`/`aria-selected`/`aria-current` đúng
- [ ] `prefers-reduced-motion` và nút "Giảm chuyển động" tắt hiệu ứng
- [ ] Không console error; không listener trùng khi mount lại (editor)
- [ ] `style.scss` không đổi (island dùng lại class cũ)
- [ ] Tiếng Việt/Anh đều hiện đúng (Polylang, `/en/`)
- [ ] `script.js` cũ đã xoá, `BLOCKS.md` regenerate
