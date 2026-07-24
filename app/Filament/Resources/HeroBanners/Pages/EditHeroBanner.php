<?php

namespace App\Filament\Resources\HeroBanners\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\HeroBanners\HeroBannerResource;
use App\Models\HeroBanner;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHeroBanner extends EditRecord
{
    use HandlesWebpUploads;

    protected static string $resource = HeroBannerResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = $this->processWebpUpload(
            data: $data,
            field: 'image',
            directory: 'heroes',
            oldPath: $this->record->image,
            maxWidth: 1600,
            quality: 80,
        );

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        if ($data['is_active']) {
            HeroBanner::query()
                ->whereKeyNot($this->record->getKey())
                ->update([
                    'is_active' => false,
                ]);
        }

        return $data;
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
