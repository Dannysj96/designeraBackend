<?php

namespace App\Filament\Resources\Sliders\Tables;

use App\Helpers\FileManager;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class SlidersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Design')
                    ->state(fn ($record) => filled($record->image) ? FileManager::getThumbnailUrl($record->image) : null)
                    ->disk('public')
                    ->square()
                    ->size(60)
                    ->action(
                        Action::make('previewImage')
                            ->modalHeading('Design Preview')
                            ->modalContent(fn ($record) => new HtmlString(
                                '<img src="'.e(FileManager::mediaUrl($record->image)).'" class="max-h-80 w-auto mx-auto rounded-lg">'
                            ))
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Close')
                            ->modalWidth('sm')
                    ),

                TextColumn::make('languages')
                    ->label('Language')
                    ->badge()
                    ->formatStateUsing(fn ($state) => config('constants.languages')[$state] ?? $state)
                    ->separator(','),

                TextColumn::make('redirect_to')
                    ->label('Redirect To')
                    ->formatStateUsing(fn ($state) => self::redirectOptions()[$state] ?? $state)
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make('link')
                    ->label('Link')
                    ->limit(30)
                    ->url(fn ($record) => $record->link, true)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('start')
                    ->label('From Date')
                    ->date('d-m-Y')
                    ->sortable(),

                TextColumn::make('end')
                    ->label('To Date')
                    ->date('d-m-Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Deactive')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d-m-Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        1 => 'Active',
                        0 => 'Deactive',
                    ]),

                SelectFilter::make('redirect_to')
                    ->label('Redirect To')
                    ->options(self::redirectOptions()),

                SelectFilter::make('languages')
                    ->label('Language')
                    ->options(config('constants.languages')),

                Filter::make('date_range')
                    ->schema([
                        DatePicker::make('from')
                            ->label('From Date'),
                        DatePicker::make('to')
                            ->label('To Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('start', '>=', $date))
                            ->when($data['to'], fn ($q, $date) => $q->whereDate('end', '<=', $date));
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    protected static function redirectOptions(): array
    {
        return [
            'special_day' => 'Todays Design',
            'upcoming_festival' => 'Tomorrow Design',
            'v_special_day' => 'Todays Video',
            'v_upcoming_festival' => 'Tomorrow Video',
            'v_design_editor' => 'Video Editor',
            'v_best_quote' => 'Best quote Video',
            'video_template' => 'Paid Video Template',
            'v_political_design' => 'Political Video',
            'special_design' => 'Special Design',
            'video' => 'Video',
            'video_type' => 'Video Type',
            'refer_and_earn' => 'Refer and Earn',
            'rate_us' => 'Rate Us',
            'add_money' => 'Add Money',
            'upgrade_plan' => 'Upgrade Plan',
            'design_editor' => 'Design Editor',
            'political_design' => 'Political Design',
            'other_services' => 'Other Services',
            'may_help' => 'May I Help You..',
            'best_quote' => 'Best Quote',
            'design_template' => 'Design Template',
            'contact_form' => 'Contact Form',
            'partner_inquiry' => 'Partner Inquiry',
            'template_profile_photos' => 'Add Template Profile Photos',
            'edit_profile' => 'Edit Profile',
        ];
    }
}
