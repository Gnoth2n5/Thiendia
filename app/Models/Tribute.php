<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tribute extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   */
  protected $table = 'tribute_logs';

  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = [
    'grave_id',
    'name',
    'message',
    'user_ip',
  ];

  /**
   * Get the grave that the tribute belongs to.
   */
  public function grave(): BelongsTo
  {
    return $this->belongsTo(Grave::class);
  }

  /**
   * Scope to get recent tributes.
   */
  public function scopeRecent($query, int $limit = 5)
  {
    return $query->latest()->limit($limit);
  }

  /**
   * Get the display name (use "Ẩn danh" if name is empty).
   */
  public function getDisplayNameAttribute(): string
  {
    return !empty($this->name) ? $this->name : 'Ẩn danh';
  }

  /**
   * Get formatted date.
   */
  public function getFormattedDateAttribute(): string
  {
    return $this->created_at->format('d/m/Y');
  }

  /**
   * Check if a user with a given IP has tributed today for a grave.
   */
  public static function hasTributedToday(int $graveId, string $userIp): bool
  {
    return static::where('grave_id', $graveId)
      ->where('user_ip', $userIp)
      ->whereDate('created_at', today())
      ->exists();
  }
}
