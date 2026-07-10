<?php

namespace App\Filament\Resources\Extracurriculars\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExtracurricularForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Ekstrakurikuler')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Ekstrakurikuler')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->unique(table: 'extracurriculars', column: 'slug', ignoreRecord: true)
                            ->helperText('Boleh dikosongkan. Sistem akan membuat slug otomatis dari nama ekstrakurikuler.'),

                        TextInput::make('coach_name')
                            ->label('Nama Pembina')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('schedule')
                            ->label('Jadwal Latihan')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Contoh: Jumat, 15.00 - 17.00 WIB'),

                        FileUpload::make('image')
                            ->label('Foto Kegiatan')
                            ->image()
                            ->disk('public')
                            ->directory('extracurriculars')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048)
                            ->imagePreviewHeight('160')
                            ->downloadable()
                            ->openable()
                            ->preventFilePathTampering()
                            ->required(),

                        Textarea::make('description')
                            ->label('Deskripsi Kegiatan')
                            ->required()
                            ->rows(7)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}