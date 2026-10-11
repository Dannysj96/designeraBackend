<?php

namespace App\Filament\Resources\RegularNotifications\Tables;

use App\Helpers\FileManager;
use App\Models\RegularNotification;
use App\Services\FirebaseCloudMessagingService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;
use Throwable;

class RegularNotificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->state(fn ($record) => filled($record->image) ? FileManager::mediaUrl($record->image) : null)
                    ->square(),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('notification_type')
                    ->label('Notification Type')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('firebase_topic')
                    ->label('Firebase Topic')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('send_status')
                    ->label('Delivery')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'sent' => 'Sent',
                        'failed' => 'Failed',
                        default => 'Not sent',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'sent' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->tooltip(fn (RegularNotification $record): ?string => $record->send_error),
                TextColumn::make('sent_at')
                    ->label('Sent At')
                    ->dateTime()
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('send')
                    ->label(fn (RegularNotification $record): string => $record->send_status === 'sent' ? 'Resend' : 'Send')
                    ->icon(Heroicon::PaperAirplane)
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Send push notification now?')
                    ->modalDescription(fn (RegularNotification $record): string => "This will send “{$record->title}” to the {$record->firebase_topic} topic.")
                    ->modalSubmitActionLabel('Send now')
                    ->disabled(fn (RegularNotification $record): bool => blank($record->firebase_topic))
                    ->action(function (RegularNotification $record, FirebaseCloudMessagingService $messaging): void {
                        try {
                            $record->forceFill([
                                'send_status' => 'sending',
                                'send_error' => null,
                            ])->save();

                            $messageId = $messaging->sendRegularNotification($record);

                            $record->forceFill([
                                'send_status' => 'sent',
                                'sent_at' => now(),
                                'send_error' => null,
                            ])->save();

                            Log::info('Regular push notification sent through Firebase.', [
                                'regular_notification_id' => $record->getKey(),
                                'firebase_message_id' => $messageId,
                                'firebase_topic' => $record->firebase_topic,
                            ]);

                            Notification::make()
                                ->title('Push notification sent')
                                ->success()
                                ->send();
                        } catch (Throwable $exception) {
                            $record->forceFill([
                                'send_status' => 'failed',
                                'send_error' => mb_substr($exception->getMessage(), 0, 4000),
                            ])->save();

                            Log::error('Regular push notification failed to send.', [
                                'regular_notification_id' => $record->getKey(),
                                'firebase_topic' => $record->firebase_topic,
                                'exception' => $exception,
                            ]);

                            Notification::make()
                                ->title('Push notification failed')
                                ->body($exception->getMessage())
                                ->danger()
                                ->send();
                        }
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
