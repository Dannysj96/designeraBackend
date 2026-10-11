<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileManager
{
    /**
     * Get all folders in a given directory
     */
    public static function getFolders(string $directory = ''): array
    {
        $disk = Storage::disk('public');
        $folders = [];

        try {
            $dirs = $disk->directories($directory);
            foreach ($dirs as $dir) {
                $base = basename($dir);
                // Hide system/thumbnail directories
                if ($base === '_thumbnails' || str_starts_with($base, '.')) {
                    continue;
                }

                $folders[] = [
                    'path' => $dir,
                    'name' => $base,
                    'last_modified' => $disk->exists($dir) ? date('jM Y, g:i A', $disk->lastModified($dir.'/.')) : '',
                ];
            }
        } catch (\Throwable $e) {
            // Fallback to scandir if flysystem throws an exception
            $basePath = $disk->path($directory);
            if (is_dir($basePath)) {
                $items = @scandir($basePath) ?: [];
                foreach ($items as $item) {
                    if ($item === '.' || $item === '..' || $item === '_thumbnails' || str_starts_with($item, '.')) {
                        continue;
                    }
                    $full = $basePath.'/'.$item;
                    if (is_dir($full)) {
                        $rel = $directory ? ($directory.'/'.$item) : $item;
                        $folders[] = [
                            'path' => $rel,
                            'name' => $item,
                            'last_modified' => date('jM Y, g:i A', @filemtime($full) ?: time()),
                        ];
                    }
                }
            }
        }

        return $folders;
    }

    /**
     * Get media files in a given directory (non-recursive)
     */
    public static function getMediaFiles(string $subDirectory = ''): array
    {
        $disk = Storage::disk('public');
        $mediaFiles = [];

        try {
            $files = $disk->files($subDirectory);
        } catch (\Throwable $e) {
            $files = [];
            $basePath = $disk->path($subDirectory);
            if (is_dir($basePath)) {
                $items = @scandir($basePath) ?: [];
                foreach ($items as $item) {
                    if ($item === '.' || $item === '..' || $item === '_thumbnails' || str_starts_with($item, '.')) {
                        continue;
                    }
                    $full = $basePath.'/'.$item;
                    if (is_file($full)) {
                        $files[] = $subDirectory ? ($subDirectory.'/'.$item) : $item;
                    }
                }
            }
        }

        foreach ($files as $file) {
            $base = basename($file);
            // Ignore hidden and system files/folders
            if (str_starts_with($base, '.') || str_starts_with($file, '_thumbnails')) {
                continue;
            }

            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'mp4', 'webm', 'mov', 'avi'])) {
                try {
                    $size = $disk->size($file);
                    $mtime = $disk->lastModified($file);
                } catch (\Throwable $e) {
                    $full = $disk->path($file);
                    $size = @filesize($full) ?: 0;
                    $mtime = @filemtime($full) ?: time();
                }

                $mediaFiles[] = [
                    'path' => $file,
                    'url' => self::mediaUrl($file),
                    'thumb_url' => self::getThumbnailUrl($file),
                    'name' => $base,
                    'is_video' => in_array($extension, ['mp4', 'webm', 'mov', 'avi']),
                    'size' => self::formatSize($size),
                    'last_modified' => date('jM Y, g:i A', $mtime),
                ];
            }
        }

        // Sort latest modified first
        usort($mediaFiles, fn ($a, $b) => strcmp($b['last_modified'], $a['last_modified']));

        return $mediaFiles;
    }

    /**
     * Get relative thumbnail path
     */
    public static function getThumbnailPath(string $file): string
    {
        return '_thumbnails/'.$file;
    }

    /**
     * Get thumbnail URL (creates thumbnail if not already present)
     */
    public static function getThumbnailUrl(string $file): string
    {
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
            return asset('storage/'.$file);
        }

        $thumbRel = self::getThumbnailPath($file);
        $disk = Storage::disk('public');

        if (! $disk->exists($thumbRel)) {
            self::createThumbnail($file);
        }

        if ($disk->exists($thumbRel)) {
            return self::mediaUrl($thumbRel);
        }

        return self::mediaUrl($file);
    }

    /**
     * Build an authenticated URL for media stored on the public disk.
     */
    public static function mediaUrl(string $path): string
    {
        if (filter_var($path, FILTER_VALIDATE_URL) !== false || str_starts_with($path, 'data:')) {
            return $path;
        }

        return url('/admin/file-manager/media').'?path='.rawurlencode($path);
    }

    /**
     * Generate compressed thumbnail image
     */
    public static function createThumbnail(string $filePath, int $maxWidth = 320, int $maxHeight = 320, int $quality = 80): bool
    {
        $disk = Storage::disk('public');
        if (! $disk->exists($filePath)) {
            return false;
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
            return false;
        }

        $fullSourcePath = $disk->path($filePath);
        $thumbRelativePath = self::getThumbnailPath($filePath);
        $fullThumbPath = $disk->path($thumbRelativePath);

        $thumbDir = dirname($fullThumbPath);
        if (! is_dir($thumbDir)) {
            @mkdir($thumbDir, 0775, true);
        }

        $size = @getimagesize($fullSourcePath);
        if (! $size) {
            return false;
        }

        [$origWidth, $origHeight] = $size;
        if (! $origWidth || ! $origHeight) {
            return false;
        }

        $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight, 1.0);
        $newWidth = (int) max(1, round($origWidth * $ratio));
        $newHeight = (int) max(1, round($origHeight * $ratio));

        $sourceImage = match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($fullSourcePath),
            'png' => @imagecreatefrompng($fullSourcePath),
            'webp' => @imagecreatefromwebp($fullSourcePath),
            'gif' => @imagecreatefromgif($fullSourcePath),
            default => null,
        };

        if (! $sourceImage) {
            return false;
        }

        $thumbImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG, WebP, GIF
        if (in_array($extension, ['png', 'webp', 'gif'])) {
            imagealphablending($thumbImage, false);
            imagesavealpha($thumbImage, true);
            $transparent = imagecolorallocatealpha($thumbImage, 255, 255, 255, 127);
            imagefilledrectangle($thumbImage, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        $saved = match ($extension) {
            'jpg', 'jpeg' => @imagejpeg($thumbImage, $fullThumbPath, $quality),
            'png' => @imagepng($thumbImage, $fullThumbPath, 7),
            'webp' => @imagewebp($thumbImage, $fullThumbPath, $quality),
            'gif' => @imagegif($thumbImage, $fullThumbPath),
            default => false,
        };

        return (bool) $saved;
    }

    /**
     * Create a new folder inside the given directory
     */
    public static function createFolder(string $parentDirectory, string $folderName): bool
    {
        $disk = Storage::disk('public');
        $path = trim($parentDirectory.'/'.$folderName, '/');

        return $disk->makeDirectory($path);
    }

    /**
     * Delete a file from public storage and its thumbnail
     */
    public static function deleteFile(string $path): bool
    {
        $disk = Storage::disk('public');
        if ($disk->exists($path)) {
            $thumb = self::getThumbnailPath($path);
            if ($disk->exists($thumb)) {
                $disk->delete($thumb);
            }

            return $disk->delete($path);
        }

        return false;
    }

    /**
     * Delete a folder and all its contents including thumbnails
     */
    public static function deleteFolder(string $path): bool
    {
        $disk = Storage::disk('public');
        if ($disk->exists($path)) {
            $thumbDir = '_thumbnails/'.$path;
            if ($disk->exists($thumbDir)) {
                $disk->deleteDirectory($thumbDir);
            }

            return $disk->deleteDirectory($path);
        }

        return false;
    }

    /**
     * Format bytes into human readable size
     */
    public static function formatSize(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2).' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2).' KB';
        }

        return $bytes.' bytes';
    }
}
