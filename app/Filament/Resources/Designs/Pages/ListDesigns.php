<?php

namespace App\Filament\Resources\Designs\Pages;

use App\Filament\Resources\Designs\DesignResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListDesigns extends ListRecords
{
    protected static string $resource = DesignResource::class;

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
