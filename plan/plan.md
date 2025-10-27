# Kế hoạch dự án: Hệ thống quản lý thông tin lăng mộ

## 1. Tổng quan dự án

### Mục tiêu

Xây dựng hệ thống web quản lý thông tin lăng mộ với 2 loại người dùng:

-   **Admin**: Quản lý thông tin lăng mộ và xử lý đơn yêu cầu sửa đổi
-   **Người dùng thường**: Tra cứu thông tin lăng mộ (không cần đăng nhập)

### Công nghệ sử dụng

-   **Backend**: Laravel 11
-   **Database**: MySQL
-   **Frontend**: Tailwind CSS + DaisyUI
-   **Admin Panel**: Filament
-   **Màu sắc**: Tông màu trang trọng, phù hợp với đề tài lăng mộ

## 2. Phân tích yêu cầu chức năng

### 2.1 Chức năng cho Admin

-   Đăng nhập/đăng xuất
-   Quản lý thông tin lăng mộ (CRUD)
-   Xem danh sách đơn yêu cầu sửa đổi
-   Phê duyệt/từ chối đơn yêu cầu
-   Quản lý người dùng admin
-   Thống kê và báo cáo

### 2.2 Chức năng cho người dùng thường

-   Tra cứu lăng mộ theo tên
-   Tìm kiếm theo khu vực/nghĩa trang
-   Xem chi tiết thông tin lăng mộ
-   Gửi đơn yêu cầu sửa đổi thông tin
-   Xem lịch sử đơn yêu cầu đã gửi

## 3. Thiết kế cơ sở dữ liệu

### 3.1 Bảng `users` (Admin)

```sql
- id (primary key)
- name
- email (unique)
- password
- role (admin/super_admin)
- created_at
- updated_at
```

### 3.2 Bảng `cemeteries` (Nghĩa trang)

```sql
- id (primary key)
- name (tên nghĩa trang)
- address (địa chỉ)
- description (mô tả)
- created_at
- updated_at
```

### 3.3 Bảng `graves` (Lăng mộ)

```sql
- id (primary key)
- cemetery_id (foreign key)
- grave_number (số lăng mộ)
- owner_name (tên chủ lăng mộ)
- deceased_persons (JSON - danh sách người đã khuất)
- burial_date (ngày an táng)
- grave_type (loại lăng mộ: đất, xi măng, đá...)
- status (trạng thái: còn trống, đã sử dụng, bảo trì...)
- location_description (mô tả vị trí)
- contact_info (thông tin liên hệ)
- notes (ghi chú)
- created_at
- updated_at
```

### 3.4 Bảng `modification_requests` (Đơn yêu cầu sửa đổi)

```sql
- id (primary key)
- grave_id (foreign key)
- requester_name (tên người yêu cầu)
- requester_phone (số điện thoại)
- requester_email (email)
- requester_relationship (mối quan hệ với người đã khuất)
- request_type (loại yêu cầu: sửa thông tin, thêm người...)
- current_data (JSON - dữ liệu hiện tại)
- requested_data (JSON - dữ liệu yêu cầu sửa đổi)
- reason (lý do yêu cầu)
- status (trạng thái: pending, approved, rejected)
- admin_notes (ghi chú của admin)
- processed_by (admin xử lý)
- processed_at (thời gian xử lý)
- created_at
- updated_at
```

### 3.5 Bảng `deceased_persons` (Người đã khuất)

```sql
- id (primary key)
- grave_id (foreign key)
- full_name (họ tên đầy đủ)
- birth_date (ngày sinh)
- death_date (ngày mất)
- gender (giới tính)
- relationship (mối quan hệ với chủ lăng mộ)
- notes (ghi chú)
- created_at
- updated_at
```

## 4. Thiết kế giao diện

### 4.1 Màu sắc chủ đạo

-   **Primary**: #2D3748 (xám đậm trang trọng)
-   **Secondary**: #4A5568 (xám trung bình)
-   **Accent**: #805AD5 (tím nhẹ)
-   **Background**: #F7FAFC (xám rất nhạt)
-   **Text**: #1A202C (đen nhẹ)
-   **Success**: #38A169 (xanh lá)
-   **Warning**: #D69E2E (vàng cam)
-   **Error**: #E53E3E (đỏ)

### 4.2 Trang chủ (Public)

-   Header với logo và menu
-   Form tìm kiếm lăng mộ nổi bật
-   Danh sách nghĩa trang
-   Thống kê tổng quan
-   Footer với thông tin liên hệ

### 4.3 Trang kết quả tìm kiếm

-   Bộ lọc (nghĩa trang, loại lăng mộ, trạng thái)
-   Danh sách lăng mộ với pagination
-   Card hiển thị thông tin cơ bản

