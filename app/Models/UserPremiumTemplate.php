<?php

namespace App\Models;

use App\Helpers\FileManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserPremiumTemplate extends Model
{
    use HasFactory;

    protected $table = 'user_premium_templates';

    protected $fillable = [
        'user_id',
        'middle_image',
        'top_image',
        'bottom_image',
        'frame_type',
        'status',
        'created_date',
        'up_to_days',
        'extra_days',
        'margin_bottom',
        'margin_top',
        'margin_left',
        'margin_right',
        'days_left',
    ];

    protected $casts = [
        'created_date' => 'date',
        'up_to_days' => 'integer',
        'extra_days' => 'integer',
        'margin_bottom' => 'integer',
        'margin_top' => 'integer',
        'margin_left' => 'integer',
        'margin_right' => 'integer',
        'days_left' => 'integer',
    ];

    public function getMiddleImageUrlAttribute(): ?string
    {
        return self::formatImageUrl($this->middle_image);
    }

    public function getTopImageUrlAttribute(): ?string
    {
        return self::formatImageUrl($this->top_image);
    }

    public function getBottomImageUrlAttribute(): ?string
    {
        return self::formatImageUrl($this->bottom_image);
    }

    public static function formatImageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return FileManager::publicMediaUrl($path);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function premiumTemplates(): HasMany
    {
        return $this->hasMany(UserPremiumTemplate::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
