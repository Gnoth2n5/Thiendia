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
    'plot_id',
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
   * Boot the model and register events.
   */
  protected static function booted(): void
  {
    // When a grave is created or updated with a plot_id, mark the plot as occupied
    static::created(function (Grave $grave) {
      if ($grave->plot_id) {
        CemeteryPlot::where('id', $grave->plot_id)->update(['status' => 'occupied']);
      }
    });

    static::updated(function (Grave $grave) {
      // If plot_id changed, update both old and new plots
      if ($grave->isDirty('plot_id')) {
        $originalPlotId = $grave->getOriginal('plot_id');

        // Mark old plot as available
        if ($originalPlotId) {
          CemeteryPlot::where('id', $originalPlotId)->update(['status' => 'available']);
        }

        // Mark new plot as occupied
        if ($grave->plot_id) {
          CemeteryPlot::where('id', $grave->plot_id)->update(['status' => 'occupied']);
        }
      }
    });

    // When a grave is deleted, mark the plot as available
    static::deleted(function (Grave $grave) {
      if ($grave->plot_id) {
        CemeteryPlot::where('id', $grave->plot_id)->update(['status' => 'available']);
      }
    });
  }

  /**
   * Get the cemetery that owns the grave.
   */
  public function cemetery(): BelongsTo
  {
    return $this->belongsTo(Cemetery::class);
  }

  /**
   * Get the plot that the grave is located in.
   */
  public function plot(): BelongsTo
  {
    return $this->belongsTo(CemeteryPlot::class, 'plot_id');
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
