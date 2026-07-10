<?php

namespace App\Filament\Resources\ChatbotKnowledge\Pages;

use App\Filament\Resources\ChatbotKnowledge\ChatbotKnowledgeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateChatbotKnowledge extends CreateRecord
{
    protected static string $resource = ChatbotKnowledgeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['category'] = $data['category'] ?? 'umum';
        $data['is_active'] = (bool) ($data['is_active'] ?? true);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}