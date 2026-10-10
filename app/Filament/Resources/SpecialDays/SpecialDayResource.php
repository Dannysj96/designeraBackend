<?php

namespace App\Filament\Resources\SpecialDays;

use App\Filament\Resources\SpecialDays\Pages\CreateSpecialDay;
use App\Filament\Resources\SpecialDays\Pages\EditSpecialDay;
use App\Filament\Resources\SpecialDays\Pages\ListSpecialDays;
use App\Filament\Resources\SpecialDays\Schemas\SpecialDayForm;
use App\Filament\Resources\SpecialDays\Tables\SpecialDaysTable;
use App\Models\SpecialDay;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SpecialDayResource extends Resource
{
    protected static ?string $model = SpecialDay::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static UnitEnum|string|null $navigationGroup = 'Designs';

    protected static ?string $navigationLabel = 'Special Days';

    protected static ?string $modelLabel = 'Special Day';

    protected static ?string $pluralModelLabel = 'Special Days';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return SpecialDayForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpecialDaysTable::configure($table);
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
            'index' => ListSpecialDays::route('/'),
            'create' => CreateSpecialDay::route('/create'),
            'edit' => EditSpecialDay::route('/{record}/edit'),
        ];
    }
}
