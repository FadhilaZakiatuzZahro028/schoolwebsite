<?php

namespace App\Filament\Resources\SpmbSettings\Pages;

use App\Filament\Resources\SpmbSettings\SpmbSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpmbSettings extends ListRecords
{
    protected static string $resource = SpmbSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
