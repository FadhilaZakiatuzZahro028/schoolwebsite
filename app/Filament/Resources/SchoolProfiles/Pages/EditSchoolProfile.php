<?php

namespace App\Filament\Resources\SchoolProfiles\Pages;

use App\Filament\Resources\SchoolProfiles\SchoolProfileResource;
use Filament\Resources\Pages\EditRecord;

class EditSchoolProfile extends EditRecord
{
    protected static string $resource = SchoolProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}