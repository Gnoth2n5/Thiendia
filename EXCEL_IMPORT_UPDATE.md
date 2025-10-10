# Cập Nhật Chức Năng Import Excel Grave

## 🎯 Mục tiêu

Cập nhật chức năng import Excel cho grave để phù hợp với cấu trúc database mới sau khi cleanup migration.

## 📊 Thay đổi cấu trúc

### Trước khi cập nhật:

-   **18 cột** trong template Excel (quá phức tạp)
-   Có các cột không cần thiết: `Huyện`, `Xã`
-   Tên cột chưa hoàn toàn tiếng Việt

### Sau khi cập nhật:

-   **16 cột** trong template Excel (đơn giản hóa)
-   Chỉ giữ lại các cột cơ bản cần thiết
-   Tất cả tên cột đều là tiếng Việt

## 📋 Cấu trúc Template Excel Mới

| Cột | Tên Cột          | Mô Tả                       | Bắt Buộc | Validation                                              |
| --- | ---------------- | --------------------------- | -------- | ------------------------------------------------------- |
| A   | Tên Nghĩa Trang  | Tên nghĩa trang             | ✅       | Dropdown từ database                                    |
| B   | Số Lăng Mộ       | Số hiệu lăng mộ             | ✅       | String, max 255                                         |
| C   | Tên Chủ Lăng Mộ  | Tên người sở hữu            | ✅       | String, max 255                                         |
| D   | Tên Người Quá Cố | Tên người đã khuất          | ❌       | -                                                       |
| E   | Ngày Sinh        | Ngày sinh người đã khuất    | ❌       | Date format                                             |
| F   | Ngày Mất         | Ngày mất người đã khuất     | ❌       | Date format                                             |
| G   | Giới Tính        | Giới tính người đã khuất    | ❌       | Dropdown: nam, nữ, khác                                 |
| H   | Quan Hệ          | Mối quan hệ với chủ lăng mộ | ❌       | -                                                       |
| I   | Ngày An Táng     | Ngày chôn cất               | ❌       | Date format                                             |
| J   | Loại Mộ          | Loại vật liệu làm mộ        | ❌       | Dropdown: đất, xi_măng, đá, gỗ, khác                    |
| K   | Trạng Thái       | Trạng thái sử dụng          | ❌       | Dropdown: còn_trống, đã_sử_dụng, bảo_trì, ngừng_sử_dụng |
| L   | Mô Tả Vị Trí     | Mô tả vị trí lăng mộ        | ❌       | -                                                       |
| M   | Số Điện Thoại    | Số điện thoại liên hệ       | ❌       | String, max 20                                          |
| N   | Email            | Email liên hệ               | ❌       | Email format, max 255                                   |
| O   | Địa Chỉ Liên Hệ  | Địa chỉ liên hệ             | ❌       | -                                                       |
| P   | Ghi Chú          | Ghi chú bổ sung             | ❌       | -                                                       |

## 🔧 Thay đổi Code

### 1. GravesTemplateExport.php

```php
// Loại bỏ cột không cần thiết
- Xóa 'Huyện', 'Xã' (cột B, C cũ)

// Thêm dropdown cho Tên Nghĩa Trang
- Tên Nghĩa Trang: Dropdown từ database (required)
- Lấy danh sách nghĩa trang từ Cemetery::pluck('name')

// Cập nhật validation dropdown
- Giới Tính: Cột G (thay vì I)
- Loại Mộ: Cột J (thay vì L)
- Trạng Thái: Cột K (thay vì M)

// Cập nhật auto-size columns
- Từ A-R thành A-P (16 cột)
```

### 2. GravesImport.php

```php
// Cập nhật mapping cột (đơn giản hóa)
- grave_number: $row[1] (thay vì $row[3])
- owner_name: $row[2] (thay vì $row[4])
- deceased_full_name: $row[3] (thay vì $row[5])
- deceased_birth_date: $row[4] (thay vì $row[6])
- deceased_death_date: $row[5] (thay vì $row[7])
- deceased_gender: $row[6] (thay vì $row[8])
- deceased_relationship: $row[7] (thay vì $row[9])
- burial_date: $row[8] (thay vì $row[10])
- grave_type: $row[9] (thay vì $row[11])
- status: $row[10] (thay vì $row[12])
- location_description: $row[11] (thay vì $row[13])
- contact_info: JSON từ $row[12], $row[13], $row[14] (thay vì $row[14], $row[15], $row[16])
- notes: $row[15] (thay vì $row[17])

// Cập nhật validation rules
- Cập nhật index cột cho tất cả validation
- Giữ nguyên logic validation
```

## 📁 File Excel Mẫu

### Tạo file mẫu mới:

```bash
php artisan tinker --execute="
use Maatwebsite\Excel\Facades\Excel;
Excel::store(new \App\Exports\GravesTemplateExport, 'mau_import_moi.xlsx', 'public');
echo 'Template exported successfully';
"
```

### Vị trí file:

-   `storage/app/public/mau_import_moi.xlsx`
-   Có thể download từ admin panel

## 🎯 Lợi ích

### ✅ Trước:

-   ❌ Template quá phức tạp (18 cột)
-   ❌ Có cột không cần thiết (Huyện, Xã)
-   ❌ Tên cột chưa hoàn toàn tiếng Việt
-   ❌ Khó sử dụng cho người dùng

### ✅ Sau:

-   ✅ Template đơn giản (16 cột)
-   ✅ Chỉ giữ lại cột cơ bản cần thiết
-   ✅ Tất cả tên cột đều tiếng Việt
-   ✅ **Dropdown cho Tên Nghĩa Trang** từ database
-   ✅ Dễ sử dụng và hiểu
-   ✅ Validation đầy đủ và chính xác

## 🚀 Cách sử dụng

### 1. Download Template:

-   Vào admin panel → Graves → Import
-   Download file Excel mẫu mới

### 2. Điền dữ liệu:

-   **Chọn nghĩa trang** từ dropdown (cột A)
-   Điền thông tin theo cấu trúc mới
-   Sử dụng dropdown cho các trường có sẵn
-   **Không cần nhập tên nghĩa trang** - chỉ cần chọn từ danh sách

### 3. Upload và Import:

-   Upload file Excel đã điền
-   Hệ thống sẽ validate và import dữ liệu
-   Xem báo cáo lỗi nếu có

## 📝 Lưu ý

1. **Tên nghĩa trang** - chọn từ dropdown (không cần nhập tay)
2. **Số lăng mộ** và **Tên chủ lăng mộ** là bắt buộc
3. **Email** phải đúng định dạng nếu có
4. **Ngày tháng** có thể nhập nhiều định dạng
5. **Dropdown values** phải chính xác (không có khoảng trắng thừa)
6. **Template tự động cập nhật** danh sách nghĩa trang từ database

## 🎉 Kết quả

-   ✅ Template Excel được đơn giản hóa (16 cột)
-   ✅ Loại bỏ các cột không cần thiết
-   ✅ Tất cả tên cột đều tiếng Việt
-   ✅ **Dropdown cho Tên Nghĩa Trang** từ database
-   ✅ Import function tương thích với database mới
-   ✅ Validation đầy đủ và chính xác
-   ✅ User experience tốt hơn với template đơn giản
-   ✅ Dữ liệu được import chính xác vào đúng cột
-   ✅ **Không cần nhập tay tên nghĩa trang** - chỉ cần chọn
