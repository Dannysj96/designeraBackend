<?php

namespace App\Filament\Resources\ParentCategories\Schemas;

use App\Helpers\FileManagerAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ParentCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Parent Category Details')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Title')
                            ->placeholder('Title..')
                            ->required()
                            ->maxLength(255),

                        FileUpload::make('image')
                            ->label('Card Icon')
                            ->image()
                            ->disk('public')
                            ->directory('parent-categories/icons')
                            ->imagePreviewHeight('100')
                            ->hintAction(FileManagerAction::make('select_parent_category_image_file')),

                        TextInput::make('sequence')
                            ->label('Sequence / Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first in the mobile app & list (e.g. 1, 2, 3...)')
                            ->placeholder('0'),

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
