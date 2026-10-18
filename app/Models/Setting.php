<?php

namespace App\Models;

use App\Helpers\FileManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['group', 'key', 'value', 'is_json'];

    protected static array $defaults = [
        'site_title' => 'Admin Panel',
        'site_subtitle' => 'Designera',
        'email' => 'admin@admin.com',
        'logo' => null,
        'phone' => null,
        'whatsapp_number' => '919158592601',
        'address' => null,
        'watermark' => null,
        'copyright' => null,
        'fcm_api_key' => null,
        'sms_api_key' => null,
        'footer_copyright_text' => null,
        'splash_screen' => null,
        'splash_screen_type' => null,
        'splash_duration' => 2,
    ];

    const CACHE_KEY = 'app_settings';

    /**
     * Get every setting as a key => value collection (cached).
     * NOTE: renamed from all() to avoid clashing with Eloquent's native all().
     */
    public static function allSettings(): Collection
    {
        $value = Cache::get(self::CACHE_KEY);

        if (! $value instanceof Collection) {
            Cache::forget(self::CACHE_KEY);
            $value = static::query()->pluck('value', 'key');
            Cache::forever(self::CACHE_KEY, $value);
        }

        return $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $value = static::allSettings()->get($key);

        if ($value !== null) {
            return $value;
        }

        return $default ?? (static::$defaults[$key] ?? null);
    }

    public static function set(string $key, mixed $value, string $group = 'site'): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        Cache::forget(self::CACHE_KEY);
    }

    public static function setMany(array $data, string $group = 'site'): void
    {
        foreach ($data as $key => $value) {
            static::query()->updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        }
        Cache::forget(self::CACHE_KEY);
    }

    public static function currentArray(): array
    {
        $saved = static::allSettings();

        $keys = array_unique(array_merge(array_keys(static::$defaults), $saved->keys()->all()));

        $result = [];
        foreach ($keys as $key) {
            $result[$key] = static::get($key);
        }

        return $result;
    }

    public static function url(string $key): ?string
    {
        $value = static::get($key);

        if (! $value) {
            return null;
        }

        return FileManager::publicThumbnailUrl($value);
    }
}
