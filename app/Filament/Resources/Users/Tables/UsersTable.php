<?php

namespace App\Filament\Resources\Users\Tables;

use App\Helpers\FileManager;
use App\Models\Location;
use App\Models\Party;
use App\Models\Plan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                ImageColumn::make('profile_pic')
                    ->label('Photo')
                    ->circular()
                    ->state(fn ($record) => filled($record->profile_pic) ? FileManager::getThumbnailUrl($record->profile_pic) : null)
                    ->disk('public')
                    ->defaultImageUrl(fn ($record) => $record->profile_photo_url),

                TextColumn::make('name')
                    ->label('Name')
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('Mobile')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('stateLocation.name')
                    ->label('State')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('cityLocation.name')
                    ->label('City')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('partyRelation.name')
                    ->label('Party')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('plan.name')
                    ->label('Plan')
                    ->badge()
                    ->color('success')
                    ->default('No Plan')
                    ->sortable(),

                IconColumn::make('status')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('plan_id')
                    ->label('Filter by Plan')
                    ->options(fn () => Plan::pluck('name', 'id')),

                SelectFilter::make('state')
                    ->label('Filter by State')
                    ->options(fn () => Location::where('state_id', 0)->pluck('name', 'id')),

                SelectFilter::make('party')
                    ->label('Filter by Party')
                    ->options(fn () => Party::pluck('name', 'id')),

                SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
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
