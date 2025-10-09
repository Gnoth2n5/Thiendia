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
     * 1: Huyện
     * 2: Xã
     * 3: Tên Chủ Lăng Mộ
     * 4: Tên Người Quá Cố
     * 5: Ngày Sinh
     * 6: Ngày Mất
     * 7: Giới Tính
     * 8: Quan Hệ
     * 9: Ngày An táng
     * 10: Loại Mộ
     * 11: Trạng Thái
     * 12: Mô Tả Vị Trí
     * 13: Ghi Chú
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row): ?Grave
    {
        // Bỏ qua row trống
        if (empty($row[0]) && empty($row[3])) {
            return null;
        }

        // Tìm cemetery theo tên
        $cemetery = null;
        if (!empty($row[0])) {
            $cemetery = Cemetery::where('name', 'like', '%' . $row[0] . '%')->first();
        }

        if (!$cemetery) {
            return null;
        }

        // Parse dates
        $burialDate = $this->parseDate($row[9] ?? null);
        $deceasedBirthDate = $this->parseDate($row[5] ?? null);
        $deceasedDeathDate = $this->parseDate($row[6] ?? null);

        return new Grave([
            'cemetery_id' => $cemetery->id,
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
            'notes' => $row[13] ?? null,
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
     * Validation rules theo index cột.
     */
    public function rules(): array
    {
        return [
            '3' => 'required|string|max:255', // Tên Chủ Lăng Mộ
            '7' => 'nullable|in:nam,nữ,khác', // Giới Tính
            '10' => 'nullable|in:đất,xi_măng,đá,gỗ,khác', // Loại Mộ
            '11' => 'nullable|in:còn_trống,đã_sử_dụng,bảo_trì,ngừng_sử_dụng', // Trạng Thái
        ];
    }

    /**
     * Custom validation messages.
     */
    public function customValidationMessages(): array
    {
        return [
            '3.required' => 'Tên chủ lăng mộ là bắt buộc (cột 4)',
            '3.string' => 'Tên chủ lăng mộ phải là chuỗi ký tự',
            '3.max' => 'Tên chủ lăng mộ không được vượt quá 255 ký tự',
            '7.in' => 'Giới tính phải là: nam, nữ hoặc khác',
            '10.in' => 'Loại mộ phải là: đất, xi_măng, đá, gỗ hoặc khác',
            '11.in' => 'Trạng thái phải là: còn_trống, đã_sử_dụng, bảo_trì hoặc ngừng_sử_dụng',
        ];
    }
}
