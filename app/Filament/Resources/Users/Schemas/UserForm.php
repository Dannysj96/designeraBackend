<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Helpers\FileManagerAction;
use App\Models\Language;
use App\Models\Location;
use App\Models\Party;
use App\Models\Plan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile & Basic Information')
                    ->description('Personal details and account credentials')
                    ->components([
                        FileUpload::make('profile_pic')
                            ->label('Profile Photo')
                            ->image()
                            ->avatar()
                            ->disk('public')
                            ->directory('users')
                            ->maxSize(2048)
                            ->columnSpanFull(),

                        Grid::make(2)->components([
                            TextInput::make('name')
                                ->label('Full Name')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('email')
                                ->label('Email Address')
                                ->email()
                                ->required()
                                ->maxLength(255),

                            TextInput::make('password')
                                ->label('Password')
                                ->password()
                                ->revealable()
                                ->required(fn (string $operation): bool => $operation === 'create')
                                ->dehydrated(fn (?string $state): bool => filled($state))
                                ->helperText('Leave blank to keep current password when editing'),

                            TextInput::make('phone')
                                ->label('Mobile / Phone Number')
                                ->tel()
                                ->maxLength(20),

                            Select::make('status')
                                ->label('Account Status')
                                ->options([
                                    1 => 'Active',
                                    0 => 'Inactive',
                                ])
                                ->default(1)
                                ->required(),

                            Select::make('language')
                                ->label('Preferred Language')
                                ->options(function () {
                                    try {
                                        $langs = Language::orderBy('sort_order')->pluck('english_name', 'id')->filter()->toArray();
                                        if (! empty($langs)) {
                                            return $langs;
                                        }
                                    } catch (\Throwable $e) {}
                                    return [
                                        1 => 'English',
                                        2 => 'Hindi (हिंदी)',
                                        5 => 'Marathi (मराठी)',
                                        4 => 'Gujarati (ગુજરાતી)',
                                        6 => 'Punjabi (ਪੰਜਾਬੀ)',
                                        8 => 'Kannada (ಕನ್ನಡ)',
                                        10 => 'Tamil (தமிழ்)',
                                    ];
                                })
                                ->searchable()
                                ->preload()
                                ->default(1),

                            DateTimePicker::make('email_verified_at')
                                ->label('Email Verified At'),
                        ]),
                    ]),

                Section::make('Subscription & Plan Details')
                    ->description('Active subscription plan, validity dates, and wallet balance')
                    ->components([
                        Grid::make(2)->components([
                            Select::make('plan_id')
                                ->label('Assigned Plan')
                                ->options(fn () => Plan::orderBy('name')->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->placeholder('Select Plan'),

                            TextInput::make('balance')
                                ->label('Wallet Balance (₹)')
                                ->numeric()
                                ->prefix('₹')
                                ->default(0.00),

                            DatePicker::make('start_date')
                                ->label('Plan Start Date'),

                            DatePicker::make('expiry_date')
                                ->label('Plan Expiry Date'),
                        ]),
                    ]),

                Section::make('Location & Political / Designation Details')
                    ->description('State, City, Party affiliation, and official designations')
                    ->components([
                        Grid::make(2)->components([
                            Select::make('state')
                                ->label('State')
                                ->options(fn () => Location::where('state_id', 0)->orderBy('name')->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->live()
                                ->placeholder('Select State')
                                ->afterStateUpdated(fn (callable $set) => $set('city', null)),

                            Select::make('city')
                                ->label('City')
                                ->options(function (callable $get) {
                                    $stateId = $get('state');
                                    if (! $stateId) {
                                        return Location::where('state_id', '>', 0)->orderBy('name')->pluck('name', 'id');
                                    }
                                    return Location::where('state_id', $stateId)->orderBy('name')->pluck('name', 'id');
                                })
                                ->searchable()
                                ->preload()
                                ->placeholder('Select City'),

                            Select::make('party')
                                ->label('Party / Organization')
                                ->options(fn () => Party::orderBy('name')->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->placeholder('Select Party'),

                            TextInput::make('designation_1')
                                ->label('Designation 1 (Primary)')
                                ->placeholder('e.g. President / General Secretary')
                                ->maxLength(150),

                            TextInput::make('designation_2')
                                ->label('Designation 2 (Secondary)')
                                ->placeholder('e.g. Committee Member')
                                ->maxLength(150),
                        ]),
                    ]),

                Section::make('Download Limits & Media Privileges')
                    ->description('Daily quota limits and watermark/copyright bypass settings')
                    ->components([
                        Grid::make(2)->components([
                            TextInput::make('video_daily_download_limit')
                                ->label('Daily Download Limit (Video)')
                                ->numeric()
                                ->default(10)
                                ->minValue(0)
                                ->helperText('Max number of videos user can download per day (0 = none)'),

                            TextInput::make('design_daily_download_limit')
                                ->label('Daily Download Limit (Design / Post)')
                                ->numeric()
                                ->default(20)
                                ->minValue(0)
                                ->helperText('Max number of image/design posts user can download per day (0 = none)'),

                            Toggle::make('remove_copyright')
                                ->label('Allow Remove Copyright')
                                ->helperText('When enabled, user downloads content without brand copyright text')
                                ->default(false),

                            Toggle::make('remove_watermark')
                                ->label('Allow Remove Watermark')
                                ->helperText('When enabled, user downloads content without watermark logo')
                                ->default(false),
                        ]),
                    ]),

                Section::make('Social Media & Contact Links')
                    ->description('WhatsApp and social media handles / URLs')
                    ->components([
                        Grid::make(2)->components([
                            TextInput::make('whatsapp')
                                ->label('WhatsApp Number')
                                ->tel()
                                ->placeholder('+91 9876543210')
                                ->maxLength(20),

                            TextInput::make('facebook')
                                ->label('Facebook Profile URL')
                                ->url()
                                ->placeholder('https://facebook.com/username')
                                ->maxLength(255),

                            TextInput::make('twitter')
                                ->label('Twitter / X Profile')
                                ->placeholder('https://x.com/username or @username')
                                ->maxLength(255),

                            TextInput::make('instagram')
                                ->label('Instagram Profile')
                                ->placeholder('https://instagram.com/username or @username')
                                ->maxLength(255),
                        ]),
                    ]),
            ]);
    }
}
