<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use Illuminate\Database\Seeder;

class ContactSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactSetting::updateOrCreate(
            ['is_active' => true],
            [
                'phone' => '1900-xxxx',
                'phone_description' => 'Hỗ trợ tra cứu và tư vấn 24/7',
                'email' => 'contact@example.com',
                'email_description' => 'Phản hồi trong vòng 24 giờ',
                'address_line1' => 'Số 123, Đường ABC, Phường XYZ',
                'address_line2' => 'Thành phố Ninh Bình, Tỉnh Ninh Bình',
                'address_description' => 'Giờ làm việc: 8:00 - 17:00 (T2-T6)',
                'working_hours' => [
                    [
                        'day' => 'Thứ 2 - Thứ 6',
                        'hours' => '8:00 - 17:00',
                        'is_closed' => false,
                    ],
                    [
                        'day' => 'Thứ 7',
                        'hours' => '8:00 - 12:00',
                        'is_closed' => false,
                    ],
                    [
                        'day' => 'Chủ nhật',
                        'hours' => 'Nghỉ',
                        'is_closed' => true,
                    ],
                ],
                'note' => 'Hotline hỗ trợ 24/7 cho các trường hợp khẩn cấp và tra cứu thông tin.',
                'is_active' => true,
            ]
        );
    }
}
