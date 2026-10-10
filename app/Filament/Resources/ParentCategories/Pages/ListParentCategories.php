<?php

namespace App\Filament\Resources\ParentCategories\Pages;

use App\Filament\Resources\ParentCategories\ParentCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListParentCategories extends ListRecords
{
    protected static string $resource = ParentCategoryResource::class;

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
}
