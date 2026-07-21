<?php

namespace App\Filament\Resources\News\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\News\NewsResource;
use App\Models\News;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateNews extends CreateRecord
{
    use HandlesWebpUploads;
    protected static string $resource = NewsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $slugSource = filled($data['slug'] ?? null)
            ? $data['slug']
            : $data['title'];

        $data['slug'] = $this->makeUniqueSlug($slugSource);
        $data['author_id'] = auth()->id();
        $data['view_count'] = $data['view_count'] ?? 0;

        if (($data['status'] ?? 'draft') === 'published' && blank($data['published_at'] ?? null)) {
            $data['published_at'] = now();
        }

       if (($data['status'] ?? 'draft') === 'draft') {
    $data['published_at'] = null;
}

$data = $this->processWebpUpload(
    data: $data,
    field: 'thumbnail',
    directory: 'news',
);

$data = $this->fillSeoFallbacks($data);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    private function makeUniqueSlug(string $value): string
    {
        $baseSlug = Str::slug($value) ?: 'berita';
        $slug = $baseSlug;
        $counter = 2;

        while (News::query()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function fillSeoFallbacks(array $data): array
    {
        if (blank($data['meta_title'] ?? null)) {
            $data['meta_title'] = Str::limit($data['title'], 60, '');
        }

        if (blank($data['meta_description'] ?? null)) {
            $plainContent = trim(strip_tags((string) ($data['content'] ?? '')));
            $fallbackText = $plainContent !== '' ? $plainContent : (string) ($data['excerpt'] ?? '');

            $data['meta_description'] = Str::limit($fallbackText, 150, '');
        }

        return $data;
    }
}