<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadyPhoto extends Model
{
    use HasFactory;

    protected $table = 'ready_photo';

    protected $fillable = [
        'image',
        'party',
        'sort_order',
        'status',
        'parent_category_id',
        'category_id',
    ];

    protected function casts(): array
    {
        return [
            'party' => 'array',
            'sort_order' => 'integer',
            'status' => 'integer',
        ];
    }

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(ParentCategory::class, 'parent_category_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
