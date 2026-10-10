<?php

namespace App\Filament\Resources\RegularNotifications\Pages;

use App\Filament\Resources\RegularNotifications\RegularNotificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListRegularNotifications extends ListRecords
{
    protected static string $resource = RegularNotificationResource::class;

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
