<?php

namespace App\Filament\Resources\Designs\Tables;

use App\Helpers\FileManager;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class DesignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('design')
                    ->label('Design Image')
                    ->state(fn ($record) => filled($record->design) ? FileManager::getThumbnailUrl($record->design) : null)
                    ->square()
                    ->action(
                        Action::make('previewImage')
                            ->modalHeading('Design Preview')
                            ->modalContent(fn ($record) => new HtmlString(
                                '<img src="'.e(FileManager::mediaUrl($record->design)).'" style="display:block; max-width:min(720px, 82vw); max-height:78vh; width:auto; height:auto; object-fit:contain; margin:12px auto;">'
                            ))
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Close')
                            ->modalWidth('2xl')
                    ),
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
                TextColumn::make('specialDay.name')
                    ->label('Special Day')
                    ->placeholder('N/A')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->searchable(query: fn (Builder $query, string $search): Builder => self::applyDateSearch($query, $search))
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
            ])
            ->defaultSort('date', direction: 'desc');
    }

    private static function applyDateSearch(Builder $query, string $search): Builder
    {
        $search = trim($search);
        $dateFormats = ['Y-m-d', 'M j, Y', 'F j, Y', 'm/d/Y', 'd/m/Y'];
        $normalizedDate = null;

        foreach ($dateFormats as $dateFormat) {
            $date = \DateTimeImmutable::createFromFormat('!'.$dateFormat, $search);
            $errors = \DateTimeImmutable::getLastErrors();

            if ($date !== false && ($errors === false || ($errors['warning_count'] === 0 && $errors['error_count'] === 0))) {
                $normalizedDate = $date->format('Y-m-d');
                break;
            }
        }

        return $query->where(function (Builder $dateQuery) use ($search, $normalizedDate): void {
            $dateQuery->where('date', 'like', "%{$search}%");

            if ($normalizedDate !== null) {
                $dateQuery->orWhereDate('date', $normalizedDate);
            }
        });
    }
}
