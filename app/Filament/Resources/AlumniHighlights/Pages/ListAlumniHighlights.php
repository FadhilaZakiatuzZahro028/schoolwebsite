<?php

namespace App\Filament\Resources\AlumniHighlights\Pages;

use App\Filament\Resources\AlumniHighlights\AlumniHighlightResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlumniHighlights extends ListRecords
{
    protected static string $resource = AlumniHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Alumni Pilihan'),
        ];
    }
}
