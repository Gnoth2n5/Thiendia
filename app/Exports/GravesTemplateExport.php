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
        return [
            [
                'Nghĩa trang ABC',
                'Hoa Lư',
                'Tây Hoa Lư',
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
                'Ghi chú mẫu',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'Tên Nghĩa Trang',
            'Huyện',
            'Xã',
            'Tên Chủ Lăng Mộ',
            'Tên Người Quá Cố',
            'Ngày Sinh',
            'Ngày Mất',
            'Giới Tính',
            'Quan Hệ',
            'Ngày An táng',
            'Loại Mộ',
            'Trạng Thái',
            'Mô Tả Vị Trí',
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

                // Giới Tính (Cột H - index 7)
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

                // Loại Mộ (Cột K - index 10)
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

                // Trạng Thái (Cột L - index 11)
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
                foreach (range('A', 'N') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
