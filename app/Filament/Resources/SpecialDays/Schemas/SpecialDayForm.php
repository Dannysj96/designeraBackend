<?php

namespace App\Filament\Resources\SpecialDays\Schemas;

use App\Helpers\FileManagerAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SpecialDayForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Special Day Information')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Name')
                            ->placeholder('Special Day Name..')
                            ->required()
                            ->maxLength(255),

                        DatePicker::make('date')
                            ->label('Date')
                            ->native(false)
                            ->default(now()),

                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->directory('special-days')
                            ->hintAction(FileManagerAction::make())
                            ->columnSpanFull(),

                        TextInput::make('sequence')
                            ->label('Sequence / Order')
                            ->helperText('Set display order: 1 = First, 2 = Second, 3 = Third... (0 = default)')
                            ->placeholder('0')
                            ->numeric()
                            ->default(0),

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
