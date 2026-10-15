<?php

namespace App\Filament\Resources\Coupons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CouponsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'F' => 'Fixed Price',
                        'P' => 'Percentage (%)',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'F' => 'info',
                        'P' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('discount')
                    ->label('Discount')
                    ->sortable(),
                TextColumn::make('max_discount')
                    ->label('Max Discount')
                    ->sortable(),
                TextColumn::make('date_start')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_end')
                    ->label('End Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('uses_total')
                    ->label('Total Uses')
                    ->sortable(),
                TextColumn::make('uses_customer')
                    ->label('Use Per User')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        '1' => 'Active',
                        '0' => 'Deactive',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                        default => 'gray',
                    }),
                IconColumn::make('is_display')
                    ->label('Is Display?')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
