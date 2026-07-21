<?php

namespace App\Filament\Resources\SchoolProfiles\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\SchoolProfiles\SchoolProfileResource;
use App\Models\SchoolProfile;
use Filament\Resources\Pages\CreateRecord;

class CreateSchoolProfile extends CreateRecord
{
    use HandlesWebpUploads;

    protected static string $resource = SchoolProfileResource::class;

    public function mount(): void
    {
        $existingProfile = SchoolProfile::query()->first();

        if ($existingProfile !== null) {
            $this->redirect(static::getResource()::getUrl('edit', [
                'record' => $existingProfile->getKey(),
            ]));

            return;
        }

        parent::mount();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = $this->processWebpUpload(
            data: $data,
            field: 'logo',
            directory: 'logos',
            maxWidth: 1200,
        );

        return $this->processWebpUpload(
            data: $data,
            field: 'favicon',
            directory: 'logos',
            maxWidth: 512,
        );
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
