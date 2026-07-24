<?php

namespace App\Filament\Resources\ChatbotKnowledge;

use App\Filament\Resources\ChatbotKnowledge\Schemas\ChatbotKnowledgeForm;
use App\Filament\Resources\ChatbotKnowledge\Tables\ChatbotKnowledgeTable;
use App\Models\ChatbotKnowledge;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class ChatbotKnowledgeResource extends Resource
{
    protected static ?string $model = ChatbotKnowledge::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|UnitEnum|null $navigationGroup = 'Interaksi Pengunjung';

    protected static ?string $navigationLabel = 'FAQ Chatbot';

    protected static ?string $modelLabel = 'FAQ Chatbot';

    protected static ?string $pluralModelLabel = 'FAQ Chatbot';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ChatbotKnowledgeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChatbotKnowledgeTable::configure($table);
    }

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, ['super_admin', 'admin'], true);
    }

    public static function canCreate(): bool
    {
        return static::canViewAny();
    }

    public static function canEdit(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function canDelete(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChatbotKnowledge::route('/'),
            'create' => Pages\CreateChatbotKnowledge::route('/create'),
            'edit' => Pages\EditChatbotKnowledge::route('/{record}/edit'),
        ];
    }
}
