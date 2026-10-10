<?php

namespace App\Filament\Resources\StaticNotifications\Pages;

use App\Filament\Resources\StaticNotifications\StaticNotificationResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateStaticNotification extends CreateRecord
{
    protected static string $resource = StaticNotificationResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
