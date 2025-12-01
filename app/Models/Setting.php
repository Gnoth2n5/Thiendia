<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'status',
        'description',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get setting value by key
     */
    public static function getValue(string $key, $default = null): ?string
    {
        $setting = static::where('key', $key)->where('status', true)->first();

        return $setting?->value ?? $default;
    }

    /**
     * Get banner images as array
     */
    public static function getBannerImages(): array
    {
        $banner = static::where('key', 'banner')->where('status', true)->first();

        if (! $banner || empty($banner->value)) {
            return [];
        }

        $images = json_decode($banner->value, true);

        return is_array($images) ? $images : [];
    }

    /**
     * Check if banner is active
     */
    public static function isBannerActive(): bool
    {
        return static::where('key', 'banner')->where('status', true)->exists();
    }
}
