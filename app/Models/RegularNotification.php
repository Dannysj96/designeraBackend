<?php

namespace App\Models;

use App\Helpers\FileManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegularNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'image',
        'video',
        'notification_type',
        'sub_type',
        'firebase_topic',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->publicFileUrl($this->image);
    }

    public function getVideoUrlAttribute(): ?string
    {
        return $this->publicFileUrl($this->video);
    }

    private function publicFileUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return FileManager::publicMediaUrl($path);
    }
}
