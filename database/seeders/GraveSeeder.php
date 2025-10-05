<?php

namespace Database\Seeders;

use App\Models\Cemetery;
use App\Models\Grave;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GraveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cemeteries = Cemetery::all();

        foreach ($cemeteries as $cemetery) {
            // Tạo 20-30 lăng mộ cho mỗi nghĩa trang
            $graveCount = rand(20, 30);

            for ($i = 1; $i <= $graveCount; $i++) {
                $graveTypes = ['đất', 'xi_măng', 'đá', 'gỗ', 'khác'];
                $statuses = ['còn_trống', 'đã_sử_dụng', 'bảo_trì', 'ngừng_sử_dụng'];

                $grave = Grave::create([
                    'cemetery_id' => $cemetery->id,
                    'grave_number' => sprintf('%s-%03d', $cemetery->id, $i),
                    'owner_name' => fake('vi_VN')->name(),
                    'burial_date' => fake()->optional(0.7)->dateTimeBetween('-10 years', 'now'),
                    'grave_type' => fake()->randomElement($graveTypes),
                    'status' => fake()->randomElement($statuses),
                    'location_description' => fake()->optional(0.8)->sentence(),
                    'contact_info' => [
                        'phone' => fake()->optional(0.6)->phoneNumber(),
                        'address' => fake()->optional(0.5)->address(),
                    ],
                    'notes' => fake()->optional(0.3)->sentence(),
                ]);

                // Tạo danh sách người đã khuất cho lăng mộ đã sử dụng
                if ($grave->status === 'đã_sử_dụng') {
                    $deceasedCount = rand(1, 3);
                    $deceasedPersons = [];

                    for ($j = 0; $j < $deceasedCount; $j++) {
                        $deceasedPersons[] = [
                            'full_name' => fake('vi_VN')->name(),
                            'birth_date' => fake()->dateTimeBetween('-80 years', '-20 years'),
                            'death_date' => fake()->dateTimeBetween('-5 years', 'now'),
                            'gender' => fake()->randomElement(['nam', 'nữ']),
                            'relationship' => fake()->randomElement(['cha', 'mẹ', 'ông', 'bà', 'anh', 'chị', 'em']),
                        ];
                    }

                    $grave->update(['deceased_persons' => $deceasedPersons]);
                }
            }
        }
    }
}
