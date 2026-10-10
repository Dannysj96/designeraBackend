<?php

namespace App\Filament\Resources\Ads\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Schemas\Components\Section;

class AdsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ad')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Upload Ad')
                            ->image()
                            ->imageEditor()
                            ->directory('ads')
                            ->maxSize(5120)
                            ->required()
                            ->columnSpanFull(),

                        Radio::make('status')
                            ->label('Status')
                            ->options([
                                1 => 'Active',
                                0 => 'Deactive',
                            ])
                            ->inline()
                            ->default(1)
                            ->required(),

                        Select::make('languages')
                            ->label('Language')
                            ->multiple()
                            ->options(config('constants.languages'))
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('redirect_to')
                            ->label('Redirect To')
                            ->options(self::redirectOptions())
                            ->searchable()
                            ->native(false)
                            ->live()
                            ->columnSpanFull(),

                        TextInput::make('link')
                            ->label('Link')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        DatePicker::make('start')
                            ->label('From Date')
                            ->native(false)
                            ->displayFormat('d-m-Y')
                            ->nullable(),

                        DatePicker::make('end')
                            ->label('To Date')
                            ->native(false)
                            ->displayFormat('d-m-Y')
                            ->afterOrEqual('start')
                            ->nullable(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected static function redirectOptions(): array
    {
        return [
            'special_day' => 'Todays Design',
            'upcoming_festival' => 'Tomorrow Design',
            'v_special_day' => 'Todays Video',
            'v_upcoming_festival' => 'Tomorrow Video',
            'v_design_editor' => 'Video Editor',
            'v_best_quote' => 'Best quote Video',
            'video_template' => 'Paid Video Template',
            'v_political_design' => 'Political Video',
            'special_design' => 'Special Design',
            'video' => 'Video',
            'video_type' => 'Video Type',
            'refer_and_earn' => 'Refer and Earn',
            'rate_us' => 'Rate Us',
            'add_money' => 'Add Money',
            'upgrade_plan' => 'Upgrade Plan',
            'design_editor' => 'Design Editor',
            'political_design' => 'Political Design',
            'other_services' => 'Other Services',
            'may_help' => 'May I Help You..',
            'best_quote' => 'Best Quote',
            'design_template' => 'Design Template',
            'contact_form' => 'Contact Form',
            'partner_inquiry' => 'Partner Inquiry',
            'template_profile_photos' => 'Add Template Profile Photos',
            'edit_profile' => 'Edit Profile',
        ];
    }
}
