<?php

namespace App\Filament\Resources\StaticNotifications\Schemas;

use App\Helpers\FileManagerAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StaticNotificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Notification Media & Type')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        FileUpload::make('image')
                            ->label('Image (200x200)')
                            ->image()
                            ->directory('notifications')
                            ->imageEditor()
                            ->hintAction(FileManagerAction::make('select_notification_image'))
                            ->columnSpanFull(),

                        FileUpload::make('video')
                            ->label('Video')
                            ->directory('notification-videos')
                            ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/webm'])
                            ->hintAction(FileManagerAction::make('select_notification_video'))
                            ->columnSpanFull(),

                        Select::make('notification_type')
                            ->label('Select Notification Type')
                            ->placeholder('Select Type')
                            ->options([
                                'general' => 'General',
                                'promo' => 'Promo',
                                'update' => 'App Update',
                                'custom' => 'Custom Offer',
                            ])
                            ->searchable()
                            ->native(false),

                        Select::make('sub_type')
                            ->label('N / A (Sub Type)')
                            ->helperText('Note : Please Select Sub Type According to Your Notification Type..!')
                            ->placeholder('Select an option')
                            ->options([
                                'sub_1' => 'Sub Type 1',
                                'sub_2' => 'Sub Type 2',
                                'sub_3' => 'Sub Type 3',
                            ])
                            ->searchable()
                            ->native(false),
                    ]),

                Section::make('Target User & Schedule')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        CheckboxList::make('user_plan')
                            ->label('User Plan')
                            ->options([
                                'basic' => 'Basic Plan',
                                'standard' => 'Standard Plan',
                                'premium' => 'Premium Plan',
                                'all' => 'All Users',
                            ])
                            ->bulkToggleable()
                            ->columns(2)
                            ->columnSpanFull(),

                        Radio::make('status')
                            ->label('Status')
                            ->options([
                                1 => 'Enabled',
                                0 => 'Disabled',
                            ])
                            ->default(1)
                            ->required(),

                        Select::make('language')
                            ->label('Language')
                            ->placeholder('Choose Language..')
                            ->options([
                                'marathi' => 'Marathi',
                                'hindi' => 'Hindi',
                                'english' => 'English',
                                'gujarati' => 'Gujarati',
                            ])
                            ->searchable()
                            ->native(false),

                        DateTimePicker::make('start_time')
                            ->label('Start Time')
                            ->placeholder('Choose start date')
                            ->default(now()),

                        DateTimePicker::make('end_time')
                            ->label('End Time')
                            ->placeholder('Choose end date'),
                    ]),

                Section::make('Location & Party Target')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        Select::make('state')
                            ->label('State')
                            ->placeholder('Select an option')
                            ->options([
                                'maharashtra' => 'Maharashtra',
                                'gujarat' => 'Gujarat',
                                'delhi' => 'Delhi',
                                'karnataka' => 'Karnataka',
                            ])
                            ->searchable()
                            ->native(false)
                            ->columnSpanFull(),

                        CheckboxList::make('city')
                            ->label('City')
                            ->options([
                                'mumbai' => 'Mumbai',
                                'pune' => 'Pune',
                                'nagpur' => 'Nagpur',
                                'nashik' => 'Nashik',
                                'aurangabad' => 'Chhatrapati Sambhajinagar',
                            ])
                            ->bulkToggleable()
                            ->columns(2),

                        CheckboxList::make('party')
                            ->label('Party')
                            ->options([
                                'bjp' => 'BJP',
                                'inc' => 'INC (Congress)',
                                'ncp' => 'NCP',
                                'ss' => 'Shiv Sena',
                                'mns' => 'MNS',
                                'aap' => 'AAP',
                            ])
                            ->bulkToggleable()
                            ->columns(2),
                    ]),
            ]);
    }
}
