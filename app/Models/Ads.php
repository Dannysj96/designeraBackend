<?php

namespace App\Models;

use App\Helpers\FileManager;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'image',
    'status',
    'languages',
    'redirect_to',
    'link',
    'module',
    'start',
    'end',
])]
class Ads extends Model
{
    protected $table = 'sliders';

    protected $appends = ['image_url'];

    protected $casts = [
        'languages' => 'array',
        'start' => 'date',
        'end' => 'date',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return FileManager::publicOriginalUrl($this->image);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('module', function (Builder $builder) {
            $builder->where('module', 'ads');
        });

        static::creating(function (Ads $model) {
            $model->module = 'ads';
        });
    }
}
