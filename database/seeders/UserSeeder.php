<?php

namespace Database\Seeders;

use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo admin user nếu chưa tồn tại
        if (! User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'commune' => null,
            ]);
        }

        // Lấy danh sách xã/phường từ API
        $controller = new HomeController;
        $wards = $controller->fetchAndCacheWards();

        // Tạo tài khoản cho 10 xã/phường đầu tiên (ví dụ)
        $sampleWards = array_slice($wards, 0, 10);

        foreach ($sampleWards as $ward) {
            $wardName = $ward['name'];
            $email = 'canbo.' . strtolower(str_replace(' ', '', $this->removeVietnameseTones($wardName))) . '@gmail.com';

            // Kiểm tra nếu chưa tồn tại
            if (! User::where('email', $email)->exists()) {
                User::create([
                    'name' => "Cán bộ {$ward['type']} {$wardName}",
                    'email' => $email,
                    'password' => bcrypt('password'),
                    'role' => 'commune_staff',
                    'commune' => $wardName,
                ]);
            }
        }
    }

    /**
     * Remove Vietnamese tones from string.
     */
    private function removeVietnameseTones(string $str): string
    {
        $vietnameseTones = [
            'à',
            'á',
            'ạ',
            'ả',
            'ã',
            'â',
            'ầ',
            'ấ',
            'ậ',
            'ẩ',
            'ẫ',
            'ă',
            'ằ',
            'ắ',
            'ặ',
            'ẳ',
            'ẵ',
            'è',
            'é',
            'ẹ',
            'ẻ',
            'ẽ',
            'ê',
            'ề',
            'ế',
            'ệ',
            'ể',
            'ễ',
            'ì',
            'í',
            'ị',
            'ỉ',
            'ĩ',
            'ò',
            'ó',
            'ọ',
            'ỏ',
            'õ',
            'ô',
            'ồ',
            'ố',
            'ộ',
            'ổ',
            'ỗ',
            'ơ',
            'ờ',
            'ớ',
            'ợ',
            'ở',
            'ỡ',
            'ù',
            'ú',
            'ụ',
            'ủ',
            'ũ',
            'ư',
            'ừ',
            'ứ',
            'ự',
            'ử',
            'ữ',
            'ỳ',
            'ý',
            'ỵ',
            'ỷ',
            'ỹ',
            'đ',
        ];
        $replacement = [
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'i',
            'i',
            'i',
            'i',
            'i',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'y',
            'y',
            'y',
            'y',
            'y',
            'd',
        ];

        return str_replace($vietnameseTones, $replacement, $str);
    }
}
