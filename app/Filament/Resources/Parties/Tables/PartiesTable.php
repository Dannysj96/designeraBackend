<?php

namespace App\Filament\Resources\Parties\Tables;

use App\Filament\Helpers\LocationHelper;
use App\Helpers\FileManagerAction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PartiesTable
{
    public static function configure(Table $table): Table
    {
        // FIXED: Derive frame keys from the config file dynamically
        // Config keys are '1', '2', '3', '4' — Labels come from the values
        $bottomFrames = config('constants.frames');        // ['1' => 'Common with protocol', ...]
        $bottomFrameKeys = array_keys($bottomFrames);      // ['1', '2', '3', '4']
        $bottomFrameLabels = array_values($bottomFrames);  // ['Common with protocol', ...]

        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('symbol'),
                TextColumn::make('state')->searchable(),
                TextColumn::make('status')->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('defaultTemplates')
                    ->label('Default Templates')
                    ->button()
                    ->color('info')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->modalHeading('Manage Default Templates')
                    ->modalWidth('6xl')
                    ->fillForm(function (Model $record) use ($bottomFrameKeys): array {
                        // Defensive: Handle margin being either an array (cast) or JSON string
                        $margin = $record->margin;
                        if (is_string($margin)) {
                            $margin = json_decode($margin, true) ?? [];
                        }

                        return [
                            'top_templates' => $record->top_image ?? [],
                            // FIXED: Map dynamic frame keys instead of hardcoded 7/8/9/10
                            'bottom_templates' => collect($record->bottom_image ?? [])
                                ->map(function (array $template) use ($bottomFrameKeys): array {
                                    $mapped = [];
                                    foreach ($bottomFrameKeys as $frameKey) {
                                        $mapped[$frameKey] = $template[$frameKey] ?? null;
                                    }

                                    return $mapped;
                                })
                                ->all(),
                            'margin_left' => $margin['margin_left'] ?? 0,
                            'margin_right' => $margin['margin_right'] ?? 0,
                            'margin_top' => $margin['margin_top'] ?? 0,
                            'margin_bottom' => $margin['margin_bottom'] ?? 0,
                        ];
                    })
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'xl' => 4,
                        ])->schema([
                            // Keep the top templates compact and give the bottom templates most of the width.
                            Section::make('Top Templates')
                                ->columnSpan(['default' => 1, 'xl' => 1])
                                ->columns(1)
                                ->schema([
                                    Repeater::make('top_templates')
                                        ->schema([
                                            FileUpload::make('top_image')
                                                ->label('Top Image')
                                                ->image()
                                                ->disk('public')
                                                ->directory('party-templates/top')
                                                ->imagePreviewHeight('92')
                                                ->panelAspectRatio('2:1')
                                                ->panelLayout('integrated')
                                                ->uploadButtonPosition('center')
                                                ->loadingIndicatorPosition('center')
                                                ->hintAction(FileManagerAction::make()->label('Browse File Manager'))
                                                ->nullable(),
                                            LocationHelper::stateSelect(false, true),
                                        ])
                                        ->columns(1)
                                        ->addActionLabel('Add New Top Template'),
                                ]),

                            // Bottom template fields use most of the available width.
                            Section::make('Bottom Templates')
                                ->columnSpan(['default' => 1, 'xl' => 3])
                                ->columns(1)
                                ->schema([
                                    Repeater::make('bottom_templates')
                                        ->schema([
                                            // Dynamically generate the file uploads from constants.php
                                            Grid::make(count($bottomFrameKeys))->schema(
                                                collect($bottomFrameKeys)->map(function (string $frameKey, int $index) use ($bottomFrameLabels) {
                                                    return FileUpload::make($frameKey)
                                                        ->label($bottomFrameLabels[$index])
                                                        ->image()
                                                        ->directory('party-templates/bottom')
                                                        ->imageEditor()
                                                        ->imagePreviewHeight('92')
                                                        ->panelAspectRatio('2:1')
                                                        ->panelLayout('integrated')
                                                        ->uploadButtonPosition('center')
                                                        ->loadingIndicatorPosition('center')
                                                        ->hintAction(FileManagerAction::make()->label('Browse File Manager'));
                                                })->toArray()
                                            ),
                                        ])
                                        ->columns(1)
                                        ->addActionLabel('Add New Bottom Template'),
                                ]),
                        ]),

                        Section::make('Margins')
                            ->schema([
                                Grid::make(4)->schema([
                                    TextInput::make('margin_left')->numeric()->default(0),
                                    TextInput::make('margin_right')->numeric()->default(0),
                                    TextInput::make('margin_top')->numeric()->default(0),
                                    TextInput::make('margin_bottom')->numeric()->default(0),
                                ]),
                            ]),
                    ])
                    ->action(function (Model $record, array $data) use ($bottomFrameKeys) {
                        // 1. Process Top Templates
                        $topTemplates = collect($data['top_templates'] ?? [])
                            ->map(fn (array $template): array => [
                                'top_image' => $template['top_image'] ?? null,
                                'state' => collect((array) ($template['state'] ?? []))
                                    ->map(fn ($stateId): string => (string) $stateId)
                                    ->values()
                                    ->all(),
                            ])
                            ->values()
                            ->all();

                        // 2. Process Bottom Templates — FIXED to use dynamic keys
                        $bottomTemplates = collect($data['bottom_templates'] ?? [])
                            ->map(function (array $template) use ($bottomFrameKeys): array {
                                $mapped = [];
                                foreach ($bottomFrameKeys as $frameKey) {
                                    $mapped[$frameKey] = $template[$frameKey] ?? null;
                                }

                                return $mapped;
                            })
                            ->values()
                            ->all();

                        // 3. Process Margins
                        $margin = [
                            'margin_left' => $data['margin_left'] ?? 0,
                            'margin_right' => $data['margin_right'] ?? 0,
                            'margin_top' => $data['margin_top'] ?? 0,
                            'margin_bottom' => $data['margin_bottom'] ?? 0,
                        ];

                        // 4. Aggregate all unique State IDs from the Top Templates
                        $allStates = collect($topTemplates)
                            ->pluck('state')
                            ->flatten()
                            ->unique()
                            ->values()
                            ->all();

                        // 5. Save to the Database
                        $record->update([
                            'top_image' => $topTemplates,
                            'bottom_image' => $bottomTemplates,
                            'states' => $allStates,
                            'margin' => $margin,
                        ]);

                        Notification::make()
                            ->title('Default templates saved successfully')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
