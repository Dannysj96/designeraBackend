<?php

use App\Helpers\FileManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

Route::get('/login', fn () => redirect()->route('filament.admin.auth.login'))->name('login');

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/admin/premium-templates/create', function () {
        $qs = request()->getQueryString() ? '&'.request()->getQueryString() : '';

        return redirect('/admin/premium-templates?action=create'.$qs);
    });

    Route::get('/admin/premium-templates/{id}/edit', function ($id) {
        $qs = request()->getQueryString() ? '&'.request()->getQueryString() : '';

        return redirect('/admin/premium-templates?action=edit&id='.$id.$qs);
    });

    // File Manager API
    Route::prefix('admin/file-manager')->group(function () {

        // Serve media through Laravel storage when the public storage symlink is unavailable.
        Route::get('/media', function () {
            $validated = request()->validate([
                'path' => ['required', 'string', 'max:1024'],
            ]);
            $path = str_replace('\\', '/', trim($validated['path'], '/'));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'mp4', 'webm', 'mov', 'avi'];
            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

            abort_if(
                $path === ''
                    || collect(explode('/', $path))->contains(fn (string $segment): bool => in_array($segment, ['', '.', '..'], true))
                    || ! in_array($extension, $allowedExtensions, true),
                404,
            );

            $disk = Storage::disk('public');
            abort_unless($disk->exists($path), 404);

            return response()->file($disk->path($path), [
                'Cache-Control' => 'private, max-age=86400',
                'X-Content-Type-Options' => 'nosniff',
            ]);
        })->name('admin.file-manager.media');

        // Browse folder - returns folders + files as JSON
        Route::get('/browse', function () {
            $dir = request('dir', '');
            $folders = FileManager::getFolders($dir);
            $files = FileManager::getMediaFiles($dir);

            return response()->json([
                'currentDir' => $dir,
                'folders' => $folders,
                'files' => $files,
            ]);
        });

        // Create folder
        Route::post('/create-folder', function () {
            $parent = request('parent', '');
            $name = trim(request('name', ''));
            if (! $name) {
                return response()->json(['error' => 'Folder name required'], 422);
            }
            $created = FileManager::createFolder($parent, $name);
            if (! $created) {
                return response()->json(['error' => 'Failed to create folder. Please check directory permissions.'], 500);
            }

            return response()->json(['success' => true]);
        });

        // Delete file
        Route::delete('/delete-file', function () {
            $path = request('path', '');
            if (! $path) {
                return response()->json(['error' => 'Path required'], 422);
            }
            FileManager::deleteFile($path);

            return response()->json(['success' => true]);
        });

        // Delete folder
        Route::delete('/delete-folder', function () {
            $path = request('path', '');
            if (! $path) {
                return response()->json(['error' => 'Path required'], 422);
            }
            FileManager::deleteFolder($path);

            return response()->json(['success' => true]);
        });

        // Upload file
        Route::post('/upload', function () {
            if (! request()->hasFile('file')) {
                return response()->json(['error' => 'No file uploaded'], 422);
            }
            $file = request()->file('file');
            $dir = trim((string) request('dir', ''), '/');
            $storedPath = $file->storeAs($dir, $file->getClientOriginalName(), 'public');

            // Automatically generate compressed thumbnail
            FileManager::createThumbnail($storedPath);

            return response()->json([
                'success' => true,
                'name' => $file->getClientOriginalName(),
                'path' => $storedPath,
                'url' => FileManager::mediaUrl($storedPath),
                'thumb_url' => FileManager::getThumbnailUrl($storedPath),
            ]);
        });
    });
});
