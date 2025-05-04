<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function upload(UploadedFile $image, string $directory = 'avatars'): string
    {
        return $image->storePublicly($directory);
    }

    public function replace(?string $oldPath, UploadedFile $newImage, string $directory = 'avatars'): string
    {
        if ($oldPath) {
            $this->delete($oldPath);
        }

        return $this->upload($newImage, $directory);
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}
