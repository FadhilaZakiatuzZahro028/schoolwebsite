<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Interfaces\ImageManagerInterface;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageUploadService
{
    public function __construct(
        protected ImageManagerInterface $imageManager
    ) {
    }

    public function storeAsWebp(
        UploadedFile|TemporaryUploadedFile|string|null $file,
        string $directory,
        ?string $oldPath = null,
        int $maxWidth = 1600,
        int $quality = 80
    ): ?string {
        if (is_string($file)) {
            return $file;
        }

        if ($file === null) {
            return null;
        }

        $directory = trim($directory, '/');
        $filename = now()->format('YmdHis') . '-' . Str::uuid() . '.webp';
        $path = $directory . '/' . $filename;

        Storage::disk('public')->makeDirectory($directory);

        $image = $this->imageManager->decode($file->getRealPath());

        $image->scaleDown(width: $maxWidth);

        $encodedImage = $image->encodeUsingFileExtension('webp', quality: $quality);

        Storage::disk('public')->put($path, (string) $encodedImage);

        if ($oldPath !== null && $oldPath !== $path) {
            $this->delete($oldPath);
        }

        return $path;
    }

    public function delete(?string $path): void
    {
        if ($path === null || $path === '') {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}