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
        // Get first 3 cemeteries
        $cemeteries = Cemetery::take(3)->get();

        foreach ($cemeteries as $cemetery) {
            // Create different grid sizes for each cemetery
            $gridSize = match ($cemetery->id % 3) {
                1 => ['rows' => 8, 'columns' => 10],  // 80 plots
                2 => ['rows' => 10, 'columns' => 15], // 150 plots
                default => ['rows' => 6, 'columns' => 8],  // 48 plots
            };

            $cemetery->initializePlots(
                rows: $gridSize['rows'],
                columns: $gridSize['columns'],
                clearExisting: true
            );

            $this->command->info("Created {$gridSize['rows']}x{$gridSize['columns']} grid for: {$cemetery->name}");
        }
    }
}
