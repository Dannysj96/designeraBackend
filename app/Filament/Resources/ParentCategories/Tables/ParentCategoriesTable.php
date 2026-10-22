<?php

namespace App\Filament\Resources\ParentCategories\Tables;

use App\Models\ParentCategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class ParentCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sequence')
                    ->label('Sequence')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Title')
                    ->searchable()
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
            ->reorderable('sequence')
            ->afterReordering(function (array $order): void {
                DB::transaction(function () use ($order): void {
                    foreach ($order as $index => $recordKey) {
                        ParentCategory::query()
                            ->whereKey($recordKey)
                            ->update(['sequence' => $index + 1]);
                    }
                });
            })
            ->defaultSort(fn ($query) => $query->orderByRaw('CASE WHEN sequence > 0 THEN 0 ELSE 1 END')->orderBy('sequence', 'asc')->latest('id'))
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
