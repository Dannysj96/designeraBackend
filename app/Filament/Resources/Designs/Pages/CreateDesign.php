<?php

namespace App\Filament\Resources\Designs\Pages;

use App\Filament\Resources\Designs\DesignResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateDesign extends CreateRecord
{
    protected static string $resource = DesignResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
