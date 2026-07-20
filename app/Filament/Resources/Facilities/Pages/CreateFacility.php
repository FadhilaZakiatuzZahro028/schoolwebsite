<?php

namespace App\Filament\Resources\Facilities\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\Facilities\FacilityResource;
use App\Models\Facility;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateFacility extends CreateRecord
{
    use HandlesWebpUploads;

    protected static string $resource = FacilityResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $slugSource = filled($data['slug'] ?? null)
            ? $data['slug']
            : $data['name'];

        $data['slug'] = $this->makeUniqueSlug($slugSource);

        return $this->processWebpUpload(
            data: $data,
            field: 'image',
            directory: 'facilities',
            maxWidth: 1600,
            quality: 80,
        );
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    private function makeUniqueSlug(string $value): string
    {
        $baseSlug = Str::slug($value) ?: 'fasilitas';
        $slug = $baseSlug;
        $counter = 2;

        while (Facility::query()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
