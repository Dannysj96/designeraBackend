<?php

namespace App\Filament\Resources\SpecialDays\Pages;

use App\Filament\Resources\SpecialDays\SpecialDayResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditSpecialDay extends EditRecord
{
    protected static string $resource = SpecialDayResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
