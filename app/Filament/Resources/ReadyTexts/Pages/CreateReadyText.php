<?php

namespace App\Filament\Resources\ReadyTexts\Pages;

use App\Filament\Resources\ReadyTexts\ReadyTextResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateReadyText extends CreateRecord
{
    protected static string $resource = ReadyTextResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
