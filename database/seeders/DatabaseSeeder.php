<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Chạy các seeder theo thứ tự
        $this->call([
            UserSeeder::class,
            CemeterySeeder::class,
            CemeteryPlotSeeder::class,
        ]);
    }
}
