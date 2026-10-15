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
        'date_start',
        'date_end',
        'uses_total',
        'uses_customer',
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
            'date_start' => 'date',
            'date_end' => 'date',
            'uses_total' => 'integer',
            'uses_customer' => 'integer',
            'status' => 'integer',
            'is_display' => 'boolean',
            'user_type' => 'array',
        ];
    }
}
