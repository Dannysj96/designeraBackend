<?php

namespace App\Filament\Resources\Ads;

use App\Filament\Resources\Ads\Pages\CreateAds;
use App\Filament\Resources\Ads\Pages\EditAds;
use App\Filament\Resources\Ads\Pages\ListAds;
use App\Filament\Resources\Ads\Schemas\AdsForm;
use App\Filament\Resources\Ads\Tables\AdsTable;
use App\Models\Ads;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AdsResource extends Resource
{
    protected static ?string $model = Ads::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::SpeakerWave;

    protected static UnitEnum|string|null $navigationGroup = 'Slider & Ads';

    protected static ?string $recordTitleAttribute = 'Ads';

    protected static ?int $navigationSort = 110;

    protected static ?string $navigationLabel = 'Ads';

    protected static ?string $modelLabel = 'Ads';

    protected static ?string $pluralModelLabel = 'Ads';

    public static function form(Schema $schema): Schema
    {
        return AdsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdsTable::configure($table);
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
            'index' => ListAds::route('/'),
            'create' => CreateAds::route('/create'),
            'edit' => EditAds::route('/{record}/edit'),
        ];
    }
}
