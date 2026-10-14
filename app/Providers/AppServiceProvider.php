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

        // Keep Filament uploads on public storage and serve previews from the current app origin.
        FileUpload::configureUsing(function (FileUpload $fileUpload): void {
            $fileUpload->disk('public');
            $fileUpload->getUploadedFileUsing(static function (BaseFileUpload $component, mixed $file, mixed $storedFileNames): ?array {
                if (is_array($file) || is_object($file)) {
                    foreach (['path', 'file_path', 'filename', 'file_name', 'name', 'value'] as $key) {
                        $candidate = data_get($file, $key);
                        if (is_string($candidate) && $candidate !== '') {
                            $file = $candidate;
                            break;
                        }
                    }
                }

                if (! is_string($file) || $file === '') {
                    return null;
                }

                $path = ltrim(str_replace('\\', '/', $file), '/');
                if (str_starts_with($path, 'storage/')) {
                    $path = substr($path, strlen('storage/'));
                }

                $storage = $component->getDisk();
                $shouldFetchFileInformation = $component->shouldFetchFileInformation();
                $size = 0;
                $type = null;

                if ($shouldFetchFileInformation) {
                    try {
                        $size = $storage->size($path);
                        $type = $storage->mimeType($path);
                    } catch (\Throwable) {
                        return null;
                    }
                }

                $storageUrl = $storage->url($path);
                $storagePath = parse_url($storageUrl, PHP_URL_PATH);

                if (! is_string($storagePath) || $storagePath === '') {
                    return null;
                }

                $basePath = trim(request()->getBaseUrl(), '/');
                if ($basePath === '' && ($route = request()->route())) {
                    $requestSegments = explode('/', trim(request()->getPathInfo(), '/'));
                    $routeSegments = explode('/', trim($route->uri(), '/'));
                    $prefixLength = count($requestSegments) - count($routeSegments);

                    if ($prefixLength > 0) {
                        $routeMatches = true;

                        foreach ($routeSegments as $index => $routeSegment) {
                            if (preg_match('/^\{.*\}$/', $routeSegment)) {
                                continue;
                            }

                            if (rawurldecode($requestSegments[$prefixLength + $index] ?? '') !== $routeSegment) {
                                $routeMatches = false;
                                break;
                            }
                        }

                        if ($routeMatches) {
                            $basePath = implode('/', array_slice($requestSegments, 0, $prefixLength));
                        }
                    }
                }

                $storagePath = '/'.ltrim($storagePath, '/');
                $basePathPrefix = $basePath !== '' && ! str_starts_with($storagePath, '/'.$basePath.'/')
                    ? $basePath.'/'
                    : '';
                $previewPath = '/'.trim($basePathPrefix.ltrim($storagePath, '/'), '/');
                $encodedPath = implode('/', array_map(
                    static fn (string $segment): string => rawurlencode(rawurldecode($segment)),
                    explode('/', $previewPath),
                ));
                $storedFileName = $component->isMultiple() && is_array($storedFileNames)
                    ? ($storedFileNames[$file] ?? null)
                    : $storedFileNames;

                return [
                    'name' => is_string($storedFileName) && $storedFileName !== ''
                        ? $storedFileName
                        : basename($path),
                    'size' => $size,
                    'type' => $type,
                    'url' => Str::sanitizeUrl(request()->getSchemeAndHttpHost().$encodedPath),
                ];
            });
        });
    }
}
