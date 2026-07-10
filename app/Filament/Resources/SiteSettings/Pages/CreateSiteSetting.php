<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Resources\Pages\CreateRecord;

class CreateSiteSetting extends CreateRecord
{
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

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}