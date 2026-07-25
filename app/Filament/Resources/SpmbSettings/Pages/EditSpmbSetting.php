<?php

namespace App\Filament\Resources\SpmbSettings\Pages;

use App\Filament\Resources\SpmbSettings\SpmbSettingResource;
use App\Services\SpmbFileService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditSpmbSetting extends EditRecord
{
    protected static string $resource = SpmbSettingResource::class;

    /**
     * @var array<int, string|null>
     */
    protected array $spmbFilesPendingDeletion = [];

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = $this->processFile(
            data: $data,
            fileField: 'information_file',
            previewField: 'information_preview',
            oldFile: $this->record->information_file,
            oldPreview: $this->record->information_preview,
        );

        return $this->processFile(
            data: $data,
            fileField: 'brochure_file',
            previewField: 'brochure_preview',
            oldFile: $this->record->brochure_file,
            oldPreview: $this->record->brochure_preview,
        );
    }

    protected function afterSave(): void
    {
        app(SpmbFileService::class)->deleteFiles(
            $this->spmbFilesPendingDeletion,
        );

        $this->spmbFilesPendingDeletion = [];
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

    private function processFile(
        array $data,
        string $fileField,
        string $previewField,
        ?string $oldFile,
        ?string $oldPreview,
    ): array {
        if (! array_key_exists($fileField, $data)) {
            return $data;
        }

        $file = $this->normalizeUploadState(
            $data[$fileField],
        );

        if (is_string($file)) {
            return $data;
        }

        if ($file === null || $file === '') {
            $data[$fileField] = null;
            $data[$previewField] = null;

            $this->queueOldFiles(
                $oldFile,
                $oldPreview,
            );

            return $data;
        }

        if (
            ! $file instanceof UploadedFile
            && ! $file instanceof TemporaryUploadedFile
        ) {
            throw new InvalidArgumentException(
                "Format unggahan {$fileField} tidak valid.",
            );
        }

        $storedFile = app(SpmbFileService::class)->store(
            file: $file,
            directory: 'spmb',
            maxWidth: 1600,
            quality: 80,
        );

        $data[$fileField] = $storedFile['original'];
        $data[$previewField] = $storedFile['preview'];

        $this->queueOldFiles(
            $oldFile,
            $oldPreview,
        );

        return $data;
    }

    private function queueOldFiles(
        ?string $oldFile,
        ?string $oldPreview,
    ): void {
        $this->spmbFilesPendingDeletion[] = $oldFile;
        $this->spmbFilesPendingDeletion[] = $oldPreview;
    }

    private function normalizeUploadState(mixed $file): mixed
    {
        if (! is_array($file)) {
            return $file;
        }

        return array_values($file)[0] ?? null;
    }
}
