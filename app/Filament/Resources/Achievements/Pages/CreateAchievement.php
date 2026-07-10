<?php

namespace App\Filament\Resources\Achievements\Pages;

use App\Filament\Resources\Achievements\AchievementResource;
use App\Models\Achievement;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateAchievement extends CreateRecord
{
    protected static string $resource = AchievementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $slugSource = filled($data['slug'] ?? null)
            ? $data['slug']
            : $data['title'];

        $data['slug'] = $this->makeUniqueSlug($slugSource);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    private function makeUniqueSlug(string $value): string
    {
        $baseSlug = Str::slug($value) ?: 'prestasi';
        $slug = $baseSlug;
        $counter = 2;

        while (Achievement::query()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}