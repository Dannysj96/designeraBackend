<?php

namespace App\Helpers;

use App\Models\SpecialDay;

class DesignOptions
{
    protected static ?array $typeOptions = null;
    protected static ?array $specialDayOptions = null;

    public static function getTypeOptions(): array
    {
        if (self::$typeOptions !== null) {
            return self::$typeOptions;
        }

        $path = storage_path('app/design_types.json');
        if (file_exists($path)) {
            self::$typeOptions = json_decode(file_get_contents($path), true) ?? [];
        } else {
            self::$typeOptions = [];
        }

        return self::$typeOptions;
    }

    public static function getSpecialDayOptions(): array
    {
        if (self::$specialDayOptions !== null) {
            return self::$specialDayOptions;
        }

        self::$specialDayOptions = SpecialDay::pluck('name', 'id')->filter()->toArray();

        return self::$specialDayOptions;
    }
}
