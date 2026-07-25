<?php

namespace App\Filament\Resources\SpmbSettings\Pages;

use App\Filament\Resources\SpmbSettings\SpmbSettingResource;
use App\Services\SpmbFileService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CreateSpmbSetting extends CreateRecord
{
    protected static string $resource = SpmbSettingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = $this->processFile(
            data: $data,
            fileField: 'information_file',
            previewField: 'information_preview',
        );

        return $this->processFile(
            data: $data,
            fileField: 'brochure_file',
            previewField: 'brochure_preview',
        );
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    private function processFile(
        array $data,
        string $fileField,
        string $previewField,
    ): array {
        if (! array_key_exists($fileField, $data)) {
            return $data;
        }

        $file = $this->normalizeUploadState(
            $data[$fileField],
        );

        if ($file === null || $file === '') {
            $data[$fileField] = null;
            $data[$previewField] = null;

            return $data;
        }

        if (is_string($file)) {
            return $data;
        }

        if (
            ! $file instanceof UploadedFile
            && ! $file instanceof TemporaryUploadedFile
        ) {
            throw new InvalidArgumentException(
                "Format unggahan {$fileField} tidak valid.",
            );
        }

        $storedFile = app(SpmbFileService::class)->store(
            file: $file,
            directory: 'spmb',
            maxWidth: 1600,
            quality: 80,
        );

        $data[$fileField] = $storedFile['original'];
        $data[$previewField] = $storedFile['preview'];

        return $data;
    }

    private function normalizeUploadState(mixed $file): mixed
    {
        if (! is_array($file)) {
            return $file;
        }

        return array_values($file)[0] ?? null;
    }
}
