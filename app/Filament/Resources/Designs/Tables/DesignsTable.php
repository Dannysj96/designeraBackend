<?php

namespace App\Filament\Resources\Designs\Tables;

use App\Helpers\FileManager;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DesignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('design')
                    ->label('Design Image')
                    ->state(fn ($record) => filled($record->design) ? FileManager::getThumbnailUrl($record->design) : null)
                    ->square(),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('discount')
                    ->label('Discount')
                    ->sortable(),
                TextColumn::make('views')
                    ->label('Views')
                    ->default(0)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('downloads')
                    ->label('Downloads')
                    ->default(0)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (int $state): string => match ($state) {
                        1 => 'Paid - 1',
                        0 => 'Free - 0',
                        2 => 'Offer - 2',
                        default => (string) $state,
                    })
                    ->color(fn (int $state): string => match ($state) {
                        1 => 'primary',
                        0 => 'success',
                        2 => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('plan')
                    ->label('Plan')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('state')
                    ->label('State')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('only_for_today')
                    ->label('Only For Today')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