### 4.4 Trang chi tiết lăng mộ

-   Thông tin chủ lăng mộ
-   Danh sách người đã khuất
-   Thông tin vị trí và mô tả
-   Nút "Yêu cầu sửa đổi thông tin"

### 4.5 Form yêu cầu sửa đổi

-   Thông tin người yêu cầu
-   Chọn loại yêu cầu
-   Hiển thị dữ liệu hiện tại
-   Form nhập dữ liệu mới
-   Lý do yêu cầu

## 5. Admin Panel với Filament

### 5.1 Dashboard

-   Thống kê tổng quan (số lăng mộ, đơn yêu cầu chờ xử lý...)
-   Biểu đồ thống kê
-   Danh sách đơn yêu cầu mới nhất

### 5.2 Quản lý lăng mộ

-   Danh sách lăng mộ với bộ lọc
-   Form thêm/sửa lăng mộ
-   Quản lý người đã khuất trong lăng mộ
-   Import/Export dữ liệu

### 5.3 Quản lý đơn yêu cầu

-   Danh sách đơn yêu cầu theo trạng thái
-   Xem chi tiết đơn yêu cầu
-   Form phê duyệt/từ chối
-   Gửi email thông báo kết quả

### 5.4 Quản lý nghĩa trang

-   CRUD nghĩa trang
-   Quản lý khu vực trong nghĩa trang

### 5.5 Quản lý người dùng

-   Quản lý admin
-   Phân quyền

## 6. Kế hoạch phát triển

### Phase 1: Setup và cơ sở dữ liệu (Tuần 1-2)

-   [ ] Cài đặt Laravel và các package cần thiết
-   [ ] Cài đặt Filament
-   [ ] Cài đặt Tailwind CSS và DaisyUI
-   [ ] Tạo migration cho các bảng
-   [ ] Tạo model và relationship
-   [ ] Seed dữ liệu mẫu

### Phase 2: Admin Panel (Tuần 3-4)

-   [ ] Cấu hình Filament admin panel
-   [ ] Tạo resource cho quản lý lăng mộ
-   [ ] Tạo resource cho quản lý đơn yêu cầu
-   [ ] Tạo resource cho quản lý nghĩa trang
-   [ ] Tạo dashboard với thống kê

### Phase 3: Giao diện công khai (Tuần 5-6)

-   [ ] Thiết kế layout chính
-   [ ] Tạo trang chủ với form tìm kiếm
-   [ ] Tạo trang kết quả tìm kiếm
-   [ ] Tạo trang chi tiết lăng mộ
-   [ ] Tạo form yêu cầu sửa đổi

### Phase 4: Tích hợp và tối ưu (Tuần 7-8)

-   [ ] Tích hợp tìm kiếm nâng cao
-   [ ] Tối ưu hiệu suất
-   [ ] Test toàn bộ hệ thống
-   [ ] Deploy và cấu hình production

## 7. Cấu trúc thư mục dự án

```
app/
├── Http/Controllers/
│   ├── Public/
│   │   ├── HomeController.php
│   │   ├── SearchController.php
│   │   └── RequestController.php
│   └── Admin/
├── Models/
│   ├── Cemetery.php
│   ├── Grave.php
│   ├── DeceasedPerson.php
│   └── ModificationRequest.php
├── Filament/
│   ├── Resources/
│   │   ├── CemeteryResource.php
│   │   ├── GraveResource.php
│   │   └── ModificationRequestResource.php
│   └── Pages/
resources/
├── views/
│   ├── layouts/
│   ├── public/
│   └── components/
├── css/
└── js/
database/
├── migrations/
├── seeders/
└── factories/
```

## 8. Các tính năng nâng cao (Tương lai)

-   Bản đồ nghĩa trang với vị trí lăng mộ
-   Upload ảnh lăng mộ
-   Lịch sử thay đổi thông tin
-   API cho ứng dụng mobile
-   Tích hợp thanh toán online
-   Hệ thống thông báo email/SMS
-   Báo cáo thống kê chi tiết

## 9. Yêu cầu kỹ thuật

### Server

-   PHP 8.2+
-   MySQL 8.0+
-   Composer
-   Node.js & NPM

### Package cần thiết

-   Laravel 11
-   Filament 3
-   Tailwind CSS
-   DaisyUI
-   Laravel Sanctum (nếu cần API)
-   Spatie Laravel Permission (phân quyền)

## 10. Bảo mật

-   Xác thực admin với Laravel Auth
-   CSRF protection
-   Validation dữ liệu đầu vào
-   Rate limiting cho form yêu cầu
-   Backup dữ liệu định kỳ
-   Log hoạt động admin

---

_Kế hoạch này sẽ được cập nhật và điều chỉnh trong quá trình phát triển dự án._
