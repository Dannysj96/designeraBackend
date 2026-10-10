<?php

namespace App\Filament\Resources\Designs\Schemas;

use App\Filament\Helpers\LocationHelper;
use App\Helpers\DesignOptions;
use App\Helpers\FileManagerAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DesignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Design Details')
                    ->columnSpanFull()
                    ->components([
                        Grid::make(['default' => 1, 'lg' => 2])
                            ->schema([
                                FileUpload::make('design')
                                    ->label('Upload Design')
                                    ->image()
                                    ->directory('designs')
                                    ->imageEditor()
                                    ->imagePreviewHeight('200')
                                    // ->panelAspectRatio('1:1')
                                    ->hintAction(FileManagerAction::make()),

                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('price')
                                            ->label('Price')
                                            ->placeholder('Price..')
                                            ->numeric()
                                            ->default(0)
                                            ->required(),

                                        TextInput::make('discount')
                                            ->label('Discount')
                                            ->placeholder('Discount..')
                                            ->numeric()
                                            ->default(0)
                                            ->required(),

                                        Radio::make('status')
                                            ->label('Status')
                                            ->options([
                                                1 => 'Paid - 1',
                                                0 => 'Free - 0',
                                                2 => 'Offer - 2',
                                            ])
                                            ->default(1)
                                            ->inline(false)
                                            ->required(),

                                        Section::make('Photo Options')
                                            ->columnSpan(1)
                                            ->columns(2)
                                            ->components([
                                                Checkbox::make('front_img')
                                                    ->label('Front Img')
                                                    ->default(false),

                                                Checkbox::make('back')
                                                    ->label('Back')
                                                    ->default(false),
                                            ]),

                                        Select::make('special_day')
                                            ->label('Special Days')
                                            ->placeholder('Select an option')
                                            ->options(DesignOptions::getSpecialDayOptions())
                                            ->searchable()
                                            ->native(false)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),

                Section::make('Plan & Frame Options')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        LocationHelper::planSelect(),
                        LocationHelper::frameSelect(),
                        Textarea::make('caption')
                            ->label('Caption')
                            ->placeholder('Caption..')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Location & Party')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        LocationHelper::stateSelect(),
                        LocationHelper::citySelect(),
                        LocationHelper::partySelect(),
                    ]),

                Section::make('Watermark & Display Settings')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        DatePicker::make('date')
                            ->label('Date')
                            ->default(now()),

                        TextInput::make('up_to_days')
                            ->label('Up To Days')
                            ->placeholder('Up To Days..'),

                        Radio::make('show_in_slider')
                            ->label('Show In Slider ?')
                            ->options([
                                1 => 'Yes - 1',
                                0 => 'No - 0',
                            ])
                            ->default(0),

                        Radio::make('copyright_position')
                            ->label('Copyright Position')
                            ->options([
                                'Left' => 'Left',
                                'Right' => 'Right',
                                'No' => 'No',
                            ])
                            ->default('Left'),

                        Radio::make('remove_watermark')
                            ->label('Remove Watermark ?')
                            ->options([
                                1 => 'Yes - 1',
                                0 => 'No - 0',
                            ])
                            ->default(0),
                    ]),
            ]);
    }
}
