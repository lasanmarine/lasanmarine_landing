# Content CLI

Nội dung trang nằm trong `tools/content/*.json`. Sửa file, chạy một lệnh, WordPress cập nhật.

```bash
./tools/lasan apply                      # nạp mọi file trong tools/content/
./tools/lasan apply 10-home.vi           # nạp một file
./tools/lasan apply --dry-run            # xem sẽ tạo/cập nhật gì, không ghi
./tools/lasan dump home                  # xuất trang đang có ra JSON
./tools/lasan pages                      # liệt kê trang: id, ngôn ngữ, key, slug
./tools/lasan blocks                     # liệt kê 25 khối
./tools/lasan blocks capability-matrix   # liệt kê trường của một khối
```

Wrapper tự chạy trong container `lasan_wp` nếu docker đang lên, không thì dùng PHP máy.
Đổi container bằng biến `LASAN_WP_CONTAINER`.

## File một trang

```jsonc
{
  "key": "home",            // định danh bền, lưu vào _lasan_content_key
  "title": "Trang chủ",
  "slug": "trang-chu",
  "lang": "vi",             // Polylang; bỏ nếu không dùng
  "translation_of": "home", // chỉ đặt ở trang ngôn ngữ phụ
  "parent": "capabilities", // key hoặc slug trang cha
  "front_page": true,
  "seo": { "title": "…", "description": "…" },
  "blocks": [
    { "type": "hero", "fields": { "headline": "…" } }
  ]
}
```

File được nạp theo thứ tự tên, nên tiền tố số (`10-`, `20-`) quyết định trang nào tạo trước.
`apply` chạy hai lượt: lượt đầu tạo đủ trang, lượt sau nối link, trang cha và bản dịch — nhờ
vậy một trang trỏ được tới trang khai báo sau nó.

## Trường

Tên trường lấy đúng từ `blocks/<slug>/<slug>.json`; sai tên thì `apply` báo lỗi thay vì ghi âm thầm.

- **Repeater** — mảng object: `"items": [{ "name": "…" }]`
- **Link** — `{ "label": "Xem thêm", "page": "about" }` (key hoặc slug trang), hoặc
  `{ "label": "…", "url": "/lien-he/" }`. Không viết URL tuyệt đối: file phải chạy được trên
  mọi môi trường.
- **Ảnh** — id attachment: `"image": 230`

Link kiểu `page` được phân giải theo ngôn ngữ của trang đang nạp, nên trang tiếng Việt trỏ tới
trang tiếng Việt kể cả khi bản tiếng Anh trùng slug.

## Post type (Dự án)

Một file có khoá `posts` mô tả nhiều bài của một post type thay vì một trang:

```jsonc
{
  "post_type": "project",
  "lang": "vi",
  "posts": [
    {
      "slug": "cano-lam-hai",
      "title": "Cano chở khách Lam Hải",
      "excerpt": "…",
      "image": { "media": "cano-lam-hai" },        // ảnh đại diện, theo media key
      "terms": {                                    // term chưa có sẽ được tạo
        "project_material": ["Composite"],
        "project_use": ["Chở khách"]
      },
      "fields": { "lmax": 9.5, "power_kw": 85 }     // theo inc/fields/project.json
    }
  ]
}
```

Khớp bài theo `slug`, chạy lại là sửa chứ không nhân bản. Trang `/du-an/` liệt kê chúng
qua khối `project-index`, không nhập tay nữa.

## Menu

Một file có khoá `menu` mô tả một nav menu và gán vào vị trí trong theme:

```jsonc
{
  "menu": "LASAN Header",
  "location": "header_menu",
  "lang": "vi",
  "items": [
    { "label": "Giới thiệu", "page": "about" },
    {
      "label": "Năng lực", "page": "capabilities",
      "classes": ["has-mega"],                 // mở mega panel
      "description": "Câu dẫn hiện bên trái mega panel.",
      "children": [
        { "label": "Thiết kế tàu", "page": "service_01",
          "description": "Mô tả hiện dưới tên mục.",
          "children": [ { "label": "Đóng mới" } ]   // chip, không cần link riêng
        }
      ]
    }
  ]
}
```

Menu được dựng lại toàn bộ mỗi lần chạy, nên file là nguồn duy nhất. Menu ngôn ngữ phụ
được gán vào `<location>___<lang>` để Polylang nhận. Mục cháu không khai `page`/`url`
thì dùng URL của mục cha.

## Ảnh

```bash
./tools/lasan media          # nạp tools/media/ vào Media Library
```

Khoá theo tên file, chạy lại không tạo bản sao. Trong JSON dùng
`"image": { "media": "ten-file" }` để khỏi nhúng ID.

## Round-trip

`dump` là nghịch đảo của `apply`: sửa trực tiếp trong Gutenberg rồi `dump` lại để chốt vào JSON.
Link được đổi ngược về dạng `page`, nên file không dính tên host.

## Script cũ

`import-lasan-content.php`, `import-english-content.php`, `fix-acf-block-data.php`,
`make-all-blocks-page.php`, `merge-ship-design.php` là các script nạp một lần từ đợt chuyển từ
Astro sang. Nội dung mới nên đi qua CLI này.
