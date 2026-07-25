<?php

namespace App\Filament\Resources\SchoolProfiles\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\SchoolProfiles\SchoolProfileResource;
use Filament\Resources\Pages\EditRecord;

class EditSchoolProfile extends EditRecord
{
    use HandlesWebpUploads;

    protected static string $resource = SchoolProfileResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = $this->processWebpUpload(
            data: $data,
            field: 'logo',
            directory: 'logos',
            oldPath: $this->record->logo,
            maxWidth: 1200,
        );

        return $this->processWebpUpload(
            data: $data,
            field: 'favicon',
            directory: 'logos',
            oldPath: $this->record->favicon,
            maxWidth: 512,
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
