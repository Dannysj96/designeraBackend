<?php

namespace App\Filament\Resources\DesignMaskings\Pages;

use App\Filament\Resources\DesignMaskings\DesignMaskingResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateDesignMasking extends CreateRecord
{
    protected static string $resource = DesignMaskingResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
