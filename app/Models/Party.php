<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'name',
    'status',
    'image',
    'states',
    'party_image',
    'top_image',
    'bottom_image',
    'custom_image',
    'margin',
])]
class Party extends Model
{
    protected $table = 'party';
    protected function casts(): array
    {
        return [
            'top_image' => 'array',
            'bottom_image' => 'array',
            'states'       => 'array',
            'margin'       => 'array',
        ];
    }
}
