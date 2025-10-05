# 🏛️ Hệ thống Quản lý Nghĩa Địa & Lăng Mộ

Hệ thống web hiện đại giúp quản lý thông tin nghĩa địa, lăng mộ và xử lý yêu cầu sửa đổi thông tin từ người dân.

![Laravel](https://img.shields.io/badge/Laravel-v12-FF2D20?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-v8.3-777BB4?style=flat&logo=php)
![Filament](https://img.shields.io/badge/Filament-v4-F59E0B?style=flat)
![TailwindCSS](https://img.shields.io/badge/Tailwind-v4-38B2AC?style=flat&logo=tailwind-css)

## 📋 Mục lục

-   [Tính năng](#-tính-năng)
-   [Công nghệ](#️-công-nghệ-sử-dụng)
-   [Cài đặt](#-cài-đặt)
-   [Cấu hình](#️-cấu-hình)
-   [Sử dụng](#-sử dụng)
-   [Cấu trúc Database](#-cấu-trúc-database)
-   [Screenshots](#-screenshots)
-   [Đóng góp](#-đóng-góp)
-   [License](#-license)

## ✨ Tính năng

### 🔐 Admin Panel (Filament)

-   ✅ Quản lý nghĩa trang (Cemeteries)
-   ✅ Quản lý lăng mộ (Graves) với tự động sinh số lăng mộ
-   ✅ Quản lý thông tin người đã khuất
-   ✅ Upload ảnh người đã khuất và ảnh bia mộ
-   ✅ Xử lý yêu cầu sửa đổi thông tin từ người dân
-   ✅ Dashboard với thống kê tổng quan
-   ✅ Widgets hiển thị số liệu quan trọng
-   ✅ Giao diện tiếng Việt

### 🌐 Giao diện công khai

-   ✅ Tra cứu thông tin lăng mộ (không cần đăng nhập)
-   ✅ Tìm kiếm theo:
    -   Số lăng mộ
    -   Tên chủ lăng mộ
    -   Tên người đã khuất
    -   Nghĩa trang
-   ✅ Xem chi tiết lăng mộ với ảnh
-   ✅ Gửi yêu cầu sửa đổi thông tin
-   ✅ Giao diện trang trọng, ấm áp phù hợp với chủ đề
-   ✅ Responsive design (mobile-friendly)

## 🛠️ Công nghệ sử dụng

### Backend

-   **Laravel 12** - PHP Framework
-   **Filament 4** - Admin Panel Builder
-   **MySQL** - Database
-   **Livewire 3** - Dynamic UI Components

### Frontend

-   **Tailwind CSS 4** - Utility-first CSS Framework
-   **DaisyUI 5** - Tailwind CSS Component Library
-   **Alpine.js** - Lightweight JavaScript Framework
-   **Heroicons** - Beautiful SVG Icons
-   **Vite** - Frontend Build Tool

### Additional Packages

-   **Spatie Laravel Permission** - Role & Permission Management
-   **Laravel Pint** - PHP Code Style Fixer

## 📦 Cài đặt

### Yêu cầu hệ thống

-   PHP >= 8.3
-   Composer
-   Node.js >= 18
-   MySQL >= 8.0
-   Git

### Các bước cài đặt

1. **Clone repository**

```bash
git clone <repository-url>
cd quanlynghiadia
```

2. **Cài đặt dependencies**

```bash
composer install
npm install
```

3. **Tạo file .env**

```bash
cp .env.example .env
```

4. **Generate application key**

```bash
php artisan key:generate
```

5. **Cấu hình database trong .env**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quanlynghiadia
DB_USERNAME=root
DB_PASSWORD=
```

6. **Chạy migrations và seeders**

```bash
php artisan migrate --seed
```

7. **Tạo symbolic link cho storage**

```bash
php artisan storage:link
```

8. **Build assets**

```bash
npm run build
```

9. **Khởi động server**

```bash
php artisan serve
```

Truy cập:

-   **Trang công khai**: http://127.0.0.1:8000
-   **Admin panel**: http://127.0.0.1:8000/admin
    -   Email: `admin@gmail.com`
    -   Password: `password`

## ⚙️ Cấu hình

### Filesystem

Hệ thống sử dụng `public` disk để lưu ảnh:

```env
FILESYSTEM_DISK=public
```

### Locale

```env
APP_LOCALE=vi
APP_FAKER_LOCALE=vi_VN
```

### Tailwind Theme

Theme cemetery tùy chỉnh trong `tailwind.config.js`:

```javascript
themes: [
    {
        cemetery: {
            primary: "#0f766e", // Xanh ngọc trang trọng
            secondary: "#7c3aed", // Tím violet
            accent: "#f59e0b", // Vàng amber ấm áp
            // ...
        },
    },
];
```

## 🚀 Sử dụng

### Cho Admin

1. **Đăng nhập Admin Panel** tại `/admin`
2. **Quản lý Nghĩa trang**: Thêm/sửa/xóa nghĩa trang
3. **Quản lý Lăng mộ**:
    - Chọn nghĩa trang → Số lăng mộ tự động sinh
    - Nhập thông tin chủ lăng mộ
    - Thêm thông tin người đã khuất
    - Upload ảnh (tùy chọn)
4. **Xử lý yêu cầu**:
    - Xem danh sách yêu cầu sửa đổi
    - Phê duyệt hoặc từ chối
    - Thêm ghi chú

### Cho Người dùng

1. **Trang chủ**: Xem thống kê tổng quan
2. **Tra cứu**: Tìm kiếm lăng mộ theo nhiều tiêu chí
3. **Chi tiết**: Xem đầy đủ thông tin và ảnh
4. **Yêu cầu sửa đổi**: Gửi đơn yêu cầu chỉnh sửa thông tin

## 📊 Cấu trúc Database

### Bảng chính

**cemeteries** - Nghĩa trang

```
- id
- name (tên nghĩa trang)
- address (địa chỉ)
- description (mô tả)
```

**graves** - Lăng mộ

```
- id
- cemetery_id (FK)
- grave_number (số lăng mộ - tự động: {cemetery_id}-{số})
- owner_name (chủ lăng mộ)
- deceased_full_name (người đã khuất)
- deceased_birth_date, deceased_death_date
- deceased_gender, deceased_relationship
- deceased_photo (ảnh người đã khuất)
- grave_photos (JSON array - ảnh bia mộ)
- burial_date (ngày an táng)
- grave_type (loại: đất, xi măng, đá, gỗ, khác)
- status (trạng thái)
- location_description
- contact_info (JSON)
- notes
```

**modification_requests** - Yêu cầu sửa đổi

```
- id
- grave_id (FK)
- requester_name, requester_phone, requester_email
- request_type (loại yêu cầu)
- current_data (JSON - dữ liệu hiện tại)
- requested_data (JSON - dữ liệu yêu cầu)
- reason (lý do)
- status (pending/approved/rejected)
- admin_notes
- processed_by (FK users)
- processed_at
```

## 📸 Screenshots

### Admin Panel

-   Dashboard với widgets thống kê
-   Quản lý nghĩa trang với filters
-   Form tạo/sửa lăng mộ với auto-generate số
-   Xử lý yêu cầu sửa đổi

### Giao diện công khai

-   Trang chủ với hero section
-   Trang tìm kiếm với filters
-   Chi tiết lăng mộ với gallery ảnh
-   Form yêu cầu sửa đổi

## 🔧 Development

### Chạy development mode

```bash
# Backend
php artisan serve

# Frontend (watch mode)
npm run dev
```

### Code style

```bash
# Format PHP code
vendor/bin/pint

# Format PHP (dry run)
vendor/bin/pint --test
```

### Testing

```bash
php artisan test
```

## 📝 Tính năng nổi bật

### 🎯 Tự động sinh số lăng mộ

-   Format: `{cemetery_id}-{số_thứ_tự_3_chữ_số}`
-   Ví dụ: `1-001`, `2-045`, `3-123`
-   Tự động tăng dần theo nghĩa trang
-   Preview real-time khi chọn nghĩa trang

### 📷 Upload & quản lý ảnh

-   Ảnh người đã khuất (1 ảnh)
-   Ảnh bia mộ (tối đa 5 ảnh)
-   Image editor tích hợp
-   Reorderable (kéo thả sắp xếp)
-   Lưu trong `storage/app/public`

### 🎨 UI/UX

-   Gradient backgrounds
-   Shadow layers
-   Hover effects
-   Responsive design
-   Solemn & warm color scheme
-   Heroicons v2
-   DaisyUI components

## 🤝 Đóng góp

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork dự án
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Mở Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Author

Được xây dựng với ❤️ sử dụng Laravel, Filament và Tailwind CSS.

## 📞 Hỗ trợ

Nếu bạn gặp vấn đề hoặc có câu hỏi, vui lòng:

-   Tạo Issue trên GitHub
-   Liên hệ qua email
-   Xem [Documentation](./plan/plan.md)

---

**Note**: Đây là hệ thống mẫu cho mục đích học tập và demo. Vui lòng tùy chỉnh theo nhu cầu thực tế của bạn.
