<?php

namespace App\Filament\Resources\FeaturedProgramSettings\Pages;

use App\Filament\Resources\FeaturedProgramSettings\FeaturedProgramSettingResource;
use Filament\Resources\Pages\EditRecord;

class EditFeaturedProgramSetting extends EditRecord
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