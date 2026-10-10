<?php

namespace App\Filament\Resources\RegularNotifications;

use App\Filament\Resources\RegularNotifications\Pages\CreateRegularNotification;
use App\Filament\Resources\RegularNotifications\Pages\EditRegularNotification;
use App\Filament\Resources\RegularNotifications\Pages\ListRegularNotifications;
use App\Filament\Resources\RegularNotifications\Schemas\RegularNotificationForm;
use App\Filament\Resources\RegularNotifications\Tables\RegularNotificationsTable;
use App\Models\RegularNotification;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RegularNotificationResource extends Resource
{
    protected static ?string $model = RegularNotification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static UnitEnum|string|null $navigationGroup = 'Notifications';

    protected static ?string $navigationLabel = 'Regular Notification';

    protected static ?string $modelLabel = 'Regular Notification';

    protected static ?string $pluralModelLabel = 'Regular Notifications';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return RegularNotificationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RegularNotificationsTable::configure($table);
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
            'index' => ListRegularNotifications::route('/'),
            'create' => CreateRegularNotification::route('/create'),
            'edit' => EditRegularNotification::route('/{record}/edit'),
        ];
    }
}
