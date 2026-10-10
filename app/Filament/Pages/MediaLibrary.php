<?php

namespace App\Filament\Pages;

use App\Helpers\FileManager;
use BackedEnum;
use UnitEnum;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;

class MediaLibrary extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static UnitEnum|string|null $navigationGroup = 'Designs';

    protected static ?string $navigationLabel = 'Media Library';

    protected static ?string $title = 'Media Library / File Manager';

    protected static ?string $slug = 'media-library';

    protected static ?int $navigationSort = 9;

    protected static string $view = 'filament.pages.media-library';

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    public function getMediaFilesProperty(): array
    {
        return FileManager::getMediaFiles();
    }

    public function deleteFile(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'File deleted successfully!']);
        }
    }
}
