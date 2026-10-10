<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'video',
        'thumbnail',
        'price',
        'discount',
        'status',
        'merging',
        'parent_category_id',
        'category_id',
        'sub_category_id',
        'special_day',
        'language',
        'plan',
        'frames',
        'caption',
        'state',
        'city',
        'party',
        'display_to_user',
        'watermark_text_color',
        'date',
        'up_to_days',
        'only_for_today',
        'show_in_slider',
        'copyright_position',
        'remove_watermark',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount' => 'decimal:2',
            'status' => 'integer',
            'merging' => 'array',
            'city' => 'array',
            'party' => 'array',
            'date' => 'date',
            'only_for_today' => 'boolean',
            'show_in_slider' => 'integer',
            'remove_watermark' => 'integer',
        ];
    }

    public function specialDay(): BelongsTo
    {
        return $this->belongsTo(SpecialDay::class, 'special_day');
    }

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(ParentCategory::class, 'parent_category_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
}
