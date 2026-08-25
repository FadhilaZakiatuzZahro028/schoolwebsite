<?php

namespace App\Filament\Resources\FeaturedPrograms\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\FeaturedPrograms\FeaturedProgramResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFeaturedProgram extends CreateRecord
{
    use HandlesWebpUploads;

    protected static string $resource = FeaturedProgramResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->processWebpUpload(
            data: $data,
            field: 'image',
            directory: 'featured-programs',
            maxWidth: 1600,
            quality: 80,
        );
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}