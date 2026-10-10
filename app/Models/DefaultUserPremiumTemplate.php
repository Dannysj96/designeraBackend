<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultUserPremiumTemplate extends Model
{
    use HasFactory;

    protected $table = 'default_user_premium_template';

    protected $fillable = [
        'custom_image',
        'party_id',
        'margin',
        'status',
    ];

    public function party(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Party::class, 'party_id');
    }
}
