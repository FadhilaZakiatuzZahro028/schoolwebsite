<?php

namespace App\Filament\Resources\FeaturedPrograms\Pages;

use App\Filament\Resources\FeaturedPrograms\FeaturedProgramResource;
use App\Filament\Resources\FeaturedProgramSettings\FeaturedProgramSettingResource;
use App\Models\FeaturedProgramSetting;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFeaturedPrograms extends ListRecords
{
    protected static string $resource = FeaturedProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pageSettings')
                ->label('Pengaturan Halaman')
                ->icon('heroicon-o-cog-6-tooth')
                ->url(function (): string {
                    $setting = FeaturedProgramSetting::query()
                        ->first();

                    if ($setting === null) {
                        return FeaturedProgramSettingResource::getUrl(
                            'create',
                        );
                    }

                    return FeaturedProgramSettingResource::getUrl(
                        'edit',
                        [
                            'record' => $setting->getKey(),
                        ],
                    );
                }),

            CreateAction::make()
                ->label('Tambah Program'),
        ];
    }
}