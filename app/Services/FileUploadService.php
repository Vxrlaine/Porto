<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload a single file.
     */
    public function upload(UploadedFile $file, string $directory = 'uploads', string $disk = 'public'): string
    {
        $path = $file->storeAs(
            $directory,
            $this->generateFileName($file),
            $disk
        );

        return $path;
    }

    /**
     * Upload multiple files.
     */
    public function uploadMultiple(array $files, string $directory = 'uploads', string $disk = 'public'): array
    {
        $paths = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $this->upload($file, $directory, $disk);
            }
        }

        return $paths;
    }

    /**
     * Delete a file.
     */
    public function delete(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->delete($path);
    }

    /**
     * Delete multiple files.
     */
    public function deleteMultiple(array $paths, string $disk = 'public'): void
    {
        Storage::disk($disk)->delete($paths);
    }

    /**
     * Delete old file and upload new one.
     */
    public function replace(?string $oldPath, UploadedFile $newFile, string $directory = 'uploads', string $disk = 'public'): string
    {
        if ($oldPath) {
            $this->delete($oldPath, $disk);
        }

        return $this->upload($newFile, $directory, $disk);
    }

    /**
     * Generate a unique file name.
     */
    protected function generateFileName(UploadedFile $file): string
    {
        return Str::uuid() . '.' . $file->getClientOriginalExtension();
    }

    /**
     * Get file URL.
     */
    public function getUrl(string $path, string $disk = 'public'): string
    {
        return Storage::disk($disk)->url($path);
    }

    /**
     * Check if file exists.
     */
    public function exists(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->exists($path);
    }
}
