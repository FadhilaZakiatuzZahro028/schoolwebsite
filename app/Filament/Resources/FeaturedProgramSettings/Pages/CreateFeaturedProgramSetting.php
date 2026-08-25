<?php

namespace App\Filament\Resources\FeaturedProgramSettings\Pages;

use App\Filament\Resources\FeaturedProgramSettings\FeaturedProgramSettingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFeaturedProgramSetting extends CreateRecord
{
    protected static string $resource = FeaturedProgramSettingResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl(
            'edit',
            [
                'record' => $this->record,
            ],
        );
    }
}