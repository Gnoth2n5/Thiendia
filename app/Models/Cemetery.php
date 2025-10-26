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
}
