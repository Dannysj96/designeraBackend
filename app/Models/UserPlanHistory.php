<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'plan_id',
    'plan_name',
    'price',
    'duration_days',
    'start_date',
    'end_date',
    'status',
    'daily_limit_design',
    'daily_limit_video',
    'payment_method',
    'transaction_id',
    'notes',
])]
class UserPlanHistory extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration_days' => 'integer',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'daily_limit_design' => 'integer',
            'daily_limit_video' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get remaining validity days.
     */
    public function getRemainingDaysAttribute(): int
    {
        if (! $this->end_date) {
            return 0;
        }

        $now = Carbon::now();
        if ($this->end_date->isPast()) {
            return 0;
        }

        return (int) ceil($now->diffInHours($this->end_date, false) / 24);
    }

    /**
     * Check if this plan history is currently active & not expired.
     */
    public function getIsCurrentlyValidAttribute(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        return true;
    }
}
