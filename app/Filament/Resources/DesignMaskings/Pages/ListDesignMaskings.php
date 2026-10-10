<?php

namespace App\Filament\Resources\DesignMaskings\Pages;

use App\Filament\Resources\DesignMaskings\DesignMaskingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListDesignMaskings extends ListRecords
{
    protected static string $resource = DesignMaskingResource::class;

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
