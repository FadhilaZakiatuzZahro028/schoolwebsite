<?php

namespace App\Filament\Concerns;

use App\Services\ImageUploadService;

trait HandlesWebpUploads
{
    /**
     * Daftar file lama yang akan dihapus setelah record berhasil disimpan.
     *
     * @var array<int, string>
     */
    protected array $webpFilesPendingDeletion = [];

    protected function processWebpUpload(
        array $data,
        string $field,
        string $directory,
        ?string $oldPath = null,
        int $maxWidth = 1600,
        int $quality = 80,
    ): array {
        if (! array_key_exists($field, $data)) {
            return $data;
        }

        $newPath = app(ImageUploadService::class)->storeAsWebp(
            file: $data[$field],
            directory: $directory,
            maxWidth: $maxWidth,
            quality: $quality,
        );

        $data[$field] = $newPath;

        if (
            filled($oldPath)
            && $newPath !== $oldPath
        ) {
            $this->webpFilesPendingDeletion[] = $oldPath;
        }

        return $data;
    }

    protected function deleteReplacedWebpFiles(): void
    {
        $imageUploadService = app(ImageUploadService::class);

        foreach (array_unique($this->webpFilesPendingDeletion) as $path) {
            $imageUploadService->delete($path);
        }

        $this->webpFilesPendingDeletion = [];
    }
}
