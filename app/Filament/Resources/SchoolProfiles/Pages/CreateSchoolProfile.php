<?php

namespace App\Filament\Resources\SchoolProfiles\Pages;

use App\Filament\Resources\SchoolProfiles\SchoolProfileResource;
use App\Models\SchoolProfile;
use Filament\Resources\Pages\CreateRecord;

class CreateSchoolProfile extends CreateRecord
{
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

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}