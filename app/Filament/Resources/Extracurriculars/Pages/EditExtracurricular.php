<?php

namespace App\Filament\Resources\Extracurriculars\Pages;

use App\Filament\Resources\Extracurriculars\ExtracurricularResource;
use App\Models\Extracurricular;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditExtracurricular extends EditRecord
{
    protected static string $resource = ExtracurricularResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $slugSource = filled($data['slug'] ?? null)
            ? $data['slug']
            : $data['name'];

        $data['slug'] = $this->makeUniqueSlug($slugSource, $this->record->getKey());

        return $data;
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
        $baseSlug = Str::slug($value) ?: 'ekstrakurikuler';
        $slug = $baseSlug;
        $counter = 2;

        while (
            Extracurricular::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}