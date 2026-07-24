<?php

namespace App\Filament\Resources\ChatbotKnowledge\Pages;

use App\Filament\Resources\ChatbotKnowledge\ChatbotKnowledgeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChatbotKnowledge extends ListRecords
{
    protected static string $resource = ChatbotKnowledgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Buat FAQ Chatbot'),
        ];
    }
}
