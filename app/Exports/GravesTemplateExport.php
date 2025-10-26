<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GravesTemplateExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    /**
     * Return headers cho template import liệt sĩ.
     */
    public function headings(): array
    {
        return [
            'Tên Nghĩa Trang',
            'Họ và tên Liệt sỹ',
            'Năm sinh',
            'Cấp bậc, chức vụ, đơn vị',
            'Chức vụ',
            'Ngày tháng năm hy sinh',
            'Số bằng TQGC',
            'Số QĐ, ngày, tháng, năm cấp',
            'Quan hệ với liệt sỹ',
            'Thân nhân',
            'Mộ tưởng niệm tại nghĩa trang',
            'Ghi chú',
        ];
    }

    /**
     * Return data mẫu.
     */
    public function array(): array
    {
        return [
            [
                'Nghĩa trang Xã Bắc Lý',
                'Nguyễn Văn An',
                '1950',
                'Trung sĩ, Tiểu đoàn 5, Trung đoàn 88',
                'Tiểu đội trưởng',
                '15/04/1972',
                'TQGC-1234/1972',
                '123/QĐ-BQP, 20/05/1972',
                'Con trai',
                'Nguyễn Thị Mai',
                'Khu A, hàng 3, mộ 15',
                'Hy sinh tại chiến trường Quảng Trị',
            ],
            [
                'Nghĩa trang Xã Bắc Lý',
                'Trần Văn Bình',
                '1948',
                'Thượng sĩ, Đại đội 3, Tiểu đoàn 7',
                'Chiến sĩ',
                '30/03/1975',
                'TQGC-5678/1975',
                '456/QĐ-BQP, 01/05/1975',
                'Con gái',
                'Trần Thị Lan',
                'Khu B, hàng 1, mộ 5',
                '',
            ],
        ];
    }

    /**
     * Apply styles to worksheet.
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}
