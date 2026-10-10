<?php

namespace App\Filament\Resources\RegularNotifications\Pages;

use App\Filament\Resources\RegularNotifications\RegularNotificationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditRegularNotification extends EditRecord
{
    protected static string $resource = RegularNotificationResource::class;

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
