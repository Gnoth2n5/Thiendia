# Tra Cứu Liệt Sĩ Nghĩa Trang Ninh Bình

Dự án cung cấp hệ thống tra cứu thông tin liệt sĩ và quản lý nghĩa trang Ninh Bình, hỗ trợ trực quan hóa sơ đồ lô mộ, theo dõi thông tin liệt sĩ và quản trị dữ liệu tập trung cho cán bộ địa phương. Ứng dụng được xây dựng trên nền tảng Laravel 12, tận dụng Filament Panel để mang lại trải nghiệm quản trị hiện đại và dễ sử dụng.

## Chức năng chính

-   Quản lý thông tin nghĩa trang, khu vực, kích thước lưới lô mộ.
-   Hiển thị sơ đồ lưới trực quan với trạng thái từng lô (trống, đã sử dụng, đặt trước, không khả dụng).
-   Gán và quản lý thông tin mộ, liệt sĩ, gia đình.
-   Tìm kiếm nâng cao với nhiều tiêu chí lọc.
-   Hỗ trợ thao tác hàng loạt và các tác vụ quản trị khác thông qua Filament.

## Công nghệ và phiên bản

-   PHP 8.3.7
-   Laravel Framework 12.x
-   Filament 4.x
-   Livewire 3.x
-   Tailwind CSS 4.x
-   PHPUnit 11.x

## Yêu cầu hệ thống

-   PHP >= 8.2 (khuyến nghị 8.3)
-   Composer >= 2.6
-   Node.js >= 18 và npm >= 9
-   MySQL/MariaDB hoặc PostgreSQL
-   Tiện ích mở rộng PHP: `BCMath`, `Ctype`, `Fileinfo`, `JSON`, `Mbstring`, `OpenSSL`, `PDO`, `Tokenizer`, `XML`

## Cài đặt

```bash
git clone github_url
cd ''

composer install
npm install

cp .env.example .env
php artisan key:generate

# Cấu hình kết nối cơ sở dữ liệu trong .env

php artisan migrate --seed
php artisan storage:link

# Biên dịch tài sản giao diện
npm run build # hoặc npm run dev trong môi trường phát triển
```

## Chạy ứng dụng

```bash
php artisan serve
# Trong một tab khác
npm run dev
```

Truy cập trình duyệt tại `http://127.0.0.1:8000`.

## Kiểm thử và chất lượng mã

-   Chạy test: `php artisan test`
-   Kiểm tra đơn vị cụ thể: `php artisan test --filter=TenTest`
-   Định dạng mã PHP: `vendor/bin/pint --dirty`

## Cấu trúc thư mục đáng chú ý

-   `app/Models`: Định nghĩa mô hình dữ liệu (Nghĩa trang, Lô mộ, Mộ, ...).
-   `app/Filament`: Cấu hình panel quản trị, resource, widget và trang tùy chỉnh.
-   `resources/views`: Blade template cho các trang giao diện công khai và thành phần tùy chỉnh.
-   `resources/views/filament/forms/components`: Các thành phần Blade mở rộng cho Filament (ví dụ: lưới ô lô mộ).

## Quy trình phát triển đề xuất

1. Tạo nhánh mới cho mỗi chức năng hoặc lỗi.
2. Cập nhật/test đầy đủ trước khi tạo pull request.
3. Đảm bảo mã tuân thủ chuẩn Laravel và chuẩn dự án (Filament, Tailwind v4).
4. Miêu tả rõ thay đổi trong pull request, đính kèm ảnh chụp màn hình khi có cập nhật giao diện.

## Tài liệu và đường dẫn hữu ích

-   [Laravel Documentation](https://laravel.com/docs)
-   [Filament Documentation](https://filamentphp.com/docs)
-   [Livewire Documentation](https://livewire.laravel.com/)
-   [Tailwind CSS Documentation](https://tailwindcss.com/)

## Giấy phép

Dự án phát triển nội bộ. Nếu cần chia sẻ ra bên ngoài, vui lòng liên hệ nhóm phụ trách để được cấp quyền.
