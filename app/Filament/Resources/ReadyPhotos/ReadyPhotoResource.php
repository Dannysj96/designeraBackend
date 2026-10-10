<?php

namespace App\Filament\Resources\ReadyPhotos;

use App\Filament\Resources\ReadyPhotos\Pages\CreateReadyPhoto;
use App\Filament\Resources\ReadyPhotos\Pages\EditReadyPhoto;
use App\Filament\Resources\ReadyPhotos\Pages\ListReadyPhotos;
use App\Filament\Resources\ReadyPhotos\Schemas\ReadyPhotoForm;
use App\Filament\Resources\ReadyPhotos\Tables\ReadyPhotosTable;
use App\Models\ReadyPhoto;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReadyPhotoResource extends Resource
{
    protected static ?string $model = ReadyPhoto::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static UnitEnum|string|null $navigationGroup = 'Design Masking';

    protected static ?string $navigationLabel = 'Ready Photo';

    protected static ?string $modelLabel = 'Ready Photo';

    protected static ?string $pluralModelLabel = 'Ready Photos';

    protected static ?int $navigationSort = 9;

    public static function form(Schema $schema): Schema
    {
        return ReadyPhotoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReadyPhotosTable::configure($table);
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
            'index' => ListReadyPhotos::route('/'),
            'create' => CreateReadyPhoto::route('/create'),
            'edit' => EditReadyPhoto::route('/{record}/edit'),
        ];
    }
}
