<?php

namespace App\Filament\Resources\ReadyPhotos\Pages;

use App\Filament\Resources\ReadyPhotos\ReadyPhotoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditReadyPhoto extends EditRecord
{
    protected static string $resource = ReadyPhotoResource::class;

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
