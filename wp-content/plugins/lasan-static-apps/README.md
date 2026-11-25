# Lasan Static Apps

Các công cụ chạy trong trình duyệt (mô phỏng ổn định, sức cản – công suất,
kết cấu tàu…) là app tĩnh đã build sẵn: một `index.html` cùng thư mục
assets. Plugin này cho phép quản lý chúng ngay trong trang quản trị, không
cần sửa code hay deploy lại theme.

## Cấu trúc

```
lasan-static-apps/
├── lasan-static-apps.php      # plugin, nâng cấp dữ liệu khi đổi phiên bản plugin
├── includes/
│   ├── class-store.php        # cài, phiên bản, rebase đường dẫn, migration
│   ├── class-admin.php        # màn hình Admin → App tĩnh
│   └── functions.php          # API cho theme
└── apps/                      # các app đi kèm plugin (theo git, deploy cùng code)
    └── <slug>/
        ├── app.json           # { "name", "version": "1.0.0", "notes" }
        ├── index.html
        └── assets/…
```

Bản cài trên site nằm ở `wp-content/uploads/static-apps/<slug>/<phiên-bản>/`.
Mỗi phiên bản có URL riêng, nên trình duyệt và Cloudflare cache được lâu mà
không phục vụ nhầm bản cũ.

## Phiên bản

- **Số phiên bản theo semver:** `MAJOR.MINOR.PATCH`, có thể thêm nhãn thử
  nghiệm (`2.0.0-beta.1`).
  - PATCH: sửa lỗi.
  - MINOR: thêm tính năng.
  - MAJOR: thay đổi lớn, ví dụ đổi cách nhập liệu.
- **Một số đã cài thì bản build không đổi được nữa.** Build mới phải có số
  mới; tải trùng số sẽ bị từ chối. Ghi chú thay đổi thì sửa được bất cứ lúc
  nào.
- **Số phiên bản lấy theo thứ tự:**
  1. ô "Phiên bản" khi tải lên;
  2. `app.json` ở gốc bản build;
  3. `version` trong `package.json`;
  4. nếu không có gì, tự tăng PATCH từ bản cao nhất.
- **Rollback:** bấm "Dùng bản này" ở bản cũ. Có thể cài sẵn mà chưa dùng
  (bỏ chọn "Dùng ngay"), mở link phiên bản để xem thử, rồi mới chuyển.
- **Xoá:** không xoá được bản đang dùng; muốn xoá thì phải xoá cả app.
- **Cache:** đổi phiên bản thì cache trang (Cache Enabler) được xoá tự động.

## Hai cách phát hành bản mới

1. **Trong admin:** Admin → App tĩnh → Tải lên file `.zip`, chọn app, điền
   số phiên bản và ghi chú.
2. **Theo code:** thay bản build trong `apps/<slug>/` và tăng `version` trong
   `app.json`, rồi commit và deploy.
   - Bản mới được cài khi quản trị viên mở trang quản trị, hoặc khi chạy
     `php tools/static-apps.php` trên server. Nếu số mới hơn bản đang dùng
     thì được dùng luôn.
   - Mỗi số trong plugin chỉ được cài một lần. Nếu admin đã xoá hoặc đã quay
     lại bản cũ, lần đồng bộ sau không ghi đè lựa chọn đó. Nút "Cài lại các
     bản chưa có" cho phép cài lại.

**Đổi tên và mã (slug):** sửa ngay trên thẻ app, bấm "Lưu tên & mã".
- Khi đổi slug, file được dời sang thư mục mới và đường dẫn trong mọi phiên
  bản được sửa lại.
- Các trang đang dùng app được cập nhật tự động.
- Slug cũ được giữ làm alias (`lasan_static_apps_aliases`), nên nội dung còn
  ghi slug cũ (ví dụ JSON trong `tools/content/`) và gói `apps/<slug-cũ>/`
  trong plugin vẫn trỏ đúng app.

**Gắn app vào trang:** thêm khối **App Embed** rồi chọn app.
- Muốn công cụ chiếm toàn màn hình: chọn template "Ứng dụng toàn màn hình".
- Trang giới thiệu nên là trang con (…/gioi-thieu/).

## Chuẩn bị bản build

- **Nén thư mục build** (ví dụ `dist/`). `index.html` phải ở gốc file zip,
  hoặc nằm trong một thư mục duy nhất.
- **Nên build với đường dẫn tương đối.** Với Vite:

  ```js
  // vite.config.js
  export default { base: './' }
  ```

  Bản build theo đường dẫn tuyệt đối cũng dùng được. Plugin đọc đường dẫn gốc
  trong `index.html` rồi viết lại trong mọi file HTML/JS/CSS.
- **Chỉ nhận file tĩnh:** HTML, JS, CSS, JSON, ảnh, font, WASM, mô hình 3D,
  âm thanh/video, PDF.
  - File `.php`, file ẩn (`.htaccess`…), symlink và đường dẫn có `../` đều bị
    từ chối, và cả file zip không được cài.
  - Giới hạn: 5000 file, 300 MB sau khi giải nén.
- **Plugin tự thêm `noindex` vào `index.html` của app.** Google chỉ index
  trang công cụ của site, không index file app trần.

## Dữ liệu và nâng cấp plugin

- `lasan_static_apps`: danh sách app và phiên bản.
- `lasan_static_apps_schema`: phiên bản cấu trúc dữ liệu (hiện là 2).
- `lasan_static_apps_bundled`: số phiên bản trong gói plugin đã đồng bộ.

Khi plugin lên phiên bản có cấu trúc dữ liệu mới, dữ liệu được nâng cấp tự
động. Bản 1.1.0 đổi các bản 1.0 (đặt tên theo giờ tải lên, ví dụ
`20261119-015604`) thành `1.0.0`, `1.0.1`… theo thứ tự, và sửa lại đường dẫn
trong bản build.

**Theme không còn thư mục `apps/`.** Nếu tắt plugin, các trang công cụ sẽ
không hiện app.

## Lịch sử

- **1.1.0:**
  - Phiên bản theo semver, kèm ghi chú thay đổi.
  - Cài sẵn rồi mới dùng.
  - Các app đi kèm plugin ở `apps/`, chuyển từ theme sang.
  - Migration dữ liệu từ 1.0.
  - Đổi được slug (có alias).
- **1.0.0:** tải zip, phiên bản theo thời gian, rollback.

## Cho theme

```php
lasan_static_apps();                  // [ slug => tên ]
lasan_static_app_url( 'mo-phong-…' ); // URL index.html bản đang dùng, '' nếu không có
lasan_static_app_version( 'mo-phong-…' ); // '1.2.0'
```

## Lưu ý bảo mật

- App chạy cùng origin với site, vì nhiều app dùng `localStorage`.
- **Chỉ admin (`manage_options`) được tải app lên.** Chỉ cài bản build từ
  nguồn tin cậy.
