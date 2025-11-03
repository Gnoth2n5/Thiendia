<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'commune' => null,
        ]);

        $this->command->info('Created admin user: admin@gmail.com');

        // Tạo cán bộ xã Lý Nhân
        User::create([
            'name' => 'Cán bộ Xã Lý Nhân',
            'email' => 'canbo.lynhan@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'commune_staff',
            'commune' => 'Lý Nhân',
        ]);

        $this->command->info('Created commune staff user: canbo.lynhan@gmail.com');
    }
}
