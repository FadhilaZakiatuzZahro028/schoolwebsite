<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Resources\Pages\CreateRecord;

class CreateSiteSetting extends CreateRecord
{
        use HandlesWebpUploads;
    protected static string $resource = SiteSettingResource::class;

    public function mount(): void
    {
        $existingSetting = SiteSetting::query()->first();

        if ($existingSetting !== null) {
            $this->redirect(static::getResource()::getUrl('edit', [
                'record' => $existingSetting->getKey(),
            ]));

            return;
        }

        parent::mount();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
{
    return $this->processWebpUpload(
        data: $data,
        field: 'default_og_image',
        directory: 'logos/og',
    );
}

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}