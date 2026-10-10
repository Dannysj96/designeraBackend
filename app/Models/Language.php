<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';

    protected $fillable = [
        'name',
        'code',
        'locale',
        'image',
        'sort_order',
        'status',
        'english_name',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'integer',
            'sort_order' => 'integer',
        ];
    }
}
