<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhotoHistory extends Model
{
    use HasFactory;

    protected $table = 'photo_history';

    protected $fillable = [
        'user_id',
        'photo_id',
        'app_key',
        'photo_price',
        'designer_photo_id',
        'type',
        'latitude',
        'longitude',
        'pincode',
    ];

    protected $casts = [
        'photo_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function design(): BelongsTo
    {
        return $this->belongsTo(Design::class, 'photo_id');
    }
}
