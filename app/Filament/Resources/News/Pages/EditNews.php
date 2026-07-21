<?php

namespace App\Filament\Resources\News\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\News\NewsResource;
use App\Models\News;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditNews extends EditRecord
{
        use HandlesWebpUploads;

    protected static string $resource = NewsResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($this->record->status === 'published') {
            $data['slug'] = $this->record->slug;
        } else {
            $slugSource = filled($data['slug'] ?? null)
                ? $data['slug']
                : $data['title'];

            $data['slug'] = $this->makeUniqueSlug($slugSource, $this->record->getKey());
        }

        if (($data['status'] ?? 'draft') === 'published' && blank($data['published_at'] ?? null)) {
            $data['published_at'] = now();
        }

        if (($data['status'] ?? 'draft') === 'draft') {
    $data['published_at'] = null;
}

$data = $this->processWebpUpload(
    data: $data,
    field: 'thumbnail',
    directory: 'news',
    oldPath: $this->record->thumbnail,
);

$data = $this->fillSeoFallbacks($data);

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
                ->requiresConfirmation()
                ->visible(fn (): bool => ! method_exists($this->record, 'trashed') || ! $this->record->trashed()),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    private function makeUniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value) ?: 'berita';
        $slug = $baseSlug;
        $counter = 2;

        while (
            News::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function fillSeoFallbacks(array $data): array
    {
        if (blank($data['meta_title'] ?? null)) {
            $data['meta_title'] = Str::limit($data['title'], 60, '');
        }

        if (blank($data['meta_description'] ?? null)) {
            $plainContent = trim(strip_tags((string) ($data['content'] ?? '')));
            $fallbackText = $plainContent !== '' ? $plainContent : (string) ($data['excerpt'] ?? '');

            $data['meta_description'] = Str::limit($fallbackText, 150, '');
        }

        return $data;
    }
}