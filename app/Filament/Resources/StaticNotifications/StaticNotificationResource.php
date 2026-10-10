<?php

namespace App\Filament\Resources\StaticNotifications;

use App\Filament\Resources\StaticNotifications\Pages\CreateStaticNotification;
use App\Filament\Resources\StaticNotifications\Pages\EditStaticNotification;
use App\Filament\Resources\StaticNotifications\Pages\ListStaticNotifications;
use App\Filament\Resources\StaticNotifications\Schemas\StaticNotificationForm;
use App\Filament\Resources\StaticNotifications\Tables\StaticNotificationsTable;
use App\Models\StaticNotification;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StaticNotificationResource extends Resource
{
    protected static ?string $model = StaticNotification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBell;

    protected static UnitEnum|string|null $navigationGroup = 'Notifications';

    protected static ?string $navigationLabel = 'Static Notification';

    protected static ?string $modelLabel = 'Static Notification';

    protected static ?string $pluralModelLabel = 'Static Notifications';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return StaticNotificationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StaticNotificationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStaticNotifications::route('/'),
            'create' => CreateStaticNotification::route('/create'),
            'edit' => EditStaticNotification::route('/{record}/edit'),
        ];
    }
}
