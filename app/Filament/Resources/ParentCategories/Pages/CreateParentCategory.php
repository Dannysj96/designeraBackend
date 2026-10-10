<?php

namespace App\Filament\Resources\ParentCategories\Pages;

use App\Filament\Resources\ParentCategories\ParentCategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateParentCategory extends CreateRecord
{
    protected static string $resource = ParentCategoryResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
