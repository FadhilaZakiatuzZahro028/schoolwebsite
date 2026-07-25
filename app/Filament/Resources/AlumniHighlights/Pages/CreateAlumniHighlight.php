<?php

namespace App\Filament\Resources\AlumniHighlights\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\AlumniHighlights\AlumniHighlightResource;
use App\Models\AlumniHighlight;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateAlumniHighlight extends CreateRecord
{
    use HandlesWebpUploads;

    protected static string $resource = AlumniHighlightResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ((bool) ($data['is_active'] ?? false)) {
            try {
                AlumniHighlight::ensureActiveSlotAvailable();
            } catch (ValidationException $exception) {
                throw ValidationException::withMessages([
                    'data.is_active' => $exception->errors()['is_active'],
                ]);
            }
        }

        return $this->processWebpUpload(
            data: $data,
            field: 'photo',
            directory: 'alumni/highlights',
            maxWidth: 1200,
            quality: 80,
        );
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
