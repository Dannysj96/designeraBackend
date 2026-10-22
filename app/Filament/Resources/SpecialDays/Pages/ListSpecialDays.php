<?php

namespace App\Filament\Resources\SpecialDays\Pages;

use App\Filament\Resources\SpecialDays\SpecialDayResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ListSpecialDays extends ListRecords
{
    protected static string $resource = SpecialDayResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()->label('All'),
            'today' => Tab::make()->label('Today')->modifyQueryUsing(
                fn (Builder $query): Builder => $this->queryForDate($query, now()),
            ),
            'tomorrow' => Tab::make()->label('Tomorrow')->modifyQueryUsing(
                fn (Builder $query): Builder => $this->queryForDate($query, now()->addDay()),
            ),
        ];
    }

    private function queryForDate(Builder $query, Carbon $target): Builder
    {
        return $query->where(function (Builder $query) use ($target): void {
            $query->whereDate('date', $target->toDateString())
                ->orWhereDate('s_date', $target->toDateString())
                ->orWhere(function (Builder $query) use ($target): void {
                    $query->whereMonth('date', $target->month)
                        ->whereDay('date', $target->day);
                });
        });
    }
}
