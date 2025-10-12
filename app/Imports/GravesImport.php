<?php

namespace App\Imports;

use App\Models\Cemetery;
use App\Models\Grave;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GravesImport implements SkipsOnError, SkipsOnFailure, ToModel, WithStartRow, WithValidation
{
    use SkipsErrors, SkipsFailures;

    /**
     * Bắt đầu từ row 2 (bỏ qua header).
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Map dữ liệu từ Excel theo thứ tự cột.
     *
     * Thứ tự cột:
     * 0: Xã/Phường/Thị trấn
     * 1: Tên Nghĩa Trang
     * 2: Số Lăng Mộ
     * 3: Tên Chủ Lăng Mộ
     * 4: Tên Người Quá Cố
     * 5: Ngày Sinh
     * 6: Ngày Mất
     * 7: Giới Tính
     * 8: Quan Hệ
     * 9: Ngày An Táng
     * 10: Loại Mộ
     * 11: Trạng Thái
     * 12: Mô Tả Vị Trí
     * 13: Số Điện Thoại
     * 14: Email
     * 15: Địa Chỉ Liên Hệ
     * 16: Ghi Chú
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row): ?Grave
    {
        // Bỏ qua row trống - kiểm tra tất cả các cột
        $isEmpty = true;
        foreach ($row as $cell) {
            if (!empty($cell) && trim((string) $cell) !== '') {
                $isEmpty = false;
                break;
            }
        }

        if ($isEmpty) {
            return null;
        }

        // Kiểm tra các trường bắt buộc
        // Xã/Phường (cột 0), Tên Nghĩa Trang (cột 1), Số Lăng Mộ (cột 2), Tên Chủ Lăng Mộ (cột 3)
        if (empty($row[1]) || empty(trim((string) ($row[2] ?? ''))) || empty(trim((string) ($row[3] ?? '')))) {
            return null;
        }

        // Tìm cemetery theo tên và xã/phường để chính xác hơn
        $cemetery = Cemetery::where('name', 'like', '%' . $row[1] . '%')
            ->where('commune', $row[0])
            ->first();

        // Nếu không tìm thấy với xã/phường, thử tìm chỉ theo tên
        if (!$cemetery) {
            $cemetery = Cemetery::where('name', 'like', '%' . $row[1] . '%')->first();
        }

        if (!$cemetery) {
            return null;
        }

        // Parse dates (cột đã dịch sang phải 1 vị trí)
        $burialDate = $this->parseDate($row[9] ?? null);
        $deceasedBirthDate = $this->parseDate($row[5] ?? null);
        $deceasedDeathDate = $this->parseDate($row[6] ?? null);

        // Build contact info
        $contactInfo = [];
        if (!empty($row[13])) {
            // Xử lý số điện thoại: đảm bảo giữ số 0 đằng trước
            $phone = $this->formatPhoneNumber($row[13]);
            $contactInfo['phone'] = $phone;
        }
        if (!empty($row[14])) {
            $contactInfo['email'] = trim($row[14]);
        }
        if (!empty($row[15])) {
            $contactInfo['address'] = trim($row[15]);
        }

        return new Grave([
            'cemetery_id' => $cemetery->id,
            'grave_number' => $row[2] ?? '',
            'owner_name' => $row[3] ?? '',
            'deceased_full_name' => $row[4] ?? null,
            'deceased_birth_date' => $deceasedBirthDate,
            'deceased_death_date' => $deceasedDeathDate,
            'deceased_gender' => $row[7] ?? 'nam',
            'deceased_relationship' => $row[8] ?? null,
            'burial_date' => $burialDate,
            'grave_type' => $row[10] ?? 'đất',
            'status' => $row[11] ?? 'còn_trống',
            'location_description' => $row[12] ?? null,
            'contact_info' => !empty($contactInfo) ? $contactInfo : null,
            'notes' => $row[16] ?? null,
        ]);
    }

    /**
     * Parse date from various formats
     */
    protected function parseDate($date): ?string
    {
        if (empty($date)) {
            return null;
        }

        try {
            // If it's already a Carbon instance
            if ($date instanceof Carbon) {
                return $date->format('Y-m-d');
            }

            // If it's a numeric Excel date
            if (is_numeric($date)) {
                return Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d'))->format('Y-m-d');
            }

            // Try to parse as string
            return Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Format phone number - đảm bảo giữ số 0 đằng trước
     */
    protected function formatPhoneNumber($value): string
    {
        if (empty($value)) {
            return '';
        }

        // Chuyển thành string và loại bỏ khoảng trắng
        $phone = trim((string) $value);

        // Nếu là số và không bắt đầu bằng 0, thêm 0 vào đầu
        if (is_numeric($phone) && !str_starts_with($phone, '0')) {
            $phone = '0' . $phone;
        }

        // Loại bỏ các ký tự không phải số (giữ dấu +)
        $phone = preg_replace('/[^\d+]/', '', $phone);

        return $phone;
    }

    /**
     * Validation rules theo index cột.
     *
     * Chỉ validate các trường không bắt buộc
     */
    public function rules(): array
    {
        return [
            '7' => 'nullable|in:nam,nữ,khác', // Giới Tính (cột đã dịch)
            '10' => 'nullable|in:đất,xi_măng,đá,gỗ,khác', // Loại Mộ (cột đã dịch)
            '11' => 'nullable|in:còn_trống,đã_sử_dụng,bảo_trì,ngừng_sử_dụng', // Trạng Thái (cột đã dịch)
            '13' => 'nullable|string|max:20', // Số Điện Thoại (cột đã dịch)
            '14' => 'nullable|email|max:255', // Email (cột đã dịch)
        ];
    }

    /**
     * Custom validation messages.
     */
    public function customValidationMessages(): array
    {
        return [
            '7.in' => 'Giới tính phải là: nam, nữ hoặc khác',
            '10.in' => 'Loại mộ phải là: đất, xi_măng, đá, gỗ hoặc khác',
            '11.in' => 'Trạng thái phải là: còn_trống, đã_sử_dụng, bảo_trì hoặc ngừng_sử_dụng',
            '13.string' => 'Số điện thoại phải là chuỗi ký tự',
            '13.max' => 'Số điện thoại không được vượt quá 20 ký tự',
            '14.email' => 'Email không đúng định dạng',
            '14.max' => 'Email không được vượt quá 255 ký tự',
        ];
    }
}
