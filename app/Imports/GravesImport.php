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
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GravesImport implements SkipsOnError, SkipsOnFailure, ToModel, WithHeadingRow, WithValidation
{
    use SkipsErrors, SkipsFailures;

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row): ?Grave
    {
        // Tìm cemetery theo tên hoặc ID
        $cemetery = null;
        if (!empty($row['cemetery_id'])) {
            $cemetery = Cemetery::find($row['cemetery_id']);
        } elseif (!empty($row['cemetery_name'])) {
            $cemetery = Cemetery::where('name', 'like', '%' . $row['cemetery_name'] . '%')->first();
        }

        if (!$cemetery) {
            return null;
        }

        // Parse dates
        $burialDate = $this->parseDate($row['burial_date'] ?? null);
        $deceasedBirthDate = $this->parseDate($row['deceased_birth_date'] ?? null);
        $deceasedDeathDate = $this->parseDate($row['deceased_death_date'] ?? null);

        return new Grave([
            'cemetery_id' => $cemetery->id,
            'district' => $row['district'] ?? null,
            'commune' => $row['commune'] ?? null,
            'grave_number' => $row['grave_number'] ?? Grave::generateGraveNumber($cemetery->id),
            'owner_name' => $row['owner_name'] ?? '',
            'deceased_full_name' => $row['deceased_full_name'] ?? null,
            'deceased_birth_date' => $deceasedBirthDate,
            'deceased_death_date' => $deceasedDeathDate,
            'deceased_gender' => $row['deceased_gender'] ?? 'nam',
            'deceased_relationship' => $row['deceased_relationship'] ?? null,
            'burial_date' => $burialDate,
            'grave_type' => $row['grave_type'] ?? 'đất',
            'status' => $row['status'] ?? 'còn_trống',
            'location_description' => $row['location_description'] ?? null,
            'notes' => $row['notes'] ?? null,
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
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'owner_name' => 'required|string|max:255',
            'grave_type' => 'nullable|in:đất,xi_măng,đá,gỗ,khác',
            'status' => 'nullable|in:còn_trống,đã_sử_dụng,bảo_trì,ngừng_sử_dụng',
            'deceased_gender' => 'nullable|in:nam,nữ,khác',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages(): array
    {
        return [
            'owner_name.required' => 'Tên chủ lăng mộ là bắt buộc',
            'owner_name.string' => 'Tên chủ lăng mộ phải là chuỗi ký tự',
            'owner_name.max' => 'Tên chủ lăng mộ không được vượt quá 255 ký tự',
        ];
    }
}

