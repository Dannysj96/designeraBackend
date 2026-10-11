<?php

namespace App\Models;

use App\Helpers\FileManager;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'plans';

    protected $appends = ['image_url'];

    protected static function booted(): void
    {
        parent::boot();

        static::saving(function ($plan) {
            if (empty($plan->parent_id)) {
                $plan->parent_id = 30;
            }
            if (empty($plan->app_key)) {
                $plan->app_key = '["1","3","4","5","6","8","9","10","11","12"]';
            }
            if (! isset($plan->is_display)) {
                $plan->is_display = 1;
            }
        });
    }

    /**
     * Map status for Filament (active/inactive <-> 1/0)
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ((int) $value === 1 || $value === 'active' || $value === '1') ? 'active' : 'inactive',
            set: fn ($value) => ($value === 'active' || $value === 1 || $value === '1' || $value === true) ? 1 : 0,
        );
    }

    /**
     * Get duration days (supports duration & duration_days)
     */
    protected function durationDays(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => (int) ($attributes['duration'] ?? $attributes['duration_days'] ?? 30),
        );
    }

    /**
     * Daily design limit
     */
    protected function dailyLimitDesign(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => (int) ($attributes['daily_design_limit'] ?? $attributes['daily_limit_design'] ?? 0),
        );
    }

    /**
     * Daily video limit
     */
    protected function dailyLimitVideo(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => (int) ($attributes['daily_video_limit'] ?? $attributes['daily_limit_video'] ?? 0),
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->image
            ? FileManager::publicMediaUrl($this->image)
            : null);
    }
}
