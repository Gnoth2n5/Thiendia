<?php

namespace Database\Seeders;

use App\Models\DeceasedPerson;
use App\Models\Grave;
use Illuminate\Database\Seeder;

class DeceasedPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $graves = Grave::where('status', 'đã_sử_dụng')->get();

        // Vietnamese names for deceased persons
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
            'Ngô Văn Việt',
            'Lê Văn Đức',
            'Trần Thị Hương',
            'Nguyễn Văn Khánh',
            'Phạm Thị Linh',
            'Hoàng Văn Mạnh',
            'Vũ Thị Nga',
            'Đặng Văn Oanh',
            'Bùi Thị Phượng',
            'Đỗ Văn Quang',
            'Ngô Thị Rạng'
        ];

        $relationships = ['cha', 'mẹ', 'ông', 'bà', 'anh', 'chị', 'em', 'cô', 'chú', 'dì', 'cậu'];

        foreach ($graves as $grave) {
            // Một số mộ có thể có nhiều người đã khuất
            $deceasedCount = fake()->randomElement([1, 1, 1, 2, 2, 3]); // 60% có 1 người, 30% có 2 người, 10% có 3 người

            for ($i = 0; $i < $deceasedCount; $i++) {
                $birthDate = fake()->dateTimeBetween('-100 years', '-20 years');
                $deathDate = fake()->dateTimeBetween($birthDate, 'now');

                DeceasedPerson::create([
                    'grave_id' => $grave->id,
                    'full_name' => fake()->randomElement($vietnameseNames),
                    'birth_date' => $birthDate,
                    'death_date' => $deathDate,
                    'gender' => fake()->randomElement(['nam', 'nữ']),
                    'relationship' => fake()->randomElement($relationships),
                    'photo' => fake()->optional(0.6)->imageUrl(200, 200, 'people'),
                    'biography' => fake()->optional(0.5)->randomElement([
                        'Người cha/mẹ hiền lành, được mọi người yêu quý',
                        'Có nhiều đóng góp cho cộng đồng địa phương',
                        'Người thầy/cô giáo được học trò kính trọng',
                        'Cựu chiến binh, có nhiều công lao với đất nước',
                        'Người nông dân chăm chỉ, hiền lành',
                        'Có tài năng đặc biệt trong nghề nghiệp',
                        'Người con hiếu thảo, được gia đình yêu thương',
                        'Có nhiều bạn bè, được mọi người quý mến'
                    ]),
                    'notes' => fake()->optional(0.3)->randomElement([
                        'Cần chăm sóc đặc biệt',
                        'Gia đình thường xuyên đến thăm',
                        'Có yêu cầu riêng về nghi lễ',
                        'Người thân ở xa',
                        'Cần liên hệ trước khi thăm'
                    ]),
                ]);
            }
        }
    }
}
