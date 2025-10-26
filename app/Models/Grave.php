<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grave extends Model
{
    protected $fillable = [
        'cemetery_id',
        'grave_number',
        'owner_name',
        'deceased_full_name',
        'deceased_birth_date',
        'deceased_death_date',
        'deceased_gender',
        'deceased_relationship',
        'deceased_photo',
        'grave_photos',
        'burial_date',
        'grave_type',
        'status',
        'location_description',
        'latitude',
        'longitude',
        'contact_info',
        'notes',
    ];

    protected $casts = [
        'contact_info' => 'array',
        'grave_photos' => 'array',
        'burial_date' => 'date',
        'deceased_birth_date' => 'date',
        'deceased_death_date' => 'date',
        'latitude' => 'float',
        'longitude' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($grave) {
            if (empty($grave->grave_number) && $grave->cemetery_id) {
                $grave->grave_number = static::generateGraveNumber($grave->cemetery_id);
            }
        });
    }

    /**
     * Generate grave number based on cemetery_id.
     */
    public static function generateGraveNumber(int $cemeteryId): string
    {
        $count = static::where('cemetery_id', $cemeteryId)->count();
        $nextNumber = $count + 1;

        return $cemeteryId . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get the cemetery that owns the grave.
     */
    public function cemetery(): BelongsTo
    {
        return $this->belongsTo(Cemetery::class);
    }

    /**
     * Get the deceased persons for the grave.
     */
    public function deceasedPersons(): HasMany
    {
        return $this->hasMany(DeceasedPerson::class);
    }

    /**
     * Get the grave type label in Vietnamese.
     */
    public function getGraveTypeLabelAttribute(): string
    {
        return match ($this->grave_type) {
            'đất' => 'Lăng mộ đất',
            'xi_măng' => 'Lăng mộ xi măng',
            'đá' => 'Lăng mộ đá',
            'gỗ' => 'Lăng mộ gỗ',
            'khác' => 'Loại khác',
            default => $this->grave_type,
        };
    }

    /**
     * Get the status label in Vietnamese.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'còn_trống' => 'Còn trống',
            'đã_sử_dụng' => 'Đã sử dụng',
            'bảo_trì' => 'Bảo trì',
            'ngừng_sử_dụng' => 'Ngừng sử dụng',
            default => $this->status,
        };
    }
}
