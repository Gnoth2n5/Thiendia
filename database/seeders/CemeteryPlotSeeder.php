<?php

namespace Database\Seeders;

use App\Models\Cemetery;
use Illuminate\Database\Seeder;

class CemeteryPlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy nghĩa trang xã Lý Nhân
        $cemetery = Cemetery::where('commune', 'Lý Nhân')->first();

        if ($cemetery) {
            // Tạo lưới lô: 15 hàng dọc x 8 cột ngang = 120 lô
            $cemetery->initializePlots(
                rows: 15,
                columns: 8,
                clearExisting: true
            );

            $this->command->info("Created 15x8 grid (120 plots) for: {$cemetery->name}");
        } else {
            $this->command->error('Cemetery not found! Please run CemeterySeeder first.');
        }
    }
}
