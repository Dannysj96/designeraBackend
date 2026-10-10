<?php

namespace App\Filament\Resources\Videos\Schemas;

use App\Filament\Helpers\LocationHelper;
use App\Helpers\DesignOptions;
use App\Helpers\FileManagerAction;
use App\Models\Category;
use App\Models\ParentCategory;
use App\Models\SubCategory;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Video Details')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        FileUpload::make('video')
                            ->label('Upload Videos')
                            ->directory('videos')
                            ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/webm', 'video/x-msvideo'])
                            ->maxSize(102400)
                            ->hintAction(FileManagerAction::make('select_video_file'))
                            ->columnSpan(1),

                        FileUpload::make('thumbnail')
                            ->label('Upload Thumbnail Image (200x200)')
                            ->image()
                            ->directory('video-thumbnails')
                            ->imageEditor()
                            ->hintAction(FileManagerAction::make('select_thumbnail_file'))
                            ->columnSpan(1),

                        TextInput::make('price')
                            ->label('Price')
                            ->placeholder('0')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        TextInput::make('discount')
                            ->label('Discount')
                            ->placeholder('0')
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

                        CheckboxList::make('merging')
                            ->label('Merging')
                            ->options([
                                '1' => 'Front Photo - 1',
                                '2' => 'Back Photo - 2',
                            ]),
                    ]),

                Section::make('Categories & Options')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        
                        Select::make('special_day')
                            ->label('Special Days')
                            ->placeholder('Select an option')
                            ->options(DesignOptions::getSpecialDayOptions())
                            ->searchable()
                            ->native(false)
                            ->columnSpan(1),

                        Select::make('language')
                            ->label('Language')
                            ->placeholder('Choose Language..')
                            ->options(config('constants.languages'))
                            ->searchable()
                            ->native(false)
                            ->columnSpan(1),
                    ]),

                Section::make('Plan & Frame Options')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        LocationHelper::planSelect(false),
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
                        LocationHelper::stateSelect(false),
                        LocationHelper::citySelect(false),
                        LocationHelper::partySelect(false),

                        // Select::make('display_to_user')
                        //     ->label('Display To User')
                        //     ->placeholder('Select an option')
                        //     ->options([
                        //         'all' => 'All Users',
                        //         'paid' => 'Paid Users Only',
                        //         'free' => 'Free Users Only',
                        //     ])
                        //     ->searchable()
                        //     ->native(false),
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
