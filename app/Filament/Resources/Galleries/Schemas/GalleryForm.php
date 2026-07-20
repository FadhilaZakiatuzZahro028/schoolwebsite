<?php

namespace App\Filament\Resources\Galleries\Schemas;

use App\Filament\Forms\Components\WebpImageUpload;
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

                        WebpImageUpload::make(
                            name: 'image',
                            label: 'Foto Galeri',
                            aspectRatio: '1:1',
                        )
                            ->directory('gallery')
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
