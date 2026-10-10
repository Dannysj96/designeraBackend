<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'total',
        'discount',
        'max_discount',
        'start_date',
        'end_date',
        'total_uses',
        'use_per_user',
        'status',
        'is_display',
        'user_type',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'integer',
            'discount' => 'decimal:2',
            'max_discount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'total_uses' => 'integer',
            'use_per_user' => 'integer',
            'is_display' => 'boolean',
            'user_type' => 'array',
        ];
    }
}
