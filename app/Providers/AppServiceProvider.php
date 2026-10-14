<?php

namespace App\Providers;

use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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

        // Keep Filament uploads on public storage; Filament handles selected-file previews.
        FileUpload::configureUsing(function (FileUpload $fileUpload): void {
            $fileUpload->disk('public');
        });
    }
}
