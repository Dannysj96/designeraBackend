<?php

namespace App\Providers;

use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production') || str_starts_with(config('app.url', ''), 'https://')) {
            try {
                if (app()->bound('request')) {
                    URL::forceScheme('https');
                }
            } catch (\Throwable $e) {
                // Ignore if request is not yet bound during bootstrap
            }
        }

        // Globally configure all Filament FileUpload components to use public storage disk and sanitize URLs properly
        FileUpload::configureUsing(function (FileUpload $fileUpload): void {
            $fileUpload->disk('public');
            $fileUpload->getUploadedFileUsing(static function (BaseFileUpload $component, string $file, string | array | null $storedFileNames): ?array {
                /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
                $storage = $component->getDisk();
                $shouldFetchFileInformation = $component->shouldFetchFileInformation();

                $size = 0;
                $type = null;

                if ($shouldFetchFileInformation) {
                    try {
                        $size = $storage->size($file);
                        $type = $storage->mimeType($file);
                    } catch (\Throwable $exception) {
                        // Ignore
                    }
                }

                $url = null;

                if ($component->getVisibility() === 'private') {
                    try {
                        $url = $storage->temporaryUrl(
                            $file,
                            now()->addMinutes(config('filament.temporary_file_url_expiry_minutes', 30))->endOfHour(),
                        );
                    } catch (\Throwable $exception) {
                    }
                }

                $url ??= $storage->url($file);

                // Encode spaces and special chars in path/filename so Str::sanitizeUrl accepts it
                $encodedUrl = preg_replace_callback('/[^\:\/@?&=#%._~-]+/', function ($matches) {
                    return rawurlencode($matches[0]);
                }, $url);

                return [
                    'name' => ($component->isMultiple() ? ($storedFileNames[$file] ?? null) : $storedFileNames) ?? basename($file),
                    'size' => $size,
                    'type' => $type,
                    'url' => Str::sanitizeUrl($encodedUrl),
                ];
            });
        });
    }
}
