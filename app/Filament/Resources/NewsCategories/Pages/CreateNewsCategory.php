<?php

namespace App\Filament\Resources\NewsCategories\Pages;

use App\Filament\Resources\NewsCategories\NewsCategoryResource;
use App\Models\NewsCategory;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateNewsCategory extends CreateRecord
{
    protected static string $resource = NewsCategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $slugSource = filled($data['slug'] ?? null)
            ? $data['slug']
            : $data['name'];

        $data['slug'] = $this->makeUniqueSlug($slugSource);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    private function makeUniqueSlug(string $value): string
    {
        $baseSlug = Str::slug($value) ?: 'kategori-berita';
        $slug = $baseSlug;
        $counter = 2;

        while (NewsCategory::query()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}