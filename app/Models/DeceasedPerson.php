<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeceasedPerson extends Model
{
    protected $fillable = [
        'grave_id',
        'full_name',
        'birth_date',
        'death_date',
        'gender',
        'relationship',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the grave that owns the deceased person.
     */
    public function grave(): BelongsTo
    {
        return $this->belongsTo(Grave::class);
    }

    /**
     * Get the gender label in Vietnamese.
     */
    public function getGenderLabelAttribute(): string
    {
        return match ($this->gender) {
            'nam' => 'Nam',
            'nữ' => 'Nữ',
            'khác' => 'Khác',
            default => $this->gender,
        };
    }

    /**
     * Get the age at death.
     */
    public function getAgeAtDeathAttribute(): ?int
    {
        if (!$this->birth_date || !$this->death_date) {
            return null;
        }

        return $this->birth_date->diffInYears($this->death_date);
    }
}
