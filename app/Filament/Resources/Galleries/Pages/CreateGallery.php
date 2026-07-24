<?php

namespace App\Filament\Resources\Galleries\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\Galleries\GalleryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGallery extends CreateRecord
{
    use HandlesWebpUploads;

    protected static string $resource = GalleryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->processWebpUpload(
            data: $data,
            field: 'image',
            directory: 'gallery',
            maxWidth: 1600,
            quality: 80,
        );
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
