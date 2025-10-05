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
        'deceased_persons',
        'burial_date',
        'grave_type',
        'status',
        'location_description',
        'contact_info',
        'notes',
    ];

    protected $casts = [
        'deceased_persons' => 'array',
        'contact_info' => 'array',
        'burial_date' => 'date',
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
     * Get the modification requests for the grave.
     */
    public function modificationRequests(): HasMany
    {
        return $this->hasMany(ModificationRequest::class);
    }

    /**
     * Get the pending modification requests for the grave.
     */
    public function pendingModificationRequests(): HasMany
    {
        return $this->hasMany(ModificationRequest::class)->where('status', 'pending');
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
