<?php

namespace App\Filament\Concerns;

use App\Services\ImageUploadService;

trait HandlesWebpUploads
{
    protected function processWebpUpload(
        array $data,
        string $field,
        string $directory,
        ?string $oldPath = null,
        int $maxWidth = 1600,
        int $quality = 80
    ): array {
        if (! array_key_exists($field, $data)) {
            return $data;
        }

        $data[$field] = app(ImageUploadService::class)->storeAsWebp(
            file: $data[$field],
            directory: $directory,
            oldPath: $oldPath,
            maxWidth: $maxWidth,
            quality: $quality,
        );

        return $data;
    }
}