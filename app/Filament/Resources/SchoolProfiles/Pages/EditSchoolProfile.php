<?php

namespace App\Filament\Resources\SchoolProfiles\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\SchoolProfiles\SchoolProfileResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditSchoolProfile extends EditRecord
{
    use HandlesWebpUploads;

    protected ?string $ppdbBrochurePendingDeletion = null;

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

        $data = $this->processWebpUpload(
            data: $data,
            field: 'favicon',
            directory: 'logos',
            oldPath: $this->record->favicon,
            maxWidth: 512,
        );

        if (
            array_key_exists('ppdb_brochure', $data)
            && filled($this->record->ppdb_brochure)
            && $data['ppdb_brochure'] !== $this->record->ppdb_brochure
        ) {
            $this->ppdbBrochurePendingDeletion = $this->record->ppdb_brochure;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $this->deleteReplacedWebpFiles();

        if ($this->ppdbBrochurePendingDeletion !== null) {
            Storage::disk('public')->delete(
                $this->ppdbBrochurePendingDeletion,
            );

            $this->ppdbBrochurePendingDeletion = null;
        }
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
