<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'design',
        'price',
        'discount',
        'status',
        'merging',
        'front_img',
        'back',
        'type',
        'sub_type',
        'special_day',
        'parent_category_id',
        'category_id',
        'sub_category_id',
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
            'front_img' => 'boolean',
            'back' => 'boolean',
            'city' => 'array',
            'party' => 'array',
            'date' => 'date',
            'only_for_today' => 'boolean',
            'show_in_slider' => 'integer',
            'remove_watermark' => 'integer',
            'views' => 'integer',
            'downloads' => 'integer',
        ];
    }

    protected $appends = ['design_url', 'front_img', 'back'];

    protected static function booted(): void
    {
        static::saving(function (Design $model) {
            $selected = [];
            if (! empty($model->front_img)) {
                $selected[] = 'front_img';
                $selected[] = '1';
            }
            if (! empty($model->back)) {
                $selected[] = 'back';
                $selected[] = '2';
            }
            $model->merging = $selected;
        });
    }

    public function getFrontImgAttribute($value): bool
    {
        if ($value !== null && $value !== '') {
            return (bool) $value;
        }
        $m = (array) ($this->merging ?? []);

        return in_array('front_img', $m) || in_array('1', $m) || ! empty($m['front_img']) || ! empty($m['1']);
    }

    public function getBackAttribute($value): bool
    {
        if ($value !== null && $value !== '') {
            return (bool) $value;
        }
        $m = (array) ($this->merging ?? []);

        return in_array('back', $m) || in_array('2', $m) || ! empty($m['back']) || ! empty($m['2']);
    }

    public function getDesignUrlAttribute(): ?string
    {
        if (! $this->design) {
            return null;
        }

        return str_starts_with($this->design, 'http')
            ? $this->design
            : asset('storage/'.$this->design);
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
