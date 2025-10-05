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
                $status = fake()->randomElement($statuses);

                $birthDate = fake()->dateTimeBetween('-100 years', '-20 years');
                $deathDate = fake()->dateTimeBetween($birthDate, 'now');

                Grave::create([
                    'cemetery_id' => $cemetery->id,
                    // grave_number sẽ được tự động generate bởi model
                    'owner_name' => fake('vi_VN')->name(),
                    'deceased_full_name' => $status === 'đã_sử_dụng' ? fake('vi_VN')->name() : null,
                    'deceased_birth_date' => $status === 'đã_sử_dụng' ? $birthDate : null,
                    'deceased_death_date' => $status === 'đã_sử_dụng' ? $deathDate : null,
                    'deceased_gender' => fake()->randomElement(['nam', 'nữ']),
                    'deceased_relationship' => $status === 'đã_sử_dụng' ? fake()->randomElement(['cha', 'mẹ', 'ông', 'bà', 'anh', 'chị', 'em']) : null,
                    'burial_date' => $status === 'đã_sử_dụng' ? $deathDate : null,
                    'grave_type' => fake()->randomElement($graveTypes),
                    'status' => $status,
                    'location_description' => fake()->optional(0.8)->sentence(),
                    'contact_info' => [
                        'phone' => fake()->optional(0.6)->phoneNumber(),
                        'address' => fake()->optional(0.5)->address(),
                    ],
                    'notes' => fake()->optional(0.3)->sentence(),
                ]);
            }
        }
    }
}
