<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['key' => 'banner'],
            [
                'value' => '[]',
                'status' => true,
                'description' => 'Banner hiển thị ở trang chủ',
            ]
        );
    }
}
