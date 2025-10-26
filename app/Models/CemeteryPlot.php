<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CemeteryPlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'cemetery_id',
        'plot_code',
        'row',
        'column',
        'status',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the cemetery that owns the plot.
     */
    public function cemetery(): BelongsTo
    {
        return $this->belongsTo(Cemetery::class);
    }

    /**
     * Get the grave located in this plot.
     */
    public function grave(): HasOne
    {
        return $this->hasOne(Grave::class, 'plot_id');
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available' => 'Còn trống',
            'occupied' => 'Đã sử dụng',
            'reserved' => 'Đã đặt trước',
            'unavailable' => 'Không khả dụng',
            default => 'Không xác định',
        };
    }

    /**
     * Scope a query to only include available plots.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope a query to only include occupied plots.
     */
    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }

    /**
     * Scope a query to filter by cemetery.
     */
    public function scopeForCemetery($query, int $cemeteryId)
    {
        return $query->where('cemetery_id', $cemeteryId);
    }

    /**
     * Generate plot code from row and column.
     */
    public static function generatePlotCode(int $row, int $column): string
    {
        // Convert row to letter (1=A, 2=B, ..., 26=Z, 27=AA, etc.)
        $letter = '';
        $temp = $row;
        while ($temp > 0) {
            $temp--;
            $letter = chr(65 + ($temp % 26)) . $letter;
            $temp = intval($temp / 26);
        }

        return $letter . $column;
    }
}
