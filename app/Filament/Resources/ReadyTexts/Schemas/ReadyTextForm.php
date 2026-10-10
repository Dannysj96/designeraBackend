<?php

namespace App\Filament\Resources\ReadyTexts\Schemas;

use App\Helpers\FileManagerAction;
use App\Models\Category;
use App\Models\ParentCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReadyTextForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Ready Text Details')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        FileUpload::make('image')
                            ->label('Ready Photo (200x200)')
                            ->image()
                            ->directory('ready-texts')
                            ->imageEditor()
                            ->hintAction(FileManagerAction::make())
                            ->columnSpanFull(),

                        Select::make('parent_category_id')
                            ->label('Parent Category')
                            ->placeholder('Select an option')
                            ->options(ParentCategory::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn ($set) => $set('category_id', null))
                            ->native(false),

                        Select::make('category_id')
                            ->label('Category Type')
                            ->placeholder('Select an option')
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

                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->helperText('Suggested Sequence Number : 0')
                            ->placeholder('0')
                            ->numeric()
                            ->default(0)
                            ->required(),

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
