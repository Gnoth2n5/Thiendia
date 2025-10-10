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

        // Vietnamese names for more realistic data
        $vietnameseNames = [
            'Nguyễn Văn An',
            'Trần Thị Bình',
            'Lê Văn Cường',
            'Phạm Thị Dung',
            'Hoàng Văn Em',
            'Vũ Thị Phương',
            'Đặng Văn Giang',
            'Bùi Thị Hoa',
            'Đỗ Văn Hùng',
            'Ngô Thị Lan',
            'Dương Văn Minh',
            'Lý Thị Nga',
            'Võ Văn Oanh',
            'Phan Thị Quỳnh',
            'Trịnh Văn Sơn',
            'Đinh Thị Tuyết',
            'Lưu Văn Uy',
            'Cao Thị Vân',
            'Tôn Văn Xuân',
            'Hồ Thị Yến',
            'Nguyễn Thị Mai',
            'Trần Văn Nam',
            'Lê Thị Oanh',
            'Phạm Văn Phúc',
            'Hoàng Thị Quyên',
            'Vũ Văn Rạng',
            'Đặng Thị Sương',
            'Bùi Văn Tâm',
            'Đỗ Thị Uyên',
            'Ngô Văn Việt'
        ];

        $relationships = ['cha', 'mẹ', 'ông', 'bà', 'anh', 'chị', 'em', 'cô', 'chú', 'dì', 'cậu'];

        foreach ($cemeteries as $cemetery) {
            // Tạo 30-50 lăng mộ cho mỗi nghĩa trang
            $graveCount = rand(30, 50);

            for ($i = 1; $i <= $graveCount; $i++) {
                $graveTypes = ['đất', 'xi_măng', 'đá', 'gỗ', 'khác'];
                $statuses = ['còn_trống', 'đã_sử_dụng', 'bảo_trì', 'ngừng_sử_dụng'];
                $status = fake()->randomElement($statuses);

                $birthDate = fake()->dateTimeBetween('-100 years', '-20 years');
                $deathDate = fake()->dateTimeBetween($birthDate, 'now');

                $ownerName = fake()->randomElement($vietnameseNames);
                $deceasedName = $status === 'đã_sử_dụng' ? fake()->randomElement($vietnameseNames) : null;

                Grave::create([
                    'cemetery_id' => $cemetery->id,
                    'owner_name' => $ownerName,
                    'deceased_full_name' => $deceasedName,
                    'deceased_birth_date' => $status === 'đã_sử_dụng' ? $birthDate : null,
                    'deceased_death_date' => $status === 'đã_sử_dụng' ? $deathDate : null,
                    'deceased_gender' => fake()->randomElement(['nam', 'nữ']),
                    'deceased_relationship' => $status === 'đã_sử_dụng' ? fake()->randomElement($relationships) : null,
                    'deceased_photo' => $status === 'đã_sử_dụng' ? fake()->optional(0.7)->imageUrl(200, 200, 'people') : null,
                    'grave_photos' => $status === 'đã_sử_dụng' ? [
                        fake()->imageUrl(800, 600, 'graves'),
                        fake()->imageUrl(800, 600, 'graves')
                    ] : null,
                    'burial_date' => $status === 'đã_sử_dụng' ? $deathDate : null,
                    'grave_type' => fake()->randomElement($graveTypes),
                    'status' => $status,
                    'location_description' => fake()->optional(0.8)->randomElement([
                        'Gần cổng chính, dễ tìm',
                        'Khu A, hàng 3, mộ số 15',
                        'Gần nhà vệ sinh công cộng',
                        'Khu B, gần cây đa cổ thụ',
                        'Hàng cuối, gần tường rào',
                        'Khu C, gần bãi đỗ xe',
                        'Gần khu vực thờ cúng chung',
                        'Khu D, hàng 2, mộ số 8'
                    ]),
                    'contact_info' => [
                        'phone' => fake()->optional(0.8)->numerify('09########'),
                        'address' => fake()->optional(0.6)->randomElement([
                            'Xóm 1, ' . $cemetery->commune . ', ' . $cemetery->district,
                            'Xóm 2, ' . $cemetery->commune . ', ' . $cemetery->district,
                            'Xóm 3, ' . $cemetery->commune . ', ' . $cemetery->district,
                            'Xóm 4, ' . $cemetery->commune . ', ' . $cemetery->district,
                        ]),
                        'email' => fake()->optional(0.3)->email(),
                    ],
                    'notes' => fake()->optional(0.4)->randomElement([
                        'Mộ gia đình, cần chăm sóc đặc biệt',
                        'Người thân ở xa, ít đến thăm',
                        'Cần sửa chữa bia mộ',
                        'Gia đình thường xuyên đến thăm',
                        'Mộ mới, cần theo dõi',
                        'Có yêu cầu đặc biệt về chăm sóc',
                        'Gia đình có nhiều mộ tại đây',
                        'Cần liên hệ trước khi thăm'
                    ]),
                ]);
            }
        }
    }
}
