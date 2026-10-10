<?php

namespace App\Filament\Resources\Plans\Pages;

use App\Filament\Resources\Plans\PlanResource;
use App\Models\Plan;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListPlans extends ListRecords
{
    protected static string $resource = PlanResource::class;

    protected string $view = 'filament.resources.plans.pages.list-plans';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('New Plan'),
        ];
    }

    public function getPlansProperty()
    {
        return Plan::orderBy('id', 'asc')->get();
    }

    public function deletePlan(int $id): void
    {
        Plan::find($id)?->delete();

        Notification::make()
            ->title('Plan deleted successfully')
            ->success()
            ->send();
    }
}
