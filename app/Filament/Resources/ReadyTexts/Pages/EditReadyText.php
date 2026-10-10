<?php

namespace App\Filament\Resources\ReadyTexts\Pages;

use App\Filament\Resources\ReadyTexts\ReadyTextResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditReadyText extends EditRecord
{
    protected static string $resource = ReadyTextResource::class;

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
