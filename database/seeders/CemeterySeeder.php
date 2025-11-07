<?php

namespace Database\Seeders;

use App\Models\Cemetery;
use Illuminate\Database\Seeder;

class CemeterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo nghĩa trang cho xã Lý Nhân
        Cemetery::create([
            'name' => 'Nghĩa trang Xã Lý Nhân',
            'commune' => 'Lý Nhân',
            'address' => 'Khu vực trung tâm, Xã Lý Nhân, Huyện Vụ Bản, Tỉnh Nam Định',
            'description' => 'Nghĩa trang liệt sỹ xã Lý Nhân, nơi an nghỉ của các anh hùng liệt sĩ đã hy sinh vì Tổ quốc.',
        ]);

        $this->command->info('Created cemetery: Nghĩa trang Xã Lý Nhân');
    }
}
