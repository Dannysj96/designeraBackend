<?php

namespace App\Filament\Resources\Plans\Schemas;

use App\Helpers\FileManagerAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Plan Details')
                    ->description('Specify plan name, daily download quotas and pricing')
                    ->components([
                        FileUpload::make('image')
                            ->label('Plan Image')
                            ->image()
                            ->imageEditor()
                            ->directory('plans')
                            ->hintAction(FileManagerAction::make('select_plan_image_file'))
                            ->columnSpanFull(),

                        TextInput::make('name')
                            ->label('Plan Name')
                            ->required()
                            ->placeholder('e.g. 3 Month 599 Plan')
                            ->maxLength(50)
                            ->columnSpanFull(),

                        TextInput::make('daily_design_limit')
                            ->label('Daily Design Limit')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->helperText('Max number of designs/posts per day'),

                        TextInput::make('daily_video_limit')
                            ->label('Daily Video Limit')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->helperText('Max number of videos per day'),

                        TextInput::make('price')
                            ->label('Price (₹)')
                            ->numeric()
                            ->prefix('₹')
                            ->default(0),

                        TextInput::make('duration')
                            ->label('Duration (Days)')
                            ->numeric()
                            ->placeholder('e.g. 90 for 3 months')
                            ->helperText('Validity period in days'),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->default('active')
                            ->required(),

                        Toggle::make('is_display')
                            ->label('Show in Mobile App')
                            ->default(true)
                            ->helperText('Enable to display this plan in the mobile application'),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}
