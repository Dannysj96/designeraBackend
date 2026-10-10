<?php

namespace App\Filament\Resources\ReadyPhotos\Pages;

use App\Filament\Resources\ReadyPhotos\ReadyPhotoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListReadyPhotos extends ListRecords
{
    protected static string $resource = ReadyPhotoResource::class;

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
