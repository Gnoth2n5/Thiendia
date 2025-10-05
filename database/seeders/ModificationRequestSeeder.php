<?php

namespace Database\Seeders;

use App\Models\Grave;
use App\Models\ModificationRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModificationRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $graves = Grave::where('status', 'đã_sử_dụng')->take(10)->get();

        foreach ($graves as $grave) {
            $requestTypes = ['sửa_thông_tin', 'thêm_người', 'xóa_người', 'sửa_vị_trí', 'khác'];
            $statuses = ['pending', 'approved', 'rejected'];

            ModificationRequest::create([
                'grave_id' => $grave->id,
                'requester_name' => fake('vi_VN')->name(),
                'requester_phone' => fake()->phoneNumber(),
                'requester_email' => fake()->optional(0.7)->email(),
                'requester_relationship' => fake()->randomElement(['con', 'cháu', 'vợ', 'chồng', 'anh', 'chị', 'em']),
                'request_type' => fake()->randomElement($requestTypes),
                'current_data' => [
                    'owner_name' => $grave->owner_name,
                    'grave_type' => $grave->grave_type,
                    'status' => $grave->status,
                ],
                'requested_data' => [
                    'owner_name' => fake('vi_VN')->name(),
                    'grave_type' => fake()->randomElement(['đất', 'xi_măng', 'đá', 'gỗ', 'khác']),
                ],
                'reason' => fake('vi_VN')->sentence(),
                'status' => fake()->randomElement($statuses),
                'admin_notes' => fake()->optional(0.5)->sentence(),
                'processed_by' => fake()->optional(0.6)->randomElement([1]), // admin user
                'processed_at' => fake()->optional(0.6)->dateTimeBetween('-1 month', 'now'),
            ]);
        }
    }
}
