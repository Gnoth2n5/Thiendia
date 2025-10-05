<?php

namespace Database\Seeders;

use App\Models\Cemetery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CemeterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cemeteries = [
            [
                'name' => 'Nghĩa trang Bình Hưng Hòa',
                'address' => 'Phường Bình Hưng Hòa, Quận Bình Tân, TP.HCM',
                'description' => 'Nghĩa trang công cộng lớn nhất tại TP.HCM, được quản lý bởi Sở Xây dựng TP.HCM.',
            ],
            [
                'name' => 'Nghĩa trang Đa Phước',
                'address' => 'Xã Đa Phước, Huyện Bình Chánh, TP.HCM',
                'description' => 'Nghĩa trang hiện đại với hệ thống quản lý tiên tiến.',
            ],
            [
                'name' => 'Nghĩa trang Phước Lộc Thọ',
                'address' => 'Phường Phước Lộc Thọ, Quận 9, TP.HCM',
                'description' => 'Nghĩa trang tư nhân với dịch vụ chăm sóc mộ phần chuyên nghiệp.',
            ],
            [
                'name' => 'Nghĩa trang Gò Dưa',
                'address' => 'Phường Hiệp Bình Chánh, Quận Thủ Đức, TP.HCM',
                'description' => 'Nghĩa trang lâu đời với nhiều mộ phần có giá trị lịch sử.',
            ],
            [
                'name' => 'Nghĩa trang Long Thạnh Mỹ',
                'address' => 'Phường Long Thạnh Mỹ, Quận 9, TP.HCM',
                'description' => 'Nghĩa trang mới với thiết kế hiện đại và thân thiện môi trường.',
            ],
        ];

        foreach ($cemeteries as $cemetery) {
            Cemetery::create($cemetery);
        }
    }
}
