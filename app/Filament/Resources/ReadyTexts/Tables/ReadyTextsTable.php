<?php

namespace App\Filament\Resources\ReadyTexts\Tables;

use App\Helpers\FileManager;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReadyTextsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Ready Text')
                    ->state(fn ($record) => filled($record->image) ? FileManager::getThumbnailUrl($record->image) : null)
                    ->square(),
                TextColumn::make('parentCategory.name')
                    ->label('Parent Category')
                    ->placeholder('N/A')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Category Type')
                    ->placeholder('N/A')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Sort Order')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (int $state): string => $state === 1 ? 'Active' : 'Deactive')
                    ->color(fn (int $state): string => $state === 1 ? 'success' : 'danger'),
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
