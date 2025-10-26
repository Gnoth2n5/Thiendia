<?php

namespace Database\Seeders;

use App\Models\Cemetery;
use App\Models\Grave;
use Illuminate\Database\Seeder;

class GraveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cemeteries = Cemetery::all();

        // Tên liệt sĩ mẫu
        $martyrNames = [
            'Nguyễn Văn An',
            'Trần Văn Bình',
            'Lê Văn Cường',
            'Phạm Văn Dũng',
            'Hoàng Văn Em',
            'Vũ Văn Phong',
            'Đặng Văn Giang',
            'Bùi Văn Hải',
            'Đỗ Văn Hùng',
            'Ngô Văn Khánh',
            'Dương Văn Long',
            'Lý Văn Minh',
            'Võ Văn Nam',
            'Phan Văn Oanh',
            'Trịnh Văn Phúc',
            'Đinh Văn Quang',
            'Lưu Văn Sơn',
            'Cao Văn Tài',
            'Tôn Văn Uy',
            'Hồ Văn Việt',
            'Nguyễn Thị Hoa',
            'Trần Thị Lan',
            'Lê Thị Mai',
            'Phạm Thị Nga',
        ];

        // Cấp bậc
        $ranks = [
            'Thượng sĩ',
            'Trung sĩ',
            'Hạ sĩ',
            'Binh nhất',
            'Binh nhì',
            'Thiếu úy',
            'Trung úy',
            'Đại úy',
        ];

        // Đơn vị
        $units = [
            'Tiểu đoàn 1, Trung đoàn 88',
            'Tiểu đoàn 5, Trung đoàn 95',
            'Đại đội 3, Tiểu đoàn 7',
            'Trung đoàn 209, Sư đoàn 312',
            'Trung đoàn 174, Sư đoàn 316',
            'Đại đội Đặc công, Quân khu 3',
        ];

        // Chức vụ
        $positions = [
            'Tiểu đội trưởng',
            'Chiến sĩ',
            'Xạ thủ',
            'Trung đội trưởng',
            'Đại đội phó',
            'Liên lạc viên',
            'Y tá quân y',
            'Cán bộ chính trị',
        ];

        // Quan hệ
        $relationships = ['Con trai', 'Con gái', 'Cháu', 'Em', 'Anh'];

        foreach ($cemeteries as $cemetery) {
            // Tạo 30-50 lăng mộ liệt sĩ cho mỗi nghĩa trang
            $graveCount = rand(30, 50);

            for ($i = 1; $i <= $graveCount; $i++) {
                $martyrName = $martyrNames[array_rand($martyrNames)];
                $birthYear = rand(1920, 1975);
                $deathYear = max($birthYear + 17, rand(1945, 1975)); // Ít nhất 17 tuổi khi hy sinh

                Grave::create([
                    'cemetery_id' => $cemetery->id,
                    'caretaker_name' => fake()->name(),

                    // Thông tin liệt sĩ
                    'deceased_full_name' => $martyrName,
                    'birth_year' => $birthYear,
                    'rank_and_unit' => $ranks[array_rand($ranks)].', '.$units[array_rand($units)],
                    'position' => $positions[array_rand($positions)],
                    'deceased_birth_date' => now()->setYear($birthYear)->setMonth(rand(1, 12))->setDay(rand(1, 28)),
                    'deceased_death_date' => now()->setYear($deathYear)->setMonth(rand(1, 12))->setDay(rand(1, 28)),
                    'deceased_gender' => rand(0, 10) > 2 ? 'nam' : 'nữ',

                    // Giấy tờ
                    'certificate_number' => 'TQGC-'.rand(1000, 9999).'/'.rand(1945, 1975),
                    'decision_number' => rand(100, 999).'/QĐ-BQP',
                    'decision_date' => now()->setYear(rand(1975, 2025))->setMonth(rand(1, 12))->setDay(rand(1, 28)),

                    // Thân nhân
                    'deceased_relationship' => $relationships[array_rand($relationships)],
                    'next_of_kin' => fake()->name(),

                    // Thông tin mộ
                    'burial_date' => now()->setYear($deathYear)->setMonth(rand(1, 12))->setDay(rand(1, 28)),
                    'grave_type' => 'đá',
                    'location_description' => 'Khu '.chr(65 + rand(0, 5)).', hàng '.rand(1, 20).', mộ '.rand(1, 30),
                    'notes' => fake()->optional(0.3)->sentence(),
                ]);
            }
        }
    }
}
