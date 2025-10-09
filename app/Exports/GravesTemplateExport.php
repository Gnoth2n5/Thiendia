<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GravesTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [
                '1',
                'Nghĩa trang ABC',
                'Hoa Lư',
                'Tây Hoa Lư',
                'MO-001',
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
            'cemetery_id',
            'cemetery_name',
            'district',
            'commune',
            'grave_number',
            'owner_name',
            'deceased_full_name',
            'deceased_birth_date',
            'deceased_death_date',
            'deceased_gender',
            'deceased_relationship',
            'burial_date',
            'grave_type',
            'status',
            'location_description',
            'notes',
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
}

