<?php

namespace App\Filament\Resources\AlumniHighlights\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\AlumniHighlights\AlumniHighlightResource;
use App\Models\AlumniHighlight;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditAlumniHighlight extends EditRecord
{
    use HandlesWebpUploads;

    protected static string $resource = AlumniHighlightResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ((bool) ($data['is_active'] ?? false)) {
            try {
                AlumniHighlight::ensureActiveSlotAvailable(
                    ignoredId: (int) $this->record->getKey(),
                );
            } catch (ValidationException $exception) {
                throw ValidationException::withMessages([
                    'data.is_active' => $exception->errors()['is_active'],
                ]);
            }
        }

        return $this->processWebpUpload(
            data: $data,
            field: 'photo',
            directory: 'alumni/highlights',
            oldPath: $this->record->photo,
            maxWidth: 1200,
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
