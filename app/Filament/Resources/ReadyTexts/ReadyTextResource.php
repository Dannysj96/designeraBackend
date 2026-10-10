<?php

namespace App\Filament\Resources\ReadyTexts;

use App\Filament\Resources\ReadyTexts\Pages\CreateReadyText;
use App\Filament\Resources\ReadyTexts\Pages\EditReadyText;
use App\Filament\Resources\ReadyTexts\Pages\ListReadyTexts;
use App\Filament\Resources\ReadyTexts\Schemas\ReadyTextForm;
use App\Filament\Resources\ReadyTexts\Tables\ReadyTextsTable;
use App\Models\ReadyText;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReadyTextResource extends Resource
{
    protected static ?string $model = ReadyText::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static UnitEnum|string|null $navigationGroup = 'Design Masking';

    protected static ?string $navigationLabel = 'Ready Text';

    protected static ?string $modelLabel = 'Ready Text';

    protected static ?string $pluralModelLabel = 'Ready Texts';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return ReadyTextForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReadyTextsTable::configure($table);
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
            'index' => ListReadyTexts::route('/'),
            'create' => CreateReadyText::route('/create'),
            'edit' => EditReadyText::route('/{record}/edit'),
        ];
    }
}
