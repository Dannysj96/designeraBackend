<?php

namespace App\Filament\Resources\RegularNotifications\Pages;

use App\Filament\Resources\RegularNotifications\RegularNotificationResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateRegularNotification extends CreateRecord
{
    protected static string $resource = RegularNotificationResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
