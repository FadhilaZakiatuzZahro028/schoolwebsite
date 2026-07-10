<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Galeri Foto')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Foto')
                            ->required()
                            ->maxLength(255),

                        FileUpload::make('image')
                            ->label('File Foto')
                            ->image()
                            ->disk('public')
                            ->directory('gallery')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048)
                            ->imagePreviewHeight('180')
                            ->downloadable()
                            ->openable()
                            ->preventFilePathTampering()
                            ->required(),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(5)
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Opsional. Isi keterangan singkat kegiatan atau dokumentasi foto.'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}