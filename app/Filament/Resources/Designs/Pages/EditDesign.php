<?php

namespace App\Filament\Resources\Designs\Pages;

use App\Filament\Resources\Designs\DesignResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditDesign extends EditRecord
{
    protected static string $resource = DesignResource::class;

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
