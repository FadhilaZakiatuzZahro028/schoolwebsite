<?php

namespace App\Filament\Resources\Extracurriculars\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\Extracurriculars\ExtracurricularResource;
use App\Models\Extracurricular;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateExtracurricular extends CreateRecord
{
    use HandlesWebpUploads;

    protected static string $resource = ExtracurricularResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $slugSource = filled($data['slug'] ?? null)
            ? $data['slug']
            : $data['name'];

        $data['slug'] = $this->makeUniqueSlug($slugSource);

        return $this->processWebpUpload(
            data: $data,
            field: 'image',
            directory: 'extracurriculars',
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
        $baseSlug = Str::slug($value) ?: 'ekstrakurikuler';
        $slug = $baseSlug;
        $counter = 2;

        while (Extracurricular::query()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
