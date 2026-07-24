<?php

namespace App\Filament\Resources\Curricula\Pages;

use App\Filament\Resources\Curricula\CurriculumResource;
use App\Services\ImageUploadService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\UploadedFile;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CreateCurriculum extends CreateRecord
{
    protected static string $resource = CurriculumResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $imageFile = $data['image_file'] ?? null;

        if (
            $imageFile instanceof UploadedFile
            || $imageFile instanceof TemporaryUploadedFile
        ) {
            $paths = app(ImageUploadService::class)
                ->storeOriginalWithWebpPreview(
                    file: $imageFile,
                    directory: 'curriculums',
                    maxWidth: 1600,
                    quality: 80,
                );

            $data['image_file'] = $paths['original'];
            $data['preview_image'] = $paths['preview'];
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
