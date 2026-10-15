<?php

namespace App\Filament\Resources\Coupons\Schemas;

use App\Models\Plan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Coupon Information')
                    ->columnSpanFull()
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Name')
                            ->placeholder('Name..')
                            ->required(),

                        TextInput::make('code')
                            ->label('Code')
                            ->placeholder('Code..')
                            ->required(),

                        Select::make('type')
                            ->label('Type')
                            ->options([
                                'F' => 'Fixed Price',
                                'P' => 'Percentage (%)',
                            ])
                            ->default('F')
                            ->native(false)
                            ->required(),

                        TextInput::make('total')
                            ->label('Total')
                            ->placeholder('Total..')
                            ->numeric(),

                        TextInput::make('discount')
                            ->label('Discount')
                            ->placeholder('Discount..')
                            ->numeric()
                            ->required(),

                        TextInput::make('max_discount')
                            ->label('Max Discount')
                            ->placeholder('Max Discount..')
                            ->numeric(),

                        DatePicker::make('date_start')
                            ->label('Start Date')
                            ->default(now()->toDateString())
                            ->required(),

                        DatePicker::make('date_end')
                            ->label('End Date')
                            ->default(now()->toDateString())
                            ->required(),

                        TextInput::make('uses_total')
                            ->label('Total Uses')
                            ->placeholder('Total Uses..')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        TextInput::make('uses_customer')
                            ->label('Use Per User')
                            ->placeholder('Use Per Customer..')
                            ->numeric()
                            ->default(1)
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                1 => 'Active',
                                0 => 'Deactive',
                            ])
                            ->default(1)
                            ->native(false)
                            ->required(),

                        Toggle::make('is_display')
                            ->label('Is Display Or Not ?')
                            ->default(true)
                            ->required(),

                        Select::make('user_type')
                            ->label('User Type')
                            ->options(fn () => Plan::pluck('name', 'id')->toArray() ?: [
                                'free' => 'Free',
                                'pro' => 'Pro',
                                'enterprise' => 'Enterprise',
                            ])
                            ->multiple()
                            ->searchable()
                            ->preload(),
                    ]),
            ]);
    }
}
