<?php

namespace Database\Seeders;

use App\Http\Controllers\HomeController;
use App\Models\Cemetery;
use Illuminate\Database\Seeder;

class CemeterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách xã/phường từ API
        $controller = new HomeController;
        $wards = $controller->fetchAndCacheWards();

        // Tạo nghĩa trang mẫu cho 15 xã/phường đầu tiên
        $sampleWards = array_slice($wards, 0, 15);

        foreach ($sampleWards as $index => $ward) {
            $wardName = $ward['name'];
            $wardType = $ward['type'];

            Cemetery::create([
                'name' => "Nghĩa trang {$wardType} {$wardName}",
                'commune' => $wardName,
                'address' => "Khu vực trung tâm, {$wardType} {$wardName}, Tỉnh Ninh Bình",
                'description' => "Nghĩa trang công cộng của {$wardType} {$wardName}, được quản lý bởi UBND {$wardType}.",
            ]);
        }

        // Thêm một số nghĩa trang lớn với nhiều thông tin
        Cemetery::create([
            'name' => 'Nghĩa trang Liệt sĩ Tỉnh Ninh Bình',
            'commune' => 'Hoa Lư',
            'address' => 'Đường Trần Hưng Đạo, Phường Hoa Lư, Thành phố Ninh Bình',
            'description' => 'Nghĩa trang liệt sĩ cấp tỉnh, nơi an nghỉ của các anh hùng liệt sĩ đã hy sinh vì Tổ quốc.',
        ]);
    }
}
