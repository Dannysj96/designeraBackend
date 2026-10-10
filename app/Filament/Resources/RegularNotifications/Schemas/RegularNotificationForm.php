<?php

namespace App\Filament\Resources\RegularNotifications\Schemas;

use App\Helpers\FileManagerAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RegularNotificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Regular Notification Details')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        TextInput::make('title')
                            ->label('Title')
                            ->placeholder('Title..')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('message')
                            ->label('Message')
                            ->placeholder('write a message here')
                            ->rows(4)
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->label('Image (200x200)')
                            ->image()
                            ->directory('regular-notifications')
                            ->imageEditor()
                            ->hintAction(FileManagerAction::make('select_regular_image'))
                            ->columnSpanFull(),

                        FileUpload::make('video')
                            ->label('Video')
                            ->directory('regular-notification-videos')
                            ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/webm'])
                            ->hintAction(FileManagerAction::make('select_regular_video'))
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

                        Select::make('firebase_topic')
                            ->label('Firebase Topic')
                            ->placeholder('Select an option')
                            ->options([
                                'all_users' => 'All Users',
                                'premium_users' => 'Premium Users',
                                'free_users' => 'Free Users',
                                'news_updates' => 'News & Updates',
                                'promotions' => 'Promotions',
                            ])
                            ->searchable()
                            ->native(false)
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
