<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GravesTemplateExport implements FromArray, WithEvents, WithHeadings, WithStyles
{
    public function array(): array
    {
        // Lấy nghĩa trang đầu tiên từ database làm mẫu
        $firstCemetery = \App\Models\Cemetery::first();
        $commune = $firstCemetery ? $firstCemetery->commune : 'Xã ABC';
        $cemeteryName = $firstCemetery ? $firstCemetery->name : 'Nghĩa trang ABC';

        return [
            [
                $commune,
                $cemeteryName,
                'A001',
                'Nguyễn Văn A',
                'Nguyễn Thị B',
                '1950-01-15',
                '2023-05-20',
                'nữ',
                'Mẹ',
                '2023-06-01',
                'đá',
                'đã_sử_dụng',
                'Khu A, Lô 1',
                '0123456789',
                'email@example.com',
                'Địa chỉ liên hệ',
                'Ghi chú mẫu',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'Xã/Phường/Thị trấn',
            'Tên Nghĩa Trang',
            'Số Lăng Mộ',
            'Tên Chủ Lăng Mộ',
            'Tên Người Quá Cố',
            'Ngày Sinh',
            'Ngày Mất',
            'Giới Tính',
            'Quan Hệ',
            'Ngày An Táng',
            'Loại Mộ',
            'Trạng Thái',
            'Mô Tả Vị Trí',
            'Số Điện Thoại',
            'Email',
            'Địa Chỉ Liên Hệ',
            'Ghi Chú',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ];
    }

    /**
     * Thêm Data Validation (dropdown) cho các cột.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $workbook = $event->sheet->getDelegate()->getParent();

                // Lấy danh sách xã/phường và nghĩa trang theo từng xã/phường
                $communesWithCemeteries = \App\Models\Cemetery::select('commune')
                    ->groupBy('commune')
                    ->pluck('commune')
                    ->toArray();

                $cemeteries = \App\Models\Cemetery::all();

                if (!empty($cemeteries)) {
                    // Tạo sheet mới để chứa danh sách
                    $listSheet = $workbook->createSheet();
                    $listSheet->setTitle('Lists');

                    // Cột A: Danh sách xã/phường
                    $listSheet->setCellValue('A1', 'Danh sách Xã/Phường');
                    foreach ($communesWithCemeteries as $index => $commune) {
                        $listSheet->setCellValue('A' . ($index + 2), $commune);
                    }

                    // Từ cột B trở đi: Danh sách nghĩa trang của từng xã/phường
                    $colIndex = 2; // Bắt đầu từ cột B
                    $namedRanges = [];

                    foreach ($communesWithCemeteries as $commune) {
                        $cemeteriesInCommune = $cemeteries->where('commune', $commune)->pluck('name')->toArray();

                        if (!empty($cemeteriesInCommune)) {
                            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);

                            // Ghi header
                            $listSheet->setCellValue($columnLetter . '1', $commune);

                            // Ghi danh sách nghĩa trang
                            foreach ($cemeteriesInCommune as $idx => $cemeteryName) {
                                $listSheet->setCellValue($columnLetter . ($idx + 2), $cemeteryName);
                            }

                            // Tạo Named Range cho xã/phường này
                            $rangeName = preg_replace('/[^A-Za-z0-9_]/', '_', $commune); // Clean name for range
                            $rangeAddress = 'Lists!$' . $columnLetter . '$2:$' . $columnLetter . '$' . (count($cemeteriesInCommune) + 1);

                            try {
                                $workbook->addNamedRange(
                                    new \PhpOffice\PhpSpreadsheet\NamedRange(
                                        $rangeName,
                                        $listSheet,
                                        $rangeAddress
                                    )
                                );
                                $namedRanges[$commune] = $rangeName;
                            } catch (\Exception $e) {
                                // Skip if named range already exists
                            }

                            $colIndex++;
                        }
                    }

                    // Ẩn sheet Lists
                    $listSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);

                    // Cột A: Dropdown xã/phường
                    $communeValidation = $sheet->getCell('A2')->getDataValidation();
                    $communeValidation->setType(DataValidation::TYPE_LIST);
                    $communeValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $communeValidation->setAllowBlank(false);
                    $communeValidation->setShowInputMessage(true);
                    $communeValidation->setShowErrorMessage(true);
                    $communeValidation->setShowDropDown(true);
                    $communeValidation->setErrorTitle('Giá trị không hợp lệ');
                    $communeValidation->setError('Vui lòng chọn xã/phường từ danh sách');
                    $communeValidation->setPromptTitle('Xã/Phường/Thị trấn');
                    $communeValidation->setPrompt('Chọn xã/phường trước, sau đó chọn nghĩa trang');
                    $communeValidation->setFormula1('Lists!$A$2:$A$' . (count($communesWithCemeteries) + 1));

                    for ($i = 2; $i <= 1000; $i++) {
                        $sheet->getCell('A' . $i)->setDataValidation(clone $communeValidation);
                    }

                    // Cột B: Dependent Dropdown nghĩa trang (phụ thuộc vào cột A)
                    for ($i = 2; $i <= 1000; $i++) {
                        $cemeteryValidation = $sheet->getCell('B' . $i)->getDataValidation();
                        $cemeteryValidation->setType(DataValidation::TYPE_LIST);
                        $cemeteryValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                        $cemeteryValidation->setAllowBlank(false);
                        $cemeteryValidation->setShowInputMessage(true);
                        $cemeteryValidation->setShowErrorMessage(true);
                        $cemeteryValidation->setShowDropDown(true);
                        $cemeteryValidation->setErrorTitle('Giá trị không hợp lệ');
                        $cemeteryValidation->setError('Vui lòng chọn xã/phường trước');
                        $cemeteryValidation->setPromptTitle('Tên Nghĩa Trang');
                        $cemeteryValidation->setPrompt('Chọn nghĩa trang thuộc xã/phường đã chọn');

                        // INDIRECT formula: Lấy Named Range dựa trên giá trị cột A
                        $cemeteryValidation->setFormula1('INDIRECT(SUBSTITUTE(A' . $i . '," ","_"))');
                    }
                }

                // Giới Tính (Cột H - index 7, vì đã thêm cột Xã/Phường)
                $genderValidation = $sheet->getCell('H2')->getDataValidation();
                $genderValidation->setType(DataValidation::TYPE_LIST);
                $genderValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $genderValidation->setAllowBlank(true);
                $genderValidation->setShowInputMessage(true);
                $genderValidation->setShowErrorMessage(true);
                $genderValidation->setShowDropDown(true);
                $genderValidation->setErrorTitle('Giá trị không hợp lệ');
                $genderValidation->setError('Vui lòng chọn: nam, nữ hoặc khác');
                $genderValidation->setPromptTitle('Giới Tính');
                $genderValidation->setPrompt('Chọn giới tính từ danh sách');
                $genderValidation->setFormula1('"nam,nữ,khác"');

                // Apply cho 1000 dòng
                for ($i = 2; $i <= 1000; $i++) {
                    $sheet->getCell('H' . $i)->setDataValidation(clone $genderValidation);
                }

                // Loại Mộ (Cột K - index 10, vì đã thêm cột Xã/Phường)
                $graveTypeValidation = $sheet->getCell('K2')->getDataValidation();
                $graveTypeValidation->setType(DataValidation::TYPE_LIST);
                $graveTypeValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $graveTypeValidation->setAllowBlank(true);
                $graveTypeValidation->setShowInputMessage(true);
                $graveTypeValidation->setShowErrorMessage(true);
                $graveTypeValidation->setShowDropDown(true);
                $graveTypeValidation->setErrorTitle('Giá trị không hợp lệ');
                $graveTypeValidation->setError('Vui lòng chọn: đất, xi_măng, đá, gỗ hoặc khác');
                $graveTypeValidation->setPromptTitle('Loại Mộ');
                $graveTypeValidation->setPrompt('Chọn loại mộ từ danh sách');
                $graveTypeValidation->setFormula1('"đất,xi_măng,đá,gỗ,khác"');

                for ($i = 2; $i <= 1000; $i++) {
                    $sheet->getCell('K' . $i)->setDataValidation(clone $graveTypeValidation);
                }

                // Trạng Thái (Cột L - index 11, vì đã thêm cột Xã/Phường)
                $statusValidation = $sheet->getCell('L2')->getDataValidation();
                $statusValidation->setType(DataValidation::TYPE_LIST);
                $statusValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $statusValidation->setAllowBlank(true);
                $statusValidation->setShowInputMessage(true);
                $statusValidation->setShowErrorMessage(true);
                $statusValidation->setShowDropDown(true);
                $statusValidation->setErrorTitle('Giá trị không hợp lệ');
                $statusValidation->setError('Vui lòng chọn: còn_trống, đã_sử_dụng, bảo_trì hoặc ngừng_sử_dụng');
                $statusValidation->setPromptTitle('Trạng Thái');
                $statusValidation->setPrompt('Chọn trạng thái từ danh sách');
                $statusValidation->setFormula1('"còn_trống,đã_sử_dụng,bảo_trì,ngừng_sử_dụng"');

                for ($i = 2; $i <= 1000; $i++) {
                    $sheet->getCell('L' . $i)->setDataValidation(clone $statusValidation);
                }

                // Tự động điều chỉnh độ rộng cột
                foreach (range('A', 'Q') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Format cột Số Điện Thoại (Cột N) - hiển thị số 0 đằng trước
                $sheet->getStyle('N2:N1000')->getNumberFormat()
                    ->setFormatCode('@'); // Text format
    
                // Format cột Ngày Sinh (Cột F)
                $sheet->getStyle('F2:F1000')->getNumberFormat()
                    ->setFormatCode('dd/mm/yyyy');

                // Format cột Ngày Mất (Cột G)
                $sheet->getStyle('G2:G1000')->getNumberFormat()
                    ->setFormatCode('dd/mm/yyyy');

                // Format cột Ngày An Táng (Cột J)
                $sheet->getStyle('J2:J1000')->getNumberFormat()
                    ->setFormatCode('dd/mm/yyyy');

                // Đảm bảo sheet chính là sheet đầu tiên (active)
                $workbook->setActiveSheetIndex(0);
            },
        ];
    }
}
