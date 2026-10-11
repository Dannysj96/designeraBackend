<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Helpers\FileManager;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function planHistories(): HasMany
    {
        return $this->hasMany(UserPlanHistory::class)->latest('id');
    }

    public function activePlanHistory(): HasOne
    {
        return $this->hasOne(UserPlanHistory::class)->where('status', 'active')->latestOfMany();
    }

    public function markPlanExpiredIfDue(): void
    {
        if (! $this->expiry_date || $this->plan_expired) {
            return;
        }

        if (Carbon::parse($this->expiry_date)->endOfDay()->isFuture()) {
            return;
        }

        DB::transaction(function (): void {
            $this->forceFill(['plan_expired' => true])->save();
            $this->planHistories()->where('status', 'active')->update(['status' => 'expired']);
        });

        $this->refresh();
    }

    public function stateLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'state', 'id');
    }

    public function cityLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'city', 'id');
    }

    public function partyRelation(): BelongsTo
    {
        return $this->belongsTo(Party::class, 'party', 'id');
    }

    /**
     * Mobile / Phone accessor & mutator
     */
    protected function mobile(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $attributes['phone'] ?? $value,
            set: fn ($value) => ['phone' => $value],
        );
    }

    /**
     * Profile Photo / Pic accessor
     */
    protected function profilePhoto(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $attributes['profile_pic'] ?? $value,
            set: fn ($value) => ['profile_pic' => $value],
        );
    }

    /**
     * Get profile photo URL.
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        $pic = $this->profile_photo ?? $this->profile_pic;
        if (! $pic) {
            return null;
        }

        return FileManager::publicThumbnailUrl($pic);
    }

    /**
     * Daily Design Limit accessor
     */
    protected function dailyDownloadLimitDesign(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => (int) ($value ?? $attributes['design_daily_download_limit'] ?? 0),
            set: fn ($value) => ['design_daily_download_limit' => (int) $value],
        );
    }

    /**
     * Daily Video Limit accessor
     */
    protected function dailyDownloadLimitVideo(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => (int) ($value ?? $attributes['video_daily_download_limit'] ?? 0),
            set: fn ($value) => ['video_daily_download_limit' => (int) $value],
        );
    }

    /**
     * Wallet Balance accessor
     */
    protected function walletBalance(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => (float) ($value ?? $attributes['balance'] ?? 0.00),
            set: fn ($value) => ['balance' => (float) $value],
        );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'remove_copyright' => 'boolean',
            'remove_watermark' => 'boolean',
            'design_daily_download_limit' => 'integer',
            'video_daily_download_limit' => 'integer',
            'start_date' => 'date:Y-m-d',
            'expiry_date' => 'date:Y-m-d',
            'plan_expired' => 'boolean',
        ];
    }

    public function premiumTemplates(): HasMany
    {
        return $this->hasMany(UserPremiumTemplate::class);
    }
}
