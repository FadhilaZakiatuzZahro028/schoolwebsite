<?php

namespace App\Filament\Resources\Facilities\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FacilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Fasilitas')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Fasilitas')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->unique(table: 'facilities', column: 'slug', ignoreRecord: true)
                            ->helperText('Boleh dikosongkan. Sistem akan membuat slug otomatis dari nama fasilitas.'),

                        FileUpload::make('image')
                            ->label('Foto Fasilitas')
                            ->image()
                            ->disk('public')
                            ->directory('facilities')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048)
                            ->imagePreviewHeight('160')
                            ->downloadable()
                            ->openable()
                            ->preventFilePathTampering()
                            ->required(),

                        Textarea::make('description')
                            ->label('Deskripsi Fasilitas')
                            ->required()
                            ->rows(7)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}