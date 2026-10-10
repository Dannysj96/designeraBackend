<?php

namespace App\Filament\Resources\ReadyTexts\Pages;

use App\Filament\Resources\ReadyTexts\ReadyTextResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListReadyTexts extends ListRecords
{
    protected static string $resource = ReadyTextResource::class;

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
