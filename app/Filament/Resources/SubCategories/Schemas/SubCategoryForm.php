<?php

namespace App\Filament\Resources\SubCategories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Sub Category Details')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        Select::make('parent_category_id')
                            ->label('Parent Category')
                            ->placeholder('Select Parent Category...')
                            ->relationship('parentCategory', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn ($set) => $set('category_id', null))
                            ->native(false),

                        Select::make('category_id')
                            ->label('Category')
                            ->placeholder('Select Category...')
                            ->options(function ($get) {
                                $parentId = $get('parent_category_id');
                                if (! $parentId) {
                                    return Category::query()->pluck('name', 'id');
                                }

                                return Category::query()
                                    ->where('parent_category_id', $parentId)
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->native(false),

                        TextInput::make('title')
                            ->label('Title')
                            ->placeholder('Title..')
                            ->required()
                            ->maxLength(255),

                        Radio::make('status')
                            ->label('Status')
                            ->options([
                                1 => 'Active - 1',
                                0 => 'Deactive - 0',
                            ])
                            ->default(1)
                            ->required(),
                    ]),
            ]);
    }
}
