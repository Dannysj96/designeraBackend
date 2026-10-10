<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'parent_category_id',
        'title',
        'name',
        'status',
    ];

    public function getTitleAttribute()
    {
        return $this->attributes['name'] ?? $this->attributes['title'] ?? '';
    }

    public function getNameAttribute()
    {
        return $this->attributes['name'] ?? $this->attributes['title'] ?? '';
    }

    protected function casts(): array
    {
        return [
            'status' => 'integer',
        ];
    }

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(ParentCategory::class, 'parent_category_id');
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }

    public function designs(): HasMany
    {
        return $this->hasMany(Design::class, 'category_id');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class, 'category_id');
    }

    public function designMaskings(): HasMany
    {
        return $this->hasMany(DesignMasking::class, 'category_id');
    }
}

