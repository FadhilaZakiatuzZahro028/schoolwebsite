<?php

namespace App\Filament\Resources\ChatbotKnowledge\Pages;

use App\Filament\Resources\ChatbotKnowledge\ChatbotKnowledgeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChatbotKnowledge extends EditRecord
{
    protected static string $resource = ChatbotKnowledgeResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['category'] = $data['category'] ?? 'umum';
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        return $data;
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
