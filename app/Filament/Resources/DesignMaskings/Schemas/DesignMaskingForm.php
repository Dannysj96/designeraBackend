<?php

namespace App\Filament\Resources\DesignMaskings\Schemas;

use App\Filament\Helpers\LocationHelper;
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

class DesignMaskingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Design Masking Details')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        FileUpload::make('design')
                            ->label('Upload Design')
                            ->image()
                            ->directory('design-maskings')
                            ->imageEditor()->imagePreviewHeight('150')
                            ->hintAction(FileManagerAction::make())
                            ->columnSpanFull(),

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
                    ]),

                Section::make('Categories Hierarchy')
                    ->columnSpanFull()
                    ->columns(3)
                    ->components([
                        Select::make('parent_category_id')
                            ->label('Parent Category')
                            ->placeholder('Select Parent Category...')
                            ->options(ParentCategory::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($set) {
                                $set('category_id', null);
                                $set('sub_category_id', null);
                            })
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
                            ->live()
                            ->afterStateUpdated(fn($set) => $set('sub_category_id', null))
                            ->native(false),

                        Select::make('sub_category_id')
                            ->label('Sub Category')
                            ->placeholder('Select Sub Category...')
                            ->options(function ($get) {
                                $categoryId = $get('category_id');
                                $parentId = $get('parent_category_id');

                                if ($categoryId) {
                                    return SubCategory::query()
                                        ->where('category_id', $categoryId)
                                        ->pluck('title', 'id');
                                }

                                if ($parentId) {
                                    return SubCategory::query()
                                        ->where('parent_category_id', $parentId)
                                        ->pluck('title', 'id');
                                }

                                return SubCategory::query()->pluck('title', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->native(false),
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
                            ->columns(2),

                        Select::make('language')
                            ->label('Language')
                            ->placeholder('Choose Language..')
                            ->options(config('constants.languages'))
                            ->searchable()
                            ->native(false)
                            ->columnSpan(1),
                    ]),

                Section::make('Location & Party')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        LocationHelper::stateSelect(),
                        LocationHelper::citySelect(),

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
