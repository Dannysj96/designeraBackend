<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialDay extends Model
{
    use HasFactory;

    protected $table = 'special_days';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            's_date' => 'date',
            'status' => 'integer',
            'img_status' => 'integer',
            'sequence' => 'integer',
        ];
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->date && !$model->s_date) {
                $model->s_date = $model->date;
            } elseif ($model->s_date && !$model->date) {
                $model->date = $model->s_date;
            }
            if (isset($model->status) && !isset($model->img_status)) {
                $model->img_status = (int) $model->status;
            } elseif (isset($model->img_status) && !isset($model->status)) {
                $model->status = (int) $model->img_status;
            }
        });
    }
}
