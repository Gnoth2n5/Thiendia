<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'phone',
        'phone_description',
        'email',
        'email_description',
        'address_line1',
        'address_line2',
        'address_description',
        'working_hours',
        'note',
        'is_active',
    ];

    protected $casts = [
        'working_hours' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the active contact setting
     */
    public static function getActive(): ?self
    {
        return static::where('is_active', true)->first();
    }
}
