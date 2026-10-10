<?php

namespace App\Filament\Resources\SpecialDays\Pages;

use App\Filament\Resources\SpecialDays\SpecialDayResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateSpecialDay extends CreateRecord
{
    protected static string $resource = SpecialDayResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
