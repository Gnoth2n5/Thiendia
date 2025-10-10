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
     * 0: Tên Nghĩa Trang
     * 1: Số Lăng Mộ
     * 2: Tên Chủ Lăng Mộ
     * 3: Tên Người Quá Cố
     * 4: Ngày Sinh
     * 5: Ngày Mất
     * 6: Giới Tính
     * 7: Quan Hệ
     * 8: Ngày An Táng
     * 9: Loại Mộ
     * 10: Trạng Thái
     * 11: Mô Tả Vị Trí
     * 12: Số Điện Thoại
     * 13: Email
     * 14: Địa Chỉ Liên Hệ
     * 15: Ghi Chú
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row): ?Grave
    {
        // Bỏ qua row trống - kiểm tra tất cả các cột
        $isEmpty = true;
        foreach ($row as $cell) {
            if (! empty($cell) && trim((string) $cell) !== '') {
                $isEmpty = false;
                break;
            }
        }

        if ($isEmpty) {
            return null;
        }

        // Kiểm tra các trường bắt buộc
        // Tên Nghĩa Trang (cột 0), Số Lăng Mộ (cột 1), Tên Chủ Lăng Mộ (cột 2)
        if (empty($row[0]) || empty(trim((string) ($row[1] ?? ''))) || empty(trim((string) ($row[2] ?? '')))) {
            return null;
        }

        // Tìm cemetery theo tên
        $cemetery = Cemetery::where('name', 'like', '%' . $row[0] . '%')->first();

        if (! $cemetery) {
            return null;
        }

        // Parse dates
        $burialDate = $this->parseDate($row[8] ?? null);
        $deceasedBirthDate = $this->parseDate($row[4] ?? null);
        $deceasedDeathDate = $this->parseDate($row[5] ?? null);

        // Build contact info
        $contactInfo = [];
        if (! empty($row[12])) {
            // Xử lý số điện thoại: đảm bảo giữ số 0 đằng trước
            $phone = $this->formatPhoneNumber($row[12]);
            $contactInfo['phone'] = $phone;
        }
        if (! empty($row[13])) {
            $contactInfo['email'] = trim($row[13]);
        }
        if (! empty($row[14])) {
            $contactInfo['address'] = trim($row[14]);
        }

        return new Grave([
            'cemetery_id' => $cemetery->id,
            'grave_number' => $row[1] ?? '',
            'owner_name' => $row[2] ?? '',
            'deceased_full_name' => $row[3] ?? null,
            'deceased_birth_date' => $deceasedBirthDate,
            'deceased_death_date' => $deceasedDeathDate,
            'deceased_gender' => $row[6] ?? 'nam',
            'deceased_relationship' => $row[7] ?? null,
            'burial_date' => $burialDate,
            'grave_type' => $row[9] ?? 'đất',
            'status' => $row[10] ?? 'còn_trống',
            'location_description' => $row[11] ?? null,
            'contact_info' => ! empty($contactInfo) ? $contactInfo : null,
            'notes' => $row[15] ?? null,
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
        if (is_numeric($phone) && ! str_starts_with($phone, '0')) {
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
            '6' => 'nullable|in:nam,nữ,khác', // Giới Tính
            '9' => 'nullable|in:đất,xi_măng,đá,gỗ,khác', // Loại Mộ
            '10' => 'nullable|in:còn_trống,đã_sử_dụng,bảo_trì,ngừng_sử_dụng', // Trạng Thái
            '12' => 'nullable|string|max:20', // Số Điện Thoại
            '13' => 'nullable|email|max:255', // Email
        ];
    }

    /**
     * Custom validation messages.
     */
    public function customValidationMessages(): array
    {
        return [
            '6.in' => 'Giới tính phải là: nam, nữ hoặc khác',
            '9.in' => 'Loại mộ phải là: đất, xi_măng, đá, gỗ hoặc khác',
            '10.in' => 'Trạng thái phải là: còn_trống, đã_sử_dụng, bảo_trì hoặc ngừng_sử_dụng',
            '12.string' => 'Số điện thoại phải là chuỗi ký tự',
            '12.max' => 'Số điện thoại không được vượt quá 20 ký tự',
            '13.email' => 'Email không đúng định dạng',
            '13.max' => 'Email không được vượt quá 255 ký tự',
        ];
    }
}
