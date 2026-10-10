<?php

namespace App\Filament\Resources\StaticNotifications\Pages;

use App\Filament\Resources\StaticNotifications\StaticNotificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListStaticNotifications extends ListRecords
{
    protected static string $resource = StaticNotificationResource::class;

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
