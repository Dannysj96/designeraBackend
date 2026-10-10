<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'video',
        'notification_type',
        'sub_type',
        'user_plan',
        'status',
        'start_time',
        'end_time',
        'language',
        'state',
        'city',
        'party',
    ];

    protected function casts(): array
    {
        return [
            'user_plan' => 'array',
            'city' => 'array',
            'party' => 'array',
            'status' => 'integer',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }
}
