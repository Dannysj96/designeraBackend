<?php

namespace App\Filament\Resources\DesignMaskings\Pages;

use App\Filament\Resources\DesignMaskings\DesignMaskingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditDesignMasking extends EditRecord
{
    protected static string $resource = DesignMaskingResource::class;

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
