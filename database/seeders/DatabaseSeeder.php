<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo admin user trước
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        // Chạy các seeder theo thứ tự
        $this->call([
            CemeterySeeder::class,
            GraveSeeder::class,
            ModificationRequestSeeder::class,
        ]);
    }
}
