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
     * Map dữ liệu từ Excel theo thứ tự cột (format liệt sĩ).
     *
     * Thứ tự cột:
     * 0: Tên Nghĩa Trang
     * 1: Họ và tên Liệt sỹ
     * 2: Năm sinh
     * 3: Cấp bậc, chức vụ, đơn vị
     * 4: Chức vụ
     * 5: Ngày tháng năm hy sinh
     * 6: Số bằng TQGC
     * 7: Số QĐ, ngày, tháng, năm cấp
     * 8: Quan hệ với liệt sỹ
     * 9: Thân nhân
     * 10: Mô tả vị trí
     * 11: Ghi chú
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row): ?Grave
    {
        // Bỏ qua row trống
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

        // Kiểm tra các trường bắt buộc: Nghĩa trang và Tên liệt sĩ
        if (empty($row[0]) || empty(trim((string) ($row[1] ?? '')))) {
            return null;
        }

        // Tìm cemetery theo tên
        $cemetery = Cemetery::where('name', 'like', '%' . $row[0] . '%')->first();

        if (! $cemetery) {
            return null;
        }

        // Parse dates
        $deathDate = $this->parseDate($row[5] ?? null);
        $decisionDate = $this->parseDecisionDate($row[7] ?? null);

        return new Grave([
            'cemetery_id' => $cemetery->id,
            'deceased_full_name' => $row[1] ?? '',
            'birth_year' => ! empty($row[2]) ? (int) $row[2] : null,
            'rank_and_unit' => $row[3] ?? null,
            'position' => $row[4] ?? null,
            'deceased_death_date' => $deathDate,
            'certificate_number' => $row[6] ?? null,
            'decision_number' => $this->extractDecisionNumber($row[7] ?? null),
            'decision_date' => $decisionDate,
            'deceased_relationship' => $row[8] ?? null,
            'next_of_kin' => $row[9] ?? null,
            'location_description' => $row[10] ?? null,
            'grave_type' => 'đá',
            'deceased_gender' => 'nam',
            'notes' => $row[11] ?? null,
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
            if ($date instanceof Carbon) {
                return $date->format('Y-m-d');
            }

            if (is_numeric($date)) {
                return Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d'))->format('Y-m-d');
            }

            return Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Extract số quyết định từ chuỗi "123/QĐ-BQP, 15/06/2009"
     */
    protected function extractDecisionNumber($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        $parts = explode(',', $value);

        return trim($parts[0]);
    }

    /**
     * Extract ngày cấp từ chuỗi "123/QĐ-BQP, 15/06/2009"
     */
    protected function parseDecisionDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        $parts = explode(',', $value);
        if (count($parts) < 2) {
            return null;
        }

        return $this->parseDate(trim($parts[1]));
    }

    /**
     * Validation rules theo index cột.
     */
    public function rules(): array
    {
        return [
            '2' => 'nullable|integer|min:1900|max:2100', // Năm sinh
        ];
    }

    /**
     * Custom validation messages.
     */
    public function customValidationMessages(): array
    {
        return [
            '2.integer' => 'Năm sinh phải là số',
            '2.min' => 'Năm sinh không hợp lệ',
            '2.max' => 'Năm sinh không hợp lệ',
        ];
    }
}
