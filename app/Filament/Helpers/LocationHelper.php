<?php

namespace App\Filament\Helpers;

use App\Models\Location;
use App\Models\Party;
use Filament\Forms\Components\Select;
use App\Models\Plan;

class LocationHelper
{
    public static function stateSelect(bool $required = false, bool $multiple = false): Select
    {
        $select = Select::make('state')
            ->label('State')
            ->placeholder('Select an option')
            ->options(fn(): array => Location::where('state_id', 0)
                ->orWhereNull('state_id')
                ->orWhere('state_id', '')
                ->pluck('name', 'id')
                ->filter()
                ->toArray())
            ->searchable()
            ->live()
            ->afterStateUpdated(fn($set) => $set('city', null));

        if ($multiple) {
            $select->multiple();
        }

        return $required ? $select->required() : $select->nullable();
    }

    public static function citySelect(bool $required = false): Select
    {
        $select = Select::make('city')
            ->label('City')
            ->placeholder('Select an option')
            ->options(
                fn($get): array => ($state = $get('state'))
                    ? Location::where('state_id', $state)->pluck('name', 'id')->filter()->toArray()
                    : []
            )
            ->searchable()
            ->preload()
            ->live();

        return $required ? $select->required() : $select->nullable();
    }

    public static function partySelect(bool $required = false): Select
    {
        $select = Select::make('party')
            ->label('Party')
            ->placeholder('Select an option')
            ->options(
                fn(): array => Party::pluck('name', 'id')->filter()->toArray()
            )
            ->searchable();

        return $required ? $select->required() : $select->nullable();
    }

    public static function planSelect(bool $required = false): Select
    {
        $select = Select::make('plan')
            ->label('Plan')
            ->placeholder('Select an option')
            ->options(fn(): array => Plan::pluck('name', 'id')->filter()->toArray())
            ->searchable();

        return $required ? $select->required() : $select->nullable();
    }

    public static function frameSelect(): Select
    {
        return Select::make('frames')
            ->label('Frames')
            ->placeholder('Select an option')
            ->options(config('constants.frames') ?: [
                '1' => 'Common with protocol',
                '2' => 'Without Photo',
                '3' => 'Common without protocol',
                '4' => 'Blank Frame',
            ])
            ->searchable()
            ->native(false);
    }
}
