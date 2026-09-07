# Danh sách khối — LASAN Marine

Sinh tự động từ `blocks/<slug>/block.json` và `blocks/<slug>/<slug>.json`.
Chạy lại `php tools/dump-blocks-md.php` sau khi sửa field.

Mọi khối đều có thêm ba field dùng chung, không lặp lại trong các bảng bên dưới:

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Custom Class | `custom_class` | `text` | Class thêm vào thẻ bọc ngoài của khối |
| Padding Top | `padding_top` | `number` | Tab **Khoảng cách**. Để trống thì dùng khoảng cách mặc định của khối |
| Padding Bottom | `padding_bottom` | `number` | Tab **Khoảng cách** |

Mọi khối cũng đều bật `anchor` — ô **HTML Anchor** của trình soạn thảo.

---

## Mục lục

- [LASAN — Accordion](#accordion) — `acf/accordion`
- [LASAN — Capability Matrix](#capability-matrix) — `acf/capability-matrix`
- [LASAN — Clients](#clients) — `acf/clients`
- [LASAN — Contact Statement](#contact-statement) — `acf/contact-statement`
- [LASAN — CTA Banner](#cta-banner) — `acf/cta-banner`
- [LASAN — Design Brief](#design-brief) — `acf/design-brief`
- [LASAN — Document Center](#document-center) — `acf/document-center`
- [LASAN — Engine Lookup](#engine-lookup) — `acf/engine-lookup`
- [LASAN — Enquiry Form](#enquiry-form) — `acf/enquiry-form`
- [LASAN — Geo Operations](#geo-operations) — `acf/geo-operations`
- [LASAN — Hero](#hero) — `acf/hero`
- [LASAN — Image Story](#image-story) — `acf/image-story`
- [LASAN — Image + Text](#image-text) — `acf/image-text`
- [LASAN — Input / Output](#input-output) — `acf/input-output`
- [LASAN — Insights](#insights) — `acf/insights`
- [LASAN — Job List](#job-list) — `acf/job-list`
- [LASAN — Key Numbers](#key-numbers) — `acf/key-numbers`
- [LASAN — Manifesto](#manifesto) — `acf/manifesto`
- [LASAN — Page Hero](#page-hero) — `acf/page-hero`
- [LASAN — Power Converter](#power-converter) — `acf/power-converter`
- [LASAN — Process Timeline](#process-timeline) — `acf/process-timeline`
- [LASAN — Project Grid](#project-grid) — `acf/project-grid`
- [LASAN — Project Index](#project-index) — `acf/project-index`
- [LASAN — Project Showcase](#project-showcase) — `acf/project-showcase`
- [LASAN — Proof Strip](#proof-strip) — `acf/proof-strip`
- [LASAN — Quote](#quote) — `acf/quote`
- [LASAN — Rich Text](#rich-text) — `acf/rich-text`
- [LASAN — Section Intro](#section-intro) — `acf/section-intro`
- [LASAN — Service Architecture](#service-architecture) — `acf/service-architecture`
- [LASAN — Service Spotlight](#service-spotlight) — `acf/service-spotlight`
- [LASAN — Shaft Diameter](#shaft-diameter) — `acf/shaft-diameter`
- [LASAN — Spec List](#spec-list) — `acf/spec-list`
- [LASAN — Team](#team) — `acf/team`
- [LASAN — Tool Shell](#tool-shell) — `acf/tool-shell`
- [LASAN — Use Case](#use-case) — `acf/use-case`
- [LASAN — Value Grid](#value-grid) — `acf/value-grid`

---

<a id="accordion"></a>
## LASAN — Accordion

`acf/accordion` · `blocks/accordion/` · field group `group_accordion`

Câu hỏi thường gặp hoặc thông tin mở rộng, mỗi mục một dòng kẻ.

> Có JavaScript riêng

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` |  |
| Heading | `heading` | `text` |  |
| Intro | `intro` | `textarea` |  |
| Items | `items` | `repeater` | Repeater |
| ↳ Title | `items[].title` | `text` |  |
| ↳ Content | `items[].content` | `wysiwyg` |  |
| Open First Item | `open_first` | `true_false` | Mặc định `1` |

---

<a id="capability-matrix"></a>
## LASAN — Capability Matrix

`acf/capability-matrix` · `blocks/capability-matrix/` · field group `group_capability_matrix`

Ma trận năng lực, vẽ bằng lưới kẻ mảnh.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` | Mặc định `CAPABILITY MATRIX` |
| Heading | `heading` | `text` |  |
| Capabilities | `items` | `repeater` | Repeater |
| ↳ Index | `items[].index` | `text` | Cũng dùng làm id neo của ô. |
| ↳ Icon | `items[].icon` | `select` | Chọn: `ship`, `waves`, `ruler`, `wrench`, `compass`, `scan`, `gauge`, `award`, `calculator`, `link` · Mặc định `ship` |
| ↳ Name | `items[].name` | `text` |  |
| ↳ Description | `items[].desc` | `textarea` |  |
| ↳ Link | `items[].link` | `link` | Trả về mảng `url` / `title` / `target` |
| ↳ Sub-items | `items[].children` | `repeater` | Repeater |

---

<a id="clients"></a>
## LASAN — Clients

`acf/clients` · `blocks/clients/` · field group `group_clients`

Bảng khách hàng & đối tác — tên trên lưới kẻ, không mượn logo.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` | Mặc định `CLIENTS & PARTNERS` |
| Logo Height (px) | `logo_size` | `number` | Mặc định `54` · Chiều cao tối đa của logo trong mỗi ô. |
| Clients | `items` | `repeater` | Repeater |
| ↳ Name | `items[].name` | `text` |  |
| ↳ Logo | `items[].logo` | `image` | Trả về `id` · Để trống sẽ hiển thị icon + tên. |

---

<a id="contact-statement"></a>
## LASAN — Contact Statement

`acf/contact-statement` · `blocks/contact-statement/` · field group `group_contact_statement`

Lời kết trên nền navy với các lớp sóng chồng nhau.

> Căn `full` — băng tràn hết khổ

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` |  |
| Heading | `heading` | `wysiwyg` |  |
| Description | `description` | `textarea` | Đoạn mô tả ngắn nằm dưới heading. |
| Phone | `phone` | `text` |  |
| Email | `email` | `email` |  |
| CTA | `cta` | `link` | Trả về mảng `url` / `title` / `target` |
| Mascot | `mascot` | `image` | Trả về `id` · Để trống thì dùng linh vật mặc định của theme. |

---

<a id="cta-banner"></a>
## LASAN — CTA Banner

`acf/cta-banner` · `blocks/cta-banner/` · field group `group_cta_banner`

Dải kêu gọi hành động giữa hoặc cuối trang, không kèm điện thoại / email.

> Căn `full` — băng tràn hết khổ

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` |  |
| Heading | `heading` | `text` |  |
| Content | `content` | `textarea` |  |
| Primary CTA | `primary_cta` | `link` | Trả về mảng `url` / `title` / `target` |
| Secondary CTA | `secondary_cta` | `link` | Trả về mảng `url` / `title` / `target` |
| Theme | `theme` | `select` | Chọn: `navy`, `pale`, `outline` · Mặc định `navy` |

---

<a id="design-brief"></a>
## LASAN — Design Brief

`acf/design-brief` · `blocks/design-brief/` · field group `group_design_brief`

Form xây dựng nhiệm vụ thư thiết kế: thông tin chung, kích thước, kết cấu, khai thác và máy.

> Có JavaScript riêng

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Nhãn block | `label` | `text` | Mặc định `NHIỆM VỤ THƯ` |
| Tiêu đề | `heading` | `text` | Mặc định `Xây dựng nhiệm vụ thư thiết kế` |
| Đoạn dẫn | `intro` | `textarea` |  |
| Form Contact Form 7 | `cf7_form` | `post_object` | Nơi nhận nhiệm vụ thư. Form cần có các trường brief-code, brief-customer, brief-vessel, brief-email và brief-body. |

---

<a id="document-center"></a>
## LASAN — Document Center

`acf/document-center` · `blocks/document-center/` · field group `group_document_center`

Danh sách tài liệu, lọc phía client.

> Có JavaScript riêng

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` |  |
| "All" Tab Label | `all_label` | `text` | Mặc định `TẤT CẢ` · Tab đầu tiên hiển thị toàn bộ tài liệu. |
| Groups | `groups` | `repeater` | Repeater · Mỗi nhóm là một tab. Tài liệu nằm bên trong nhóm của nó. |
| ↳ Group Name | `groups[].name` | `text` |  |
| ↳ Documents | `groups[].items` | `repeater` | Repeater |
| Empty Text | `empty_text` | `text` | Mặc định `Không có kết quả.` |

---

<a id="engine-lookup"></a>
## LASAN — Engine Lookup

`acf/engine-lookup` · `blocks/engine-lookup/` · field group `group_engine_lookup`

Bảng tra động cơ: lọc, sắp xếp và phân trang phía client.

> Có JavaScript riêng

_Không có field riêng._

---

<a id="enquiry-form"></a>
## LASAN — Enquiry Form

`acf/enquiry-form` · `blocks/enquiry-form/` · field group `group_enquiry_form`

Form liên hệ / ứng tuyển. Kiểm tra và xác nhận ngay trong trang.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Heading | `heading` | `text` |  |
| Note | `note` | `textarea` |  |
| Contact Form 7 | `cf7_form` | `post_object` | Chọn form đã tạo trong Contact → Contact Forms. |

---

<a id="geo-operations"></a>
## LASAN — Geo Operations

`acf/geo-operations` · `blocks/geo-operations/` · field group `group_geo_operations`

Bản đồ địa bàn hoạt động trên nền navy.

> Căn `full` — băng tràn hết khổ · Có JavaScript riêng

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` |  |
| Heading | `heading` | `text` |  |
| Note | `note` | `textarea` |  |
| Locations | `provinces` | `repeater` | Repeater |
| ↳ Name | `provinces[].name` | `text` |  |
| ↳ X | `provinces[].x` | `number` | Toạ độ trong viewBox 1000 × 1017. |
| ↳ Y | `provinces[].y` | `number` |  |

---

<a id="hero"></a>
## LASAN — Hero

`acf/hero` · `blocks/hero/` · field group `group_hero`

Hero điện ảnh toàn màn: nền navy, nội dung neo đáy, đóng bằng sóng.

> Căn `full` — băng tràn hết khổ

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Background Photo | `image` | `image` | Trả về `id` |
| Headline | `headline` | `text` |  |
| Headline Accent | `headline_accent` | `text` | Phần tô màu marine-bright giữa headline. |
| Headline Tail | `headline_tail` | `text` |  |
| Lead | `lead` | `textarea` |  |
| Primary Button | `primary` | `link` | Trả về mảng `url` / `title` / `target` |
| Secondary Button | `secondary` | `link` | Trả về mảng `url` / `title` / `target` |
| Heading Level | `heading_level` | `select` | Chọn: `h1`, `h2` · Mặc định `h1` |

---

<a id="image-story"></a>
## LASAN — Image Story

`acf/image-story` · `blocks/image-story/` · field group `group_image_story`

Thư viện ảnh hiện trường, kèm lightbox.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` | Mặc định `IMAGE STORY` |
| Images | `items` | `repeater` | Repeater |
| ↳ Image | `items[].image` | `image` | Trả về `id` |
| ↳ Placeholder Text | `items[].placeholder` | `text` | Hiện thay cho ảnh khi chưa chọn ảnh. |
| ↳ Caption | `items[].caption` | `text` |  |
| Note | `note` | `textarea` |  |

---

<a id="image-text"></a>
## LASAN — Image + Text

`acf/image-text` · `blocks/image-text/` · field group `group_image_text`

Một cột chữ đứng cạnh một khung ảnh, đảo được trái/phải.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` |  |
| Heading | `heading` | `text` |  |
| Content | `content` | `wysiwyg` |  |
| Image | `image` | `image` | Trả về `id` |
| Placeholder Text | `placeholder` | `text` | Hiện thay cho ảnh khi chưa chọn ảnh. |
| Caption | `caption` | `text` | Tuỳ chọn — chú thích nằm trên góc ảnh. |
| Image Position | `image_position` | `select` | Chọn: `right`, `left` · Mặc định `right` |
| Split | `split` | `select` | Chọn: `even`, `text`, `media` · Mặc định `even` |
| Image Ratio | `ratio` | `select` | Chọn: `ratio-4-3`, `ratio-3-2`, `ratio-16-9`, `ratio-1-1`, `ratio-4-5` · Mặc định `ratio-4-3` |
| CTA | `cta` | `link` | Trả về mảng `url` / `title` / `target` |

---

<a id="input-output"></a>
## LASAN — Input / Output

`acf/input-output` · `blocks/input-output/` · field group `group_input_output`

Luồng ba cột: đầu vào cần có, phần xử lý, đầu ra bàn giao.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` |  |
| Heading | `heading` | `text` |  |
| Intro | `intro` | `textarea` |  |
| Input — Column Title | `input_title` | `text` | Mặc định `Đầu vào` |
| Input — Items | `input` | `repeater` | Repeater |
| ↳ Text | `input[].text` | `text` |  |
| Process — Column Title | `process_title` | `text` | Mặc định `Xử lý` |
| Process — Items | `process` | `repeater` | Repeater |
| ↳ Text | `process[].text` | `text` |  |
| Output — Column Title | `output_title` | `text` | Mặc định `Đầu ra` |
| Output — Items | `output` | `repeater` | Repeater |
| ↳ Text | `output[].text` | `text` |  |

---

<a id="insights"></a>
## LASAN — Insights

`acf/insights` · `blocks/insights/` · field group `group_insights`

Một bài nổi bật phía trên hàng ba bài.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Nhãn block | `label` | `text` | Mặc định `BÀI VIẾT` |
| Tiêu đề | `heading` | `text` | Câu dẫn dưới nhãn. Để trống thì không hiện. |
| Nhãn xem tất cả | `view_all` | `text` | Mặc định `Xem tất cả bài viết` |
| Liên kết xem tất cả | `view_all_link` | `link` | Trả về mảng `url` / `title` / `target` |
| Nhãn đọc tiếp | `read_more` | `text` | Mặc định `Đọc tiếp` |
| Bài nổi bật | `featured_post` | `post_object` |  |
| Chuyên mục | `category` | `taxonomy` |  |
| Số bài thường | `posts_per_page` | `number` | Mặc định `6` |

---

<a id="job-list"></a>
## LASAN — Job List

`acf/job-list` · `blocks/job-list/` · field group `group_job_list`

Danh sách vị trí tuyển dụng; mỗi dòng dẫn tới form ứng tuyển.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` | Mặc định `OPEN POSITIONS` |
| Apply Link | `apply_link` | `link` | Trả về mảng `url` / `title` / `target` · Đích chung cho mọi dòng. |
| Positions | `items` | `repeater` | Repeater |
| ↳ Role | `items[].role` | `text` |  |
| ↳ Location | `items[].location` | `text` |  |
| ↳ Type | `items[].type` | `text` |  |

---

<a id="key-numbers"></a>
## LASAN — Key Numbers

`acf/key-numbers` · `blocks/key-numbers/` · field group `group_key_numbers`

Dải số liệu trên nền nhạt.

> Căn `full` — băng tràn hết khổ

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` | Mặc định `KEY NUMBERS` |
| Stats | `stats` | `repeater` | Repeater |
| ↳ Value | `stats[].value` | `text` |  |
| ↳ Suffix | `stats[].suffix` | `text` | Phần tô màu marine ngay sau con số. |
| ↳ Label | `stats[].label` | `text` |  |
| ↳ Note | `stats[].note` | `textarea` |  |

---

<a id="manifesto"></a>
## LASAN — Manifesto

`acf/manifesto` · `blocks/manifesto/` · field group `group_manifesto`

Tuyên ngôn: tiêu đề bên trái, lập luận bên phải.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` | Nhãn gạch đầu block. Để trống thì ẩn. |
| Heading | `heading` | `text` |  |
| Lead | `lead` | `textarea` |  |
| Body Paragraphs | `body` | `repeater` | Repeater |
| ↳ Paragraph | `body[].text` | `textarea` |  |
| CTA | `cta` | `link` | Trả về mảng `url` / `title` / `target` |

---

<a id="page-hero"></a>
## LASAN — Page Hero

`acf/page-hero` · `blocks/page-hero/` · field group `group_page_hero`

Hero rút gọn mở đầu các trang trong.

> Căn `full` — băng tràn hết khổ

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Headline | `headline` | `text` |  |
| Lead | `lead` | `textarea` |  |
| Background Image | `image` | `image` | Trả về `id` |
| Placeholder Text | `placeholder` | `text` | Hiện thay cho ảnh khi chưa chọn ảnh. |
| Heading Level | `heading_level` | `select` | Chọn: `h1`, `h2` · Mặc định `h1` |
| Hero Height (px) | `height` | `number` | Mặc định `420` · Chiều cao tối thiểu của hero, tính theo px. |

---

<a id="power-converter"></a>
## LASAN — Power Converter

`acf/power-converter` · `blocks/power-converter/` · field group `group_power_converter`

Quy đổi kW / HP / PS. Một ô nhập, các đơn vị còn lại suy ra từ đó.

> Có JavaScript riêng

_Không có field riêng._

---

<a id="process-timeline"></a>
## LASAN — Process Timeline

`acf/process-timeline` · `blocks/process-timeline/` · field group `group_process_timeline`

Thanh quy trình; vạch marine chạy dần khi cuộn qua.

> Có JavaScript riêng

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` | Mặc định `PROCESS TIMELINE` |
| Steps | `steps` | `repeater` | Repeater |
| ↳ Index | `steps[].index` | `text` |  |
| ↳ Title | `steps[].title` | `text` |  |
| ↳ Description | `steps[].desc` | `textarea` |  |

---

<a id="project-grid"></a>
## LASAN — Project Grid

`acf/project-grid` · `blocks/project-grid/` · field group `group_project_grid`

Lưới dự án 12 cột.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` | Mặc định `PROJECT GRID` |
| Projects | `items` | `repeater` | Repeater |
| ↳ Image | `items[].image` | `image` | Trả về `id` |
| ↳ Name | `items[].name` | `text` |  |
| ↳ Tag | `items[].tag` | `text` |  |
| ↳ Meta | `items[].meta` | `text` |  |
| ↳ Column Span | `items[].span` | `number` | Mặc định `4` |
| ↳ Link | `items[].link` | `link` | Trả về mảng `url` / `title` / `target` |

---

<a id="project-index"></a>
## LASAN — Project Index

`acf/project-index` · `blocks/project-index/` · field group `group_project_index`

Danh mục dự án lấy từ post type Dự án, lọc theo vật liệu và công dụng.

> Có JavaScript riêng

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Nhãn block | `label` | `text` | Mặc định `DỰ ÁN` |
| Nhãn "tất cả" | `all_label` | `text` | Mặc định `TẤT CẢ` |
| Lọc theo | `filter_by` | `select` | Chọn: `project_material`, `project_use`, `none` · Mặc định `project_material` |
| Số dự án tối đa | `limit` | `number` | Mặc định `24` |
| Chữ khi rỗng | `empty_text` | `text` | Mặc định `Không có dự án nào.` |

---

<a id="project-showcase"></a>
## LASAN — Project Showcase

`acf/project-showcase` · `blocks/project-showcase/` · field group `group_project_showcase`

Carousel điện ảnh trên nền navy sâu nhất.

> Căn `full` — băng tràn hết khổ · Có JavaScript riêng

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Nhãn block | `label` | `text` | Mặc định `DỰ ÁN TIÊU BIỂU` |
| Chọn dự án | `projects` | `relationship` | Tích chọn dự án từ post type Dự án. Ảnh, tên và thông số lấy thẳng từ hồ sơ dự án, không phải nhập lại. Để trống thì tự lấy các dự án mới nhất. |
| Số dự án khi để trống | `limit` | `number` | Mặc định `5` |

---

<a id="proof-strip"></a>
## LASAN — Proof Strip

`acf/proof-strip` · `blocks/proof-strip/` · field group `group_proof_strip`

Một dải bằng chứng ngắn: ba đến bốn con số, không diễn giải dài.

> Căn `full` — băng tràn hết khổ

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Items | `items` | `repeater` | Repeater — tối đa 4 · Ba đến bốn mục là vừa. Dải này để liếc qua, không để đọc. |
| ↳ Value | `items[].value` | `text` |  |
| ↳ Label | `items[].label` | `text` |  |
| ↳ Note | `items[].note` | `text` | Tuỳ chọn — một dòng rất ngắn. |
| ↳ Link | `items[].link` | `link` | Trả về mảng `url` / `title` / `target` |

---

<a id="quote"></a>
## LASAN — Quote

`acf/quote` · `blocks/quote/` · field group `group_quote`

Một phát biểu thật của khách hoặc của đội ngũ, cỡ chữ lớn.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Quote | `quote` | `textarea` | Chỉ dùng khi có phát biểu thật. Không đặt dấu ngoặc kép, khối tự vẽ. |
| Author | `author` | `text` |  |
| Role | `role` | `text` |  |
| Company | `company` | `text` |  |
| Photo | `image` | `image` | Trả về `id` |

---

<a id="rich-text"></a>
## LASAN — Rich Text

`acf/rich-text` · `blocks/rich-text/` · field group `group_rich_text`

Đoạn nội dung biên tập dài, một cột, chọn được bề rộng.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` | Để trống thì bỏ dòng nhãn kẻ ở đầu khối. |
| Heading | `heading` | `text` |  |
| Content | `content` | `wysiwyg` |  |
| Align | `align` | `select` | Chọn: `left`, `center` · Mặc định `left` |
| Width | `width` | `select` | Chọn: `narrow`, `medium`, `wide` · Mặc định `medium` |

---

<a id="section-intro"></a>
## LASAN — Section Intro

`acf/section-intro` · `blocks/section-intro/` · field group `group_section_intro`

Câu mở cho một section: nhãn, tiêu đề và một đoạn ngắn, căn giữa.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Label | `label` | `text` | Nhãn ngắn phía trên tiêu đề. |
| Heading | `heading` | `text` |  |
| Content | `content` | `wysiwyg` |  |
| Width | `width` | `select` | Chọn: `narrow`, `medium` · Mặc định `narrow` |
| CTA | `cta` | `link` | Trả về mảng `url` / `title` / `target` · Tuỳ chọn — một nút duy nhất dưới đoạn mở. |

---

<a id="service-architecture"></a>
## LASAN — Service Architecture

`acf/service-architecture` · `blocks/service-architecture/` · field group `group_service_architecture`

Danh mục dịch vụ; rê chuột vào một dòng thì đổi ảnh bên cạnh.

> Có JavaScript riêng

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` |  |
| Heading | `heading` | `text` |  |
| Figure Caption | `caption` | `text` |  |
| View All Label | `view_all` | `text` |  |
| View All Link | `view_all_link` | `link` | Trả về mảng `url` / `title` / `target` |
| Services | `items` | `repeater` | Repeater |
| ↳ Index | `items[].index` | `text` |  |
| ↳ Name | `items[].name` | `text` |  |
| ↳ Description | `items[].desc` | `textarea` |  |
| ↳ Link | `items[].link` | `link` | Trả về mảng `url` / `title` / `target` |
| ↳ Figure | `items[].image` | `image` | Trả về `id` |
| ↳ Sub-services | `items[].children` | `repeater` | Repeater |

---

<a id="service-spotlight"></a>
## LASAN — Service Spotlight

`acf/service-spotlight` · `blocks/service-spotlight/` · field group `group_service_spotlight`

Một dịch vụ: nửa ảnh, nửa bảng navy.

> Căn `full` — băng tràn hết khổ

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` |  |
| Image | `image` | `image` | Trả về `id` |
| Placeholder Text | `placeholder` | `text` |  |
| Caption | `caption` | `text` |  |
| Heading | `heading` | `text` |  |
| Body | `body` | `textarea` |  |
| List Items | `items` | `repeater` | Repeater |
| ↳ Text | `items[].text` | `text` |  |
| CTA | `cta` | `link` | Trả về mảng `url` / `title` / `target` |

---

<a id="shaft-diameter"></a>
## LASAN — Shaft Diameter

`acf/shaft-diameter` · `blocks/shaft-diameter/` · field group `group_shaft_diameter`

Đường kính trục chân vịt tối thiểu tham khảo, theo công thức phân cấp thông dụng.

> Có JavaScript riêng

_Không có field riêng._

---

<a id="spec-list"></a>
## LASAN — Spec List

`acf/spec-list` · `blocks/spec-list/` · field group `group_spec_list`

Dữ liệu kỹ thuật dạng dòng kẻ, không phải bảng văn phòng.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Heading | `heading` | `text` |  |
| Note | `note` | `textarea` |  |
| Rows | `rows` | `repeater` | Repeater |
| ↳ Label | `rows[].label` | `text` |  |
| ↳ Value | `rows[].value` | `text` |  |

---

<a id="team"></a>
## LASAN — Team

`acf/team` · `blocks/team/` · field group `group_team`

Danh sách nhân sự bên cạnh một chân dung tư liệu.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Heading | `heading` | `text` |  |
| Portrait | `image` | `image` | Trả về `id` |
| Placeholder Text | `placeholder` | `text` |  |
| People | `people` | `repeater` | Repeater |
| ↳ Name | `people[].name` | `text` |  |
| ↳ Role | `people[].role` | `text` |  |

---

<a id="tool-shell"></a>
## LASAN — Tool Shell

`acf/tool-shell` · `blocks/tool-shell/` · field group `group_tool_shell`

Khung dùng chung cho mọi công cụ tính; đặt block công cụ vào trong.

> Nhận khối con (InnerBlocks)

_Không có field riêng._

---

<a id="use-case"></a>
## LASAN — Use Case

`acf/use-case` · `blocks/use-case/` · field group `group_use_case`

Tình huống thật của khách: vấn đề, bối cảnh, cách xử lý.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` |  |
| Heading | `heading` | `text` |  |
| Intro | `intro` | `textarea` |  |
| Items | `items` | `repeater` | Repeater |
| ↳ Problem | `items[].problem` | `text` | Viết như lời khách nói ra, không phải tên dịch vụ. |
| ↳ Context | `items[].context` | `textarea` |  |
| ↳ Solution | `items[].solution` | `textarea` |  |
| ↳ Link | `items[].link` | `link` | Trả về mảng `url` / `title` / `target` |

---

<a id="value-grid"></a>
## LASAN — Value Grid

`acf/value-grid` · `blocks/value-grid/` · field group `group_value_grid`

Lưới giá trị/nguyên tắc có đánh số.

| Field | Name | Type | Ghi chú |
| --- | --- | --- | --- |
| Block Label | `label` | `text` |  |
| Items | `items` | `repeater` | Repeater |
| ↳ Icon | `items[].icon` | `select` | Chọn: `ship`, `waves`, `ruler`, `wrench`, `compass`, `scan`, `gauge`, `award`, `calculator`, `link` · Mặc định `ship` |
| ↳ Title | `items[].title` | `text` |  |
| ↳ Description | `items[].desc` | `textarea` |  |
| ↳ Link | `items[].link` | `link` | Trả về mảng `url` / `title` / `target` · Tuỳ chọn — hiện một liên kết nhỏ ở cuối ô. |

---
