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
        // Lấy tên nghĩa trang đầu tiên từ database làm mẫu
        $firstCemetery = \App\Models\Cemetery::first();
        $cemeteryName = $firstCemetery ? $firstCemetery->name : 'Nghĩa trang ABC';

        return [
            [
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

                // Tạo sheet ẩn cho danh sách nghĩa trang
                $cemeteries = \App\Models\Cemetery::pluck('name')->toArray();

                if (! empty($cemeteries)) {
                    // Tạo sheet mới để chứa danh sách nghĩa trang
                    $listSheet = $workbook->createSheet();
                    $listSheet->setTitle('Lists');

                    // Ghi danh sách nghĩa trang vào sheet Lists
                    foreach ($cemeteries as $index => $cemetery) {
                        $listSheet->setCellValue('A'.($index + 1), $cemetery);
                    }

                    // Ẩn sheet Lists
                    $listSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);

                    // Tạo validation cho cột A
                    $cemeteryValidation = $sheet->getCell('A2')->getDataValidation();
                    $cemeteryValidation->setType(DataValidation::TYPE_LIST);
                    $cemeteryValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $cemeteryValidation->setAllowBlank(false);
                    $cemeteryValidation->setShowInputMessage(true);
                    $cemeteryValidation->setShowErrorMessage(true);
                    $cemeteryValidation->setShowDropDown(true);
                    $cemeteryValidation->setErrorTitle('Giá trị không hợp lệ');
                    $cemeteryValidation->setError('Vui lòng chọn nghĩa trang từ danh sách');
                    $cemeteryValidation->setPromptTitle('Tên Nghĩa Trang');
                    $cemeteryValidation->setPrompt('Chọn nghĩa trang từ danh sách');
                    $cemeteryValidation->setFormula1('Lists!$A$1:$A$'.count($cemeteries));

                    // Apply cho 1000 dòng
                    for ($i = 2; $i <= 1000; $i++) {
                        $sheet->getCell('A'.$i)->setDataValidation(clone $cemeteryValidation);
                    }
                }

                // Giới Tính (Cột G - index 6)
                $genderValidation = $sheet->getCell('G2')->getDataValidation();
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
                    $sheet->getCell('G'.$i)->setDataValidation(clone $genderValidation);
                }

                // Loại Mộ (Cột J - index 9)
                $graveTypeValidation = $sheet->getCell('J2')->getDataValidation();
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
                    $sheet->getCell('J'.$i)->setDataValidation(clone $graveTypeValidation);
                }

                // Trạng Thái (Cột K - index 10)
                $statusValidation = $sheet->getCell('K2')->getDataValidation();
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
                    $sheet->getCell('K'.$i)->setDataValidation(clone $statusValidation);
                }

                // Tự động điều chỉnh độ rộng cột
                foreach (range('A', 'P') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Format cột Số Điện Thoại (Cột M) - hiển thị số 0 đằng trước
                $sheet->getStyle('M2:M1000')->getNumberFormat()
                    ->setFormatCode('@'); // Text format

                // Format cột Ngày Sinh (Cột E)
                $sheet->getStyle('E2:E1000')->getNumberFormat()
                    ->setFormatCode('dd/mm/yyyy');

                // Format cột Ngày Mất (Cột F)
                $sheet->getStyle('F2:F1000')->getNumberFormat()
                    ->setFormatCode('dd/mm/yyyy');

                // Format cột Ngày An Táng (Cột I)
                $sheet->getStyle('I2:I1000')->getNumberFormat()
                    ->setFormatCode('dd/mm/yyyy');

                // Đảm bảo sheet chính là sheet đầu tiên (active)
                $workbook->setActiveSheetIndex(0);
            },
        ];
    }
}
