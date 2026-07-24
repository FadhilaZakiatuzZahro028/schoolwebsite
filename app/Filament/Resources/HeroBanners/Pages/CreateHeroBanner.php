<?php

namespace App\Filament\Resources\HeroBanners\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\HeroBanners\HeroBannerResource;
use App\Models\HeroBanner;
use Filament\Resources\Pages\CreateRecord;

class CreateHeroBanner extends CreateRecord
{
    use HandlesWebpUploads;

    protected static string $resource = HeroBannerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = $this->processWebpUpload(
            data: $data,
            field: 'image',
            directory: 'heroes',
            maxWidth: 1600,
            quality: 80,
        );

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        if ($data['is_active']) {
            HeroBanner::query()->update([
                'is_active' => false,
            ]);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
