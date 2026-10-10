<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DesignView extends Model
{
    use HasFactory;

    protected $table = 'design_views';

    protected $fillable = [
        'design_type',
        'design_id',
        'user_id',
        'device_id',
        'ip_address',
    ];

    public function design(): BelongsTo
    {
        return $this->belongsTo(Design::class, 'design_id');
    }

    public function masking(): BelongsTo
    {
        return $this->belongsTo(DesignMasking::class, 'design_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
