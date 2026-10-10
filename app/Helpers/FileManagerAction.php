<?php

namespace App\Helpers;

use Filament\Actions\Action;

class FileManagerAction
{
    public static function make(string $name = 'open_file_manager'): Action
    {
        return Action::make($name)
            ->label('File Manager')
            ->icon('heroicon-o-folder-open')
            ->color('gray')
            ->modalHeading('')
            ->modalDescription(null)
            ->modalWidth('7xl')
            ->modalSubmitAction(false)
            ->modalCancelAction(false)
            ->modalContent(view('filament.components.file-manager-modal-content'));
    }
}
