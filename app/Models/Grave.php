<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grave extends Model
{
    protected $fillable = [
        'cemetery_id',
        'caretaker_name',
        'deceased_full_name',
        'birth_year',
        'rank_and_unit',
        'position',
        'deceased_birth_date',
        'deceased_death_date',
        'certificate_number',
        'decision_number',
        'decision_date',
        'deceased_gender',
        'deceased_relationship',
        'next_of_kin',
        'deceased_photo',
        'grave_photos',
        'burial_date',
        'grave_type',
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
        'decision_date' => 'date',
        'birth_year' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

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
}
