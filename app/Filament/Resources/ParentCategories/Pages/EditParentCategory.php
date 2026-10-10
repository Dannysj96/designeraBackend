<?php

namespace App\Filament\Resources\ParentCategories\Pages;

use App\Filament\Resources\ParentCategories\ParentCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditParentCategory extends EditRecord
{
    protected static string $resource = ParentCategoryResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
