<?php

namespace App\Filament\Resources\Parties\Schemas;

use App\Filament\Helpers\LocationHelper;
use App\Helpers\FileManagerAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PartyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                FileUpload::make('symbol')
                    ->image()
                    ->disk('public')
                    ->directory('party-symbols')
                    ->imageEditor()
                    ->hintAction(FileManagerAction::make())
                    ->default(null),
                LocationHelper::stateSelect(),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'deactive' => 'Deactive'
                    ])
                    ->required()
                    ->default('deactive'),
            ]);
    }
}
