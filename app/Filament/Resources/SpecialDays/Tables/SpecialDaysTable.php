<?php

namespace App\Filament\Resources\SpecialDays\Tables;

use App\Helpers\FileManager;
use DateTimeImmutable;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SpecialDaysTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextInputColumn::make('sequence')
                    ->label('Sequence')
                    ->rules(['numeric', 'min:0'])
                    ->sortable(),
                ImageColumn::make('image')
                    ->label('Image')
                    ->state(fn ($record) => filled($record->image) ? FileManager::getThumbnailUrl($record->image) : null)
                    ->square(),
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->searchable(query: fn (Builder $query, string $search): Builder => self::applyDateSearch($query, $search))
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
            ->splitSearchTerms(false)
            ->reorderable('sequence')
            ->defaultSort(fn ($query) => $query->orderByRaw('CASE WHEN sequence > 0 THEN 0 ELSE 1 END')->orderBy('sequence', 'asc')->latest('date')->latest('id'))
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

    private static function normalizeDateSearch(string $search): ?string
    {
        foreach ([
            'Y-m-d',
            'M j, Y',
            'F j, Y',
            'M j Y',
            'F j Y',
            'd/m/Y',
            'm/d/Y',
            'j M Y',
            'j F Y',
        ] as $format) {
            $date = DateTimeImmutable::createFromFormat('!'.$format, $search);
            $errors = DateTimeImmutable::getLastErrors();

            if (
                $date !== false &&
                ($errors === false || ($errors['warning_count'] === 0 && $errors['error_count'] === 0)) &&
                strcasecmp($date->format($format), $search) === 0
            ) {
                return $date->format('Y-m-d');
            }
        }

        return null;
    }

    private static function applyDateSearch(Builder $query, string $search): Builder
    {
        $search = trim($search);
        $normalizedDate = self::normalizeDateSearch($search);

        return $query->where(function (Builder $query) use ($search, $normalizedDate): void {
            $query->where('date', 'like', "%{$search}%");

            if ($normalizedDate !== null) {
                $query->orWhereDate('date', $normalizedDate);
            }
        });
    }
}
