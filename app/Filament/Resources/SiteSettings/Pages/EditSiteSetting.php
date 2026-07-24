<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\SiteSettings\SiteSettingResource;
use Filament\Resources\Pages\EditRecord;

class EditSiteSetting extends EditRecord
{
    use HandlesWebpUploads;

    protected static string $resource = SiteSettingResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->processWebpUpload(
            data: $data,
            field: 'default_og_image',
            directory: 'logos/og',
            oldPath: $this->record->default_og_image,
        );
    }

    protected function afterSave(): void
    {
        $this->deleteReplacedWebpFiles();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
