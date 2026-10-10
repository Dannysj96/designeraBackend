<?php

namespace App\Filament\Resources\ParentCategories;

use App\Filament\Resources\ParentCategories\Pages\CreateParentCategory;
use App\Filament\Resources\ParentCategories\Pages\EditParentCategory;
use App\Filament\Resources\ParentCategories\Pages\ListParentCategories;
use App\Filament\Resources\ParentCategories\Schemas\ParentCategoryForm;
use App\Filament\Resources\ParentCategories\Tables\ParentCategoriesTable;
use App\Models\ParentCategory;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParentCategoryResource extends Resource
{
    protected static ?string $model = ParentCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    protected static UnitEnum|string|null $navigationGroup = 'Design Masking';

    protected static ?string $navigationLabel = 'Parent Category';

    protected static ?string $modelLabel = 'Parent Category';

    protected static ?string $pluralModelLabel = 'Parent Categories';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return ParentCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParentCategoriesTable::configure($table);
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
            'index' => ListParentCategories::route('/'),
            'create' => CreateParentCategory::route('/create'),
            'edit' => EditParentCategory::route('/{record}/edit'),
        ];
    }
}
