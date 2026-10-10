<?php

namespace App\Filament\Resources\ReadyPhotos\Pages;

use App\Filament\Resources\ReadyPhotos\ReadyPhotoResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateReadyPhoto extends CreateRecord
{
    protected static string $resource = ReadyPhotoResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
