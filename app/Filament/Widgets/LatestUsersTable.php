<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestUsersTable extends TableWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Recent Registrations';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => User::query()->latest()->limit(5))
            ->columns([
                TextColumn::make('name')
                    ->label('User')
                    ->icon('heroicon-m-user-circle')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-m-envelope')
                    ->copyable()
                    ->copyMessage('Email copied!'),
                IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime('M d, Y h:i A')
                    ->since()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
