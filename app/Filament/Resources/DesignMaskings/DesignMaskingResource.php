<?php

namespace App\Filament\Resources\DesignMaskings;

use App\Filament\Resources\DesignMaskings\Pages\CreateDesignMasking;
use App\Filament\Resources\DesignMaskings\Pages\EditDesignMasking;
use App\Filament\Resources\DesignMaskings\Pages\ListDesignMaskings;
use App\Filament\Resources\DesignMaskings\Schemas\DesignMaskingForm;
use App\Filament\Resources\DesignMaskings\Tables\DesignMaskingsTable;
use App\Models\DesignMasking;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DesignMaskingResource extends Resource
{
    protected static ?string $model = DesignMasking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static UnitEnum|string|null $navigationGroup = 'Design Masking';

    protected static ?string $navigationLabel = 'Design Masking';

    protected static ?string $modelLabel = 'Design Masking';

    protected static ?string $pluralModelLabel = 'Design Maskings';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return DesignMaskingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DesignMaskingsTable::configure($table);
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
            'index' => ListDesignMaskings::route('/'),
            'create' => CreateDesignMasking::route('/create'),
            'edit' => EditDesignMasking::route('/{record}/edit'),
        ];
    }
}
