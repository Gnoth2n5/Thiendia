<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
  protected $fillable = [
    'name',
    'phone',
    'email',
    'subject',
    'message',
    'status',
    'admin_reply',
    'replied_at',
  ];

  protected $casts = [
    'replied_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  /**
   * Get the status label
   */
  public function getStatusLabelAttribute(): string
  {
    return match ($this->status) {
      'pending' => 'Chờ xử lý',
      'read' => 'Đã đọc',
      'replied' => 'Đã phản hồi',
      'closed' => 'Đã đóng',
      default => 'Không xác định',
    };
  }

  /**
   * Scope for pending messages
   */
  public function scopePending($query)
  {
    return $query->where('status', 'pending');
  }

  /**
   * Scope for read messages
   */
  public function scopeRead($query)
  {
    return $query->where('status', 'read');
  }

  /**
   * Scope for replied messages
   */
  public function scopeReplied($query)
  {
    return $query->where('status', 'replied');
  }
}
