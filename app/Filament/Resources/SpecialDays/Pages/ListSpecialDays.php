<?php

namespace App\Filament\Resources\SpecialDays\Pages;

use App\Filament\Resources\SpecialDays\SpecialDayResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListSpecialDays extends ListRecords
{
    protected static string $resource = SpecialDayResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
