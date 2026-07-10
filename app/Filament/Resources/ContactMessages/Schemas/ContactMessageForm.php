<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Pengirim')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Pengirim')
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('email')
                            ->label('Email')
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('phone')
                            ->label('Nomor HP')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('-'),

                        TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Isi Pesan')
                    ->schema([
                        TextInput::make('subject')
                            ->label('Subjek')
                            ->disabled()
                            ->dehydrated(false),

                        Textarea::make('message')
                            ->label('Pesan')
                            ->rows(8)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        Toggle::make('is_read')
                            ->label('Tandai Sudah Dibaca')
                            ->helperText('Aktifkan jika pesan ini sudah dibaca oleh admin.'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}