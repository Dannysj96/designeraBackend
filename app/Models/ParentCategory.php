<?php

namespace App\Models;

use App\Helpers\FileManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParentCategory extends Model
{
    use HasFactory;

    protected $table = 'parent_category';

    protected $fillable = [
        'title',
        'name',
        'image',
        'status',
        'sequence',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return FileManager::publicMediaUrl($this->image);
    }

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
            'sequence' => 'integer',
        ];
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class, 'parent_category_id');
    }

    public function designMaskings(): HasMany
    {
        return $this->hasMany(DesignMasking::class, 'parent_category_id');
    }
}
