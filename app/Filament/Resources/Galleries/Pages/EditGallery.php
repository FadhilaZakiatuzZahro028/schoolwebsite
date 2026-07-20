<?php

namespace App\Filament\Resources\Galleries\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\Galleries\GalleryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGallery extends EditRecord
{
    use HandlesWebpUploads;

    protected static string $resource = GalleryResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->processWebpUpload(
            data: $data,
            field: 'image',
            directory: 'gallery',
            oldPath: $this->record->image,
            maxWidth: 1600,
            quality: 80,
        );
    }

    protected function afterSave(): void
    {
        $this->deleteReplacedWebpFiles();
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->requiresConfirmation(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
