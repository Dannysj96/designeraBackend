<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Category Details')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        Select::make('parent_category_id')
                            ->label('Parent Category')
                            ->placeholder('Select Parent Category...')
                            ->relationship('parentCategory', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false),

                        TextInput::make('name')
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
