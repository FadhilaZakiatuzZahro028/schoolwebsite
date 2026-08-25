<?php

namespace App\Filament\Resources\FeaturedPrograms\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\FeaturedPrograms\FeaturedProgramResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFeaturedProgram extends EditRecord
{
    use HandlesWebpUploads;

    protected static string $resource = FeaturedProgramResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->processWebpUpload(
            data: $data,
            field: 'image',
            directory: 'featured-programs',
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
                ->requiresConfirmation()
                ->visible(
                    fn (): bool => ! method_exists(
                        $this->record,
                        'trashed',
                    ) || ! $this->record->trashed(),
                ),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}