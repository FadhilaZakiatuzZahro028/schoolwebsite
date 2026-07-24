<?php

namespace App\Filament\Resources\Curricula\Pages;

use App\Filament\Resources\Curricula\CurriculumResource;
use App\Models\Curriculum;
use App\Services\CurriculumFileService;
use App\Services\ImageUploadService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditCurriculum extends EditRecord
{
    protected static string $resource = CurriculumResource::class;

    protected ?string $pdfFilePendingDeletion = null;

    /**
     * @var array<int, string>
     */
    protected array $imageFilesPendingDeletion = [];

    protected function mutateFormDataBeforeSave(array $data): array
{
    if (
        array_key_exists('pdf_file', $data)
        && filled($this->record->pdf_file)
        && $data['pdf_file'] !== $this->record->pdf_file
    ) {
        $this->pdfFilePendingDeletion = $this->record->pdf_file;
    }

    if (array_key_exists('image_file', $data)) {
        $imageFile = $data['image_file'];

        if (
            $imageFile instanceof UploadedFile
            || $imageFile instanceof TemporaryUploadedFile
        ) {
            $paths = app(ImageUploadService::class)
                ->storeOriginalWithWebpPreview(
                    file: $imageFile,
                    directory: 'curriculums',
                    maxWidth: 1600,
                    quality: 80,
                );

            $data['image_file'] = $paths['original'];
            $data['preview_image'] = $paths['preview'];

            $this->queueOldImageFilesForDeletion();
        } elseif (blank($imageFile) && filled($this->record->image_file)) {
            $data['image_file'] = $this->record->image_file;
            $data['preview_image'] = $this->record->preview_image;
        }
    }

    return $data;
}

    protected function afterSave(): void
    {
        if ($this->pdfFilePendingDeletion !== null) {
            Storage::disk('public')->delete(
                $this->pdfFilePendingDeletion,
            );

            $this->pdfFilePendingDeletion = null;
        }

        $imageUploadService = app(ImageUploadService::class);

        foreach (array_unique($this->imageFilesPendingDeletion) as $path) {
            $imageUploadService->delete($path);
        }

        $this->imageFilesPendingDeletion = [];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->requiresConfirmation()
                ->using(function (Curriculum $record): bool {
                    $deleted = $record->delete();

                    if ($deleted) {
                        app(CurriculumFileService::class)->deleteFiles($record);
                    }

                    return $deleted;
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    private function queueOldImageFilesForDeletion(): void
    {
        if (filled($this->record->image_file)) {
            $this->imageFilesPendingDeletion[] = $this->record->image_file;
        }

        if (filled($this->record->preview_image)) {
            $this->imageFilesPendingDeletion[] = $this->record->preview_image;
        }
    }
}
