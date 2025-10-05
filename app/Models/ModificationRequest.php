<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModificationRequest extends Model
{
    protected $fillable = [
        'grave_id',
        'requester_name',
        'requester_phone',
        'requester_email',
        'requester_relationship',
        'request_type',
        'current_data',
        'requested_data',
        'reason',
        'status',
        'admin_notes',
        'processed_by',
        'processed_at',
    ];

    protected $casts = [
        'current_data' => 'array',
        'requested_data' => 'array',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the grave that owns the modification request.
     */
    public function grave(): BelongsTo
    {
        return $this->belongsTo(Grave::class);
    }

    /**
     * Get the admin who processed the request.
     */
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Get the request type label in Vietnamese.
     */
    public function getRequestTypeLabelAttribute(): string
    {
        return match ($this->request_type) {
            'sửa_thông_tin' => 'Sửa thông tin',
            'thêm_người' => 'Thêm người',
            'xóa_người' => 'Xóa người',
            'sửa_vị_trí' => 'Sửa vị trí',
            'khác' => 'Khác',
            default => $this->request_type,
        };
    }

    /**
     * Get the status label in Vietnamese.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Chờ xử lý',
            'approved' => 'Đã phê duyệt',
            'rejected' => 'Đã từ chối',
            default => $this->status,
        };
    }

    /**
     * Get the status color for UI.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'error',
            default => 'neutral',
        };
    }

    /**
     * Scope a query to only include pending requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved requests.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include rejected requests.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
