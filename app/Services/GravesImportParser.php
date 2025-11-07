<?php

namespace App\Services;

use App\Models\Cemetery;
use App\Models\CemeteryPlot;
use App\Models\Grave;
use App\Models\MartyrPhoto;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GravesImportParser
{
    protected string $filePath;

    protected int $cemeteryId;

    protected ?string $commune = null;

    protected array $rows = [];

    protected bool $hasErrors = false;

    protected int $successCount = 0;

    protected int $errorCount = 0;

    public function __construct(string $filePath, int $cemeteryId)
    {
        $this->filePath = $filePath;
        $this->cemeteryId = $cemeteryId;

        // Lấy commune từ cemetery
        $cemetery = Cemetery::find($cemeteryId);
        if ($cemetery) {
            $this->commune = $cemetery->commune;
        }
    }

    /**
     * Parse và validate file Excel
     */
    public function parse(): array
    {
        $spreadsheet = IOFactory::load($this->filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        $this->rows = [];
        $this->hasErrors = false;

        // Bắt đầu từ row 2 (bỏ qua header)
        for ($row = 2; $row <= $highestRow; $row++) {
            $data = [];

            // Đọc 13 cột (index 0-12)
            for ($col = 0; $col <= 12; $col++) {
                $cellValue = $worksheet->getCellByColumnAndRow($col + 1, $row)->getValue();
                $data[$col] = $cellValue;
            }

            // Bỏ qua row trống
            if ($this->isEmptyRow($data)) {
                continue;
            }

            $parsedRow = $this->parseRow($row, $data);
            $this->rows[] = $parsedRow;

            if (! $parsedRow['is_valid']) {
                $this->hasErrors = true;
                $this->errorCount++;
            } else {
                $this->successCount++;
            }
        }

        return $this->rows;
    }

    /**
     * Parse và validate một row
     */
    protected function parseRow(int $rowNumber, array $data): array
    {
        $errors = [];
        $validatedData = [];

        // 0: Họ và tên Liệt sỹ - bắt buộc
        $fullName = trim((string) ($data[0] ?? ''));
        if (empty($fullName)) {
            $errors[] = 'Họ tên là bắt buộc';
        } elseif (mb_strlen($fullName) > 255) {
            $errors[] = 'Họ tên không được vượt quá 255 ký tự';
        }
        $validatedData['deceased_full_name'] = $fullName;

        // 1: Năm sinh
        $birthYear = $data[1] ?? null;
        if (! empty($birthYear)) {
            $birthYear = (int) $birthYear;
            if ($birthYear < 1900 || $birthYear > 2100) {
                $errors[] = 'Năm sinh không hợp lệ (1900-2100)';
            }
            $validatedData['birth_year'] = $birthYear;
        } else {
            $validatedData['birth_year'] = null;
        }

        // 2: Cấp bậc, chức vụ, đơn vị
        $validatedData['rank_and_unit'] = ! empty($data[2]) ? trim((string) $data[2]) : null;

        // 3: Chức vụ
        $validatedData['position'] = ! empty($data[3]) ? trim((string) $data[3]) : null;

        // 4: Ngày tháng năm hy sinh
        $deathDate = $this->parseDate($data[4] ?? null);
        if (! empty($data[4]) && $deathDate === null) {
            $errors[] = 'Ngày hy sinh không đúng định dạng';
        }
        $validatedData['deceased_death_date'] = $deathDate;

        // 5: Số bằng TQGC
        $validatedData['certificate_number'] = ! empty($data[5]) ? trim((string) $data[5]) : null;

        // 6: Số QĐ, ngày, tháng, năm cấp
        $decisionData = $this->parseDecisionField($data[6] ?? null);
        $validatedData['decision_number'] = $decisionData['number'];
        $validatedData['decision_date'] = $decisionData['date'];

        // 7: Quan hệ với liệt sỹ
        $validatedData['deceased_relationship'] = ! empty($data[7]) ? trim((string) $data[7]) : null;

        // 8: Thân nhân
        $validatedData['next_of_kin'] = ! empty($data[8]) ? trim((string) $data[8]) : null;

        // 9: Ghi chú
        $validatedData['notes'] = ! empty($data[9]) ? trim((string) $data[9]) : null;

        // 10: Lô - tìm plot_id
        $plotCode = ! empty($data[10]) ? trim((string) $data[10]) : null;
        $plotId = null;
        if ($plotCode) {
            $plot = CemeteryPlot::where('cemetery_id', $this->cemeteryId)
                ->where('plot_code', $plotCode)
                ->first();

            if ($plot) {
                if ($plot->status === 'occupied') {
                    $errors[] = "Lô {$plotCode} đã được sử dụng";
                } else {
                    $plotId = $plot->id;
                }
            } else {
                $errors[] = "Không tìm thấy lô {$plotCode}";
            }
        }
        $validatedData['plot_id'] = $plotId;

        // 11: Ảnh liệt sỹ - Tên file hoặc path hoặc URL
        $deceasedPhoto = ! empty($data[11]) ? trim((string) $data[11]) : null;
        if ($deceasedPhoto) {
            if ($this->isValidUrl($deceasedPhoto)) {
                // URL đầy đủ - giữ nguyên
                $validatedData['deceased_photo'] = $deceasedPhoto;
            } elseif (str_contains($deceasedPhoto, '/')) {
                // Đã có path đầy đủ (ví dụ: martyr-photos/ly-nhan/file.jpg) - giữ nguyên
                $validatedData['deceased_photo'] = $deceasedPhoto;
            } else {
                // Chỉ có tên file - build path theo commune
                if ($this->commune) {
                    $storagePath = MartyrPhoto::generateStoragePath($this->commune);
                    $validatedData['deceased_photo'] = "{$storagePath}/{$deceasedPhoto}";
                } else {
                    $validatedData['deceased_photo'] = "martyr-photos/{$deceasedPhoto}";
                }
            }
        } else {
            $validatedData['deceased_photo'] = null;
        }

        // 12: Ảnh mộ - Nhiều tên file/path/URLs cách nhau bằng dấu phẩy
        $gravePhotos = [];
        if (! empty($data[12])) {
            $photoItems = array_map('trim', explode(',', (string) $data[12]));
            foreach ($photoItems as $item) {
                if (! empty($item)) {
                    if ($this->isValidUrl($item)) {
                        // URL đầy đủ - giữ nguyên
                        $gravePhotos[] = $item;
                    } elseif (str_contains($item, '/')) {
                        // Đã có path đầy đủ (ví dụ: martyr-photos/ly-nhan/file.jpg) - giữ nguyên
                        $gravePhotos[] = $item;
                    } else {
                        // Chỉ có tên file - build path theo commune
                        if ($this->commune) {
                            $storagePath = MartyrPhoto::generateStoragePath($this->commune);
                            $gravePhotos[] = "{$storagePath}/{$item}";
                        } else {
                            $gravePhotos[] = "martyr-photos/{$item}";
                        }
                    }
                }
            }
        }
        $validatedData['grave_photos'] = $gravePhotos;

        // Thêm các trường mặc định
        $validatedData['cemetery_id'] = $this->cemeteryId;
        $validatedData['grave_type'] = 'đá';
        $validatedData['deceased_gender'] = 'nam';

        return [
            'row_number' => $rowNumber,
            'data' => $data,
            'validated_data' => $validatedData,
            'errors' => $errors,
            'is_valid' => empty($errors),
        ];
    }

    /**
     * Lưu tất cả rows vào database
     */
    public function save(): array
    {
        $saved = 0;
        $failed = 0;

        foreach ($this->rows as $row) {
            if (! $row['is_valid']) {
                $failed++;

                continue;
            }

            try {
                Grave::create($row['validated_data']);
                $saved++;
            } catch (\Exception $e) {
                $failed++;
            }
        }

        return [
            'saved' => $saved,
            'failed' => $failed,
        ];
    }

    /**
     * Kiểm tra row có trống không
     */
    protected function isEmptyRow(array $data): bool
    {
        foreach ($data as $cell) {
            if (! empty($cell) && trim((string) $cell) !== '') {
                return false;
            }
        }

        return true;
    }

    /**
     * Parse date từ nhiều format khác nhau
     */
    protected function parseDate($date): ?string
    {
        if (empty($date)) {
            return null;
        }

        try {
            if ($date instanceof \DateTime) {
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
     * Parse trường quyết định: "123/QĐ-BQP, 15/06/2009"
     */
    protected function parseDecisionField($value): array
    {
        if (empty($value)) {
            return ['number' => null, 'date' => null];
        }

        $parts = explode(',', (string) $value);
        $number = trim($parts[0]);
        $date = null;

        if (count($parts) >= 2) {
            $date = $this->parseDate(trim($parts[1]));
        }

        return [
            'number' => $number ?: null,
            'date' => $date,
        ];
    }

    /**
     * Validate URL
     */
    protected function isValidUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Getters
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    public function hasErrors(): bool
    {
        return $this->hasErrors;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function getErrorCount(): int
    {
        return $this->errorCount;
    }
}
