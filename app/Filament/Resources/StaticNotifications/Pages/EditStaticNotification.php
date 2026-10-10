<?php

namespace App\Filament\Resources\StaticNotifications\Pages;

use App\Filament\Resources\StaticNotifications\StaticNotificationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditStaticNotification extends EditRecord
{
    protected static string $resource = StaticNotificationResource::class;

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
