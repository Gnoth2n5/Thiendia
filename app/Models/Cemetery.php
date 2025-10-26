<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cemetery extends Model
{
    protected $fillable = [
        'name',
        'commune',
        'address',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the graves for the cemetery.
     */
    public function graves(): HasMany
    {
        return $this->hasMany(Grave::class);
    }

    /**
     * Get the cemetery plots for the cemetery.
     */
    public function plots(): HasMany
    {
        return $this->hasMany(CemeteryPlot::class);
    }

    /**
     * Get the total number of graves in this cemetery.
     */
    public function getTotalGravesAttribute(): int
    {
        return $this->graves()->count();
    }

    /**
     * Get the total number of occupied graves in this cemetery.
     */
    public function getOccupiedGravesAttribute(): int
    {
        return $this->graves()->where('status', 'đã_sử_dụng')->count();
    }

    /**
     * Initialize plots grid for the cemetery.
     *
     * @param  int  $rows  Number of rows
     * @param  int  $columns  Number of columns
     * @param  bool  $clearExisting  Clear existing plots before creating
     * @return int Number of plots created
     */
    public function initializePlots(int $rows, int $columns, bool $clearExisting = false): int
    {
        if ($clearExisting) {
            // Delete all plots for this cemetery
            $this->plots()->delete();
        } else {
            // Check if plots already exist
            $existingCount = $this->plots()->count();
            if ($existingCount > 0) {
                // Already has plots, don't create duplicates
                return 0;
            }
        }

        $plotsData = [];
        for ($row = 1; $row <= $rows; $row++) {
            for ($col = 1; $col <= $columns; $col++) {
                $plotsData[] = [
                    'cemetery_id' => $this->id,
                    'plot_code' => CemeteryPlot::generatePlotCode($row, $col),
                    'row' => $row,
                    'column' => $col,
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        CemeteryPlot::insert($plotsData);

        return count($plotsData);
    }

    /**
     * Get grid dimensions for this cemetery.
     */
    public function getGridDimensions(): array
    {
        $maxRow = $this->plots()->max('row') ?? 0;
        $maxColumn = $this->plots()->max('column') ?? 0;

        return [
            'rows' => $maxRow,
            'columns' => $maxColumn,
        ];
    }
}
