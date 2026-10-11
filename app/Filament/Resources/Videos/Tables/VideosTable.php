<?php

namespace App\Filament\Resources\Videos\Tables;

use App\Helpers\FileManager;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VideosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->state(fn ($record) => filled($record->thumbnail) ? FileManager::getThumbnailUrl($record->thumbnail) : null)
                    ->square(),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('discount')
                    ->label('Discount')
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
                TextColumn::make('language')
                    ->label('Language')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('specialDay.name')
                    ->label('Special Day')
                    ->placeholder('N/A')
                    ->searchable()
                    ->sortable(),
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
