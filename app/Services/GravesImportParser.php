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

            // Đọc từ cột 2 (bỏ qua cột 1 là STT), tối đa 12 cột dữ liệu (index 0-11)
            // Excel column: 1=STT (bỏ qua), 2-13 = dữ liệu
            for ($excelCol = 2; $excelCol <= 13; $excelCol++) {
                $dataIndex = $excelCol - 2; // Map Excel column 2->0, 3->1, 4->2, etc.
                $cell = $worksheet->getCellByColumnAndRow($excelCol, $row);
                $rawValue = $cell->getValue();

                // Nếu là cột ngày tháng (Ngày sinh, Ngày nhập ngũ, Ngày hy sinh)
                // Mapping: Excel col 4->data[2], col 5->data[3], col 6->data[4]
                if (in_array($dataIndex, [2, 3, 4]) && $rawValue !== null) {
                    // Nếu là số (Excel date serial number), convert sang date
                    if (is_numeric($rawValue)) {
                        try {
                            $dateTime = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $rawValue);
                            $data[$dataIndex] = $dateTime->format('d/m/Y');
                        } catch (\Exception $e) {
                            // Nếu không convert được, lấy formatted value
                            $data[$dataIndex] = $cell->getFormattedValue() ?: $rawValue;
                        }
                    } else {
                        // Nếu là string hoặc DateTime object, lấy formatted value hoặc raw value
                        if ($rawValue instanceof \DateTime || $rawValue instanceof \DateTimeInterface) {
                            $data[$dataIndex] = $rawValue->format('d/m/Y');
                        } else {
                            $formatted = $cell->getFormattedValue();
                            $data[$dataIndex] = ! empty($formatted) ? $formatted : (string) $rawValue;
                        }
                    }
                } else {
                    // Các cột khác: lấy formatted value nếu có, nếu không thì raw value
                    $formatted = $cell->getFormattedValue();
                    $data[$dataIndex] = ! empty($formatted) ? $formatted : $rawValue;
                }
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

        // 1: Nguyên Quán
        $validatedData['hometown'] = ! empty($data[1]) ? trim((string) $data[1]) : null;

        // 2: Ngày tháng năm sinh
        $birthDate = $this->parseDate($data[2] ?? null);
        if (! empty($data[2]) && $birthDate === null) {
            $errors[] = 'Ngày sinh không đúng định dạng';
        }
        $validatedData['deceased_birth_date'] = $birthDate;

        // 3: Ngày tháng năm nhập ngũ
        $enlistmentDate = $this->parseDate($data[3] ?? null);
        if (! empty($data[3]) && $enlistmentDate === null) {
            $errors[] = 'Ngày nhập ngũ không đúng định dạng';
        }
        $validatedData['enlistment_date'] = $enlistmentDate;

        // 4: Ngày tháng năm hy sinh
        $deathDate = $this->parseDate($data[4] ?? null);
        if (! empty($data[4]) && $deathDate === null) {
            $errors[] = 'Ngày hy sinh không đúng định dạng';
        }
        $validatedData['deceased_death_date'] = $deathDate;

        // 5: Cấp bậc
        $validatedData['rank'] = ! empty($data[5]) ? trim((string) $data[5]) : null;

        // 6: Chức vụ
        $validatedData['position'] = ! empty($data[6]) ? trim((string) $data[6]) : null;

        // 7: Đơn vị
        $validatedData['unit'] = ! empty($data[7]) ? trim((string) $data[7]) : null;

        // 8: Ghi chú
        $validatedData['notes'] = ! empty($data[8]) ? trim((string) $data[8]) : null;

        // 9: Lô - tìm plot_id
        $plotCode = ! empty($data[9]) ? trim((string) $data[9]) : null;
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

        // 10: Ảnh liệt sỹ - Tên file hoặc path hoặc URL
        $deceasedPhoto = ! empty($data[10]) ? trim((string) $data[10]) : null;
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

        // 11: Ảnh mộ - Nhiều tên file/path/URLs cách nhau bằng dấu phẩy
        $gravePhotos = [];
        if (! empty($data[11])) {
            $photoItems = array_map('trim', explode(',', (string) $data[11]));
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
            // Xử lý DateTime object
            if ($date instanceof \DateTime) {
                return $date->format('Y-m-d');
            }

            // Xử lý DateTimeInterface (Carbon, etc.)
            if ($date instanceof \DateTimeInterface) {
                return $date->format('Y-m-d');
            }

            // Nếu là số (Excel date serial number)
            if (is_numeric($date)) {
                try {
                    $dateTime = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $date);

                    return $dateTime->format('Y-m-d');
                } catch (\Exception $e) {
                    // Nếu không phải Excel serial number, thử parse như timestamp
                    if ($date > 1000000000) {
                        return Carbon::createFromTimestamp((int) $date)->format('Y-m-d');
                    }
                }
            }

            $dateString = trim((string) $date);

            // Thử parse với format chỉ có năm (ví dụ: 1952, 1954)
            if (preg_match('/^(\d{4})$/', $dateString, $matches)) {
                $year = (int) $matches[1];
                if ($year >= 1900 && $year <= 2100) {
                    // Lưu ngày 01/01/năm
                    return Carbon::createFromDate($year, 1, 1)->format('Y-m-d');
                }
            }

            // Thử parse với format năm-tháng (ví dụ: 1952-02, 02/1952, 1952/02)
            if (preg_match('/^(\d{4})[-\/](\d{1,2})$/', $dateString, $matches)) {
                $year = (int) $matches[1];
                $month = (int) $matches[2];
                if ($month >= 1 && $month <= 12 && $year >= 1900 && $year <= 2100) {
                    // Lưu ngày 01/tháng/năm
                    return Carbon::createFromDate($year, $month, 1)->format('Y-m-d');
                }
            }

            // Thử parse với format tháng/năm (ví dụ: 02/1952, 2/1952)
            if (preg_match('/^(\d{1,2})[-\/](\d{4})$/', $dateString, $matches)) {
                $month = (int) $matches[1];
                $year = (int) $matches[2];
                if ($month >= 1 && $month <= 12 && $year >= 1900 && $year <= 2100) {
                    // Lưu ngày 01/tháng/năm
                    return Carbon::createFromDate($year, $month, 1)->format('Y-m-d');
                }
            }

            // Thử parse với format dd/mm/yyyy trước (format phổ biến ở Việt Nam)
            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $dateString, $matches)) {
                $day = (int) $matches[1];
                $month = (int) $matches[2];
                $year = (int) $matches[3];

                // Validate ngày tháng hợp lệ
                if ($day >= 1 && $day <= 31 && $month >= 1 && $month <= 12 && $year >= 1900 && $year <= 2100) {
                    try {
                        return Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Nếu không tạo được (ví dụ: 31/02/1952), thử parse tự động
                    }
                }
            }

            // Thử parse với format yyyy-mm-dd
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $dateString, $matches)) {
                $year = (int) $matches[1];
                $month = (int) $matches[2];
                $day = (int) $matches[3];

                if ($day >= 1 && $day <= 31 && $month >= 1 && $month <= 12 && $year >= 1900 && $year <= 2100) {
                    try {
                        return Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Nếu không tạo được, thử parse tự động
                    }
                }
            }

            // Thử parse với format dd-mm-yyyy
            if (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/', $dateString, $matches)) {
                $day = (int) $matches[1];
                $month = (int) $matches[2];
                $year = (int) $matches[3];

                if ($day >= 1 && $day <= 31 && $month >= 1 && $month <= 12 && $year >= 1900 && $year <= 2100) {
                    try {
                        return Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Nếu không tạo được, thử parse tự động
                    }
                }
            }

            // Fallback: dùng Carbon::parse() để tự động detect format
            // Carbon có thể parse nhiều format khác nhau
            $parsed = Carbon::parse($dateString);
            if ($parsed && $parsed->year >= 1900 && $parsed->year <= 2100) {
                return $parsed->format('Y-m-d');
            }

            return null;
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
