<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LucNham\LunarCalendar\LunarDateTime;

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
   * Get the tributes for the grave.
   */
  public function tributes(): HasMany
  {
    return $this->hasMany(Tribute::class);
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

  /**
   * Convert Gregorian date to lunar calendar.
   */
  public function getLunarDate(): ?array
  {
    if (!$this->deceased_death_date) {
      return null;
    }

    try {
      // Convert Gregorian date to lunar using LunarDateTime
      $lunar = LunarDateTime::fromGregorian($this->deceased_death_date->format('Y-m-d'));

      return [
        'year' => (int) $lunar->format('Y'),
        'month' => (int) $lunar->format('m'),
        'day' => (int) $lunar->format('d'),
      ];
    } catch (\Exception $e) {
      return null;
    }
  }

  /**
   * Check if the grave's death anniversary matches today (lunar calendar).
   */
  public function hasDeathAnniversaryToday(): bool
  {
    if (!$this->deceased_death_date) {
      return false;
    }

    try {
      // Get today's lunar date
      $todayLunar = LunarDateTime::now();

      // Get deceased death date in lunar
      $deathLunar = LunarDateTime::fromGregorian($this->deceased_death_date->format('Y-m-d'));

      // Compare month and day (ignoring year)
      return $todayLunar->format('m') === $deathLunar->format('m') &&
        $todayLunar->format('d') === $deathLunar->format('d');
    } catch (\Exception $e) {
      return false;
    }
  }

  /**
   * Scope to filter graves with death anniversary matching today's lunar date.
   */
  public function scopeDeathAnniversaryToday(Builder $query): Builder
  {
    return $query->where(function ($q) {
      try {
        // Get today's lunar date
        $todayLunar = LunarDateTime::now();
        $todayMonth = $todayLunar->format('m');
        $todayDay = $todayLunar->format('d');

        // Get all graves with death dates
        $graves = static::whereNotNull('deceased_death_date')->get();

        $graveIds = [];

        foreach ($graves as $grave) {
          try {
            // Convert death date to lunar
            $deathLunar = LunarDateTime::fromGregorian($grave->deceased_death_date->format('Y-m-d'));
            $deathMonth = $deathLunar->format('m');
            $deathDay = $deathLunar->format('d');

            // Check if month and day match
            if ($todayMonth === $deathMonth && $todayDay === $deathDay) {
              $graveIds[] = $grave->id;
            }
          } catch (\Exception $e) {
            continue;
          }
        }

        if (!empty($graveIds)) {
          $q->whereIn('id', $graveIds);
        } else {
          // Return empty result if no matches
          $q->whereRaw('1 = 0');
        }
      } catch (\Exception $e) {
        $q->whereRaw('1 = 0');
      }
    });
  }

  /**
   * Get tribute count for today only.
   */
  public function getTributeCountTodayAttribute(): int
  {
    return $this->tributes()
      ->whereDate('created_at', today())
      ->count();
  }
}
