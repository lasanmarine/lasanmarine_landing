# Lasan Static Apps

Các công cụ chạy trong trình duyệt (mô phỏng ổn định, sức cản – công suất,
kết cấu tàu…) là app tĩnh đã build sẵn: một `index.html` cùng thư mục
assets. Plugin này cho phép quản lý chúng ngay trong trang quản trị, không
cần sửa code hay deploy lại theme.

## Dùng

1. **Admin → App tĩnh → Tải lên.** Chọn file `.zip` bản build. Nếu là app
   mới thì đặt tên và mã (slug); nếu là bản cập nhật thì chọn app có sẵn.
2. **Gắn vào trang.** Thêm khối **App Embed** vào trang rồi chọn app.
   - Muốn công cụ chiếm toàn màn hình: chọn template "Ứng dụng toàn màn hình"
     cho trang.
   - Trang giới thiệu nên là trang con của trang đó (…/gioi-thieu/).
3. **Mỗi lần tải lên là một phiên bản mới.** Có thể chuyển lại bản cũ bằng
   nút "Dùng bản này", và xoá các bản không dùng. Không xoá được bản đang
   dùng; muốn xoá thì phải xoá cả app.

Khi đổi phiên bản, cache trang (Cache Enabler) được xoá tự động. File của mỗi
phiên bản nằm ở một URL riêng
(`/wp-content/uploads/static-apps/<slug>/<phiên-bản>/`), nên trình duyệt và
Cloudflare cache được lâu mà không phục vụ nhầm bản cũ.

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

## App có sẵn trong theme

Ba app ban đầu nằm trong `themes/starter-flexible/apps/`. Màn hình App tĩnh
có nút **Nhập các app này** để chuyển chúng sang plugin; trang đang dùng app
không phải sửa gì.
- App chưa nhập vẫn chạy từ thư mục theme.
- Khi tắt plugin, theme quay về dùng bản trong thư mục theme
  (`inc/static-apps.php`).

## Cho theme

```php
lasan_static_apps();                  // [ slug => tên ]
lasan_static_app_url( 'mo-phong-…' ); // URL index.html bản đang dùng, '' nếu không có
```

## Lưu ý bảo mật

- App chạy cùng origin với site, vì nhiều app dùng `localStorage`.
- **Chỉ admin (`manage_options`) được tải app lên.** Chỉ cài bản build từ
  nguồn tin cậy.
