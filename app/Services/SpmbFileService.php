<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use RuntimeException;

class SpmbFileService
{
    public function __construct(
        protected ImageUploadService $imageUploadService,
    ) {}

    /**
     * Simpan PDF sebagai file asli, atau gambar sebagai file asli
     * beserta preview WebP.
     *
     * @return array{original: string, preview: string|null}
     */
    public function store(
        UploadedFile|TemporaryUploadedFile $file,
        string $directory = 'spmb',
        int $maxWidth = 1600,
        int $quality = 80,
    ): array {
        $detectedMimeType = (string) $file->getMimeType();
        $clientMimeType = (string) $file->getClientMimeType();

        $isImage = str_starts_with($detectedMimeType, 'image/')
            || str_starts_with($clientMimeType, 'image/');

        if ($isImage) {
            return $this->imageUploadService
                ->storeOriginalWithWebpPreview(
                    file: $file,
                    directory: $directory,
                    maxWidth: $maxWidth,
                    quality: $quality,
                );
        }

        $isPdf = $detectedMimeType === 'application/pdf'
    || $clientMimeType === 'application/pdf';

        if ($isPdf) {
            return [
                'original' => $this->storeOriginalFile(
                    file: $file,
                    directory: $directory,
                ),
                'preview' => null,
            ];
        }

        throw new RuntimeException(
            'File SPMB harus berupa PDF atau gambar.',
        );
    }

    /**
     * @param  array<int, string|null>  $paths
     */
    public function deleteFiles(array $paths): void
    {
        $paths = array_values(array_unique(array_filter(
            $paths,
            static fn ($path): bool => is_string($path) && $path !== '',
        )));

        if ($paths === []) {
            return;
        }

        Storage::disk('public')->delete($paths);
    }

    private function storeOriginalFile(
        UploadedFile|TemporaryUploadedFile $file,
        string $directory,
    ): string {
        $directory = trim($directory, '/');

        $extension = strtolower(
            $file->getClientOriginalExtension(),
        );

        if ($extension === '') {
            $extension = $file->guessExtension() ?: 'bin';
        }

        $filename = now()->format('YmdHis')
            .'-'
            .Str::uuid()
            .'.'
            .$extension;

        Storage::disk('public')->makeDirectory($directory);

        $storedPath = Storage::disk('public')->putFileAs(
            $directory,
            $file,
            $filename,
        );

        if (! $storedPath) {
            throw new RuntimeException(
                'Gagal menyimpan file SPMB.',
            );
        }

        return $storedPath;
    }
}
