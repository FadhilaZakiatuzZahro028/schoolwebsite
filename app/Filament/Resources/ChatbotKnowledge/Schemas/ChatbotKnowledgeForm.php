<?php

namespace App\Filament\Resources\ChatbotKnowledge\Schemas;

use App\Models\ChatbotKnowledge;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ChatbotKnowledgeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data FAQ Chatbot')
                    ->description('Isi pasangan kata kunci dan jawaban yang akan dipakai chatbot lokal.')
                    ->schema([
                        Select::make('category')
                            ->label('Kategori')
                            ->options(ChatbotKnowledge::CATEGORY_OPTIONS)
                            ->default('umum')
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan jika FAQ ini belum ingin dipakai oleh chatbot.'),

                        Textarea::make('keywords')
                            ->label('Kata Kunci')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Pisahkan kata kunci dengan koma. Contoh: alamat, lokasi, dimana sekolah, maps'),

                        Textarea::make('answer')
                            ->label('Jawaban Chatbot')
                            ->required()
                            ->rows(8)
                            ->columnSpanFull()
                            ->helperText('Jawaban harus spesifik seputar SMA PGRI 1 Tulungagung. Jangan isi jawaban di luar topik sekolah.'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
