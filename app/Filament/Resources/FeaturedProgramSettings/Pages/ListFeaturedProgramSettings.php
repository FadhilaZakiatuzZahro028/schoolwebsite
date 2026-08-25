<?php

namespace App\Filament\Resources\FeaturedProgramSettings\Pages;

use App\Filament\Resources\FeaturedProgramSettings\FeaturedProgramSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFeaturedProgramSettings extends ListRecords
{
    protected static string $resource = FeaturedProgramSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Buat Pengaturan Halaman'),
        ];
    }
}