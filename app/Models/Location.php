<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';
    protected $fillable = [
        'name',
        'state_id',
    ];

    public function state()
    {
        return $this->belongsTo(Location::class, 'state_id');
    }

    public function cities()
    {
        return $this->hasMany(Location::class, 'state_id');
    }
}
