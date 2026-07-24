<?php

namespace App\Filament\Resources\Curricula\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CurriculumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kurikulum')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('academic_year')
                            ->label('Tahun Ajaran')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: 2026/2027'),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(7)
                            ->columnSpanFull(),

                        FileUpload::make('pdf_file')
                            ->label('Dokumen PDF')
                            ->disk('public')
                            ->directory('curriculums')
                            ->visibility('public')
                            ->acceptedFileTypes([
                                'application/pdf',
                            ])
                            ->maxSize(5120)
                            ->downloadable()
                            ->openable()
                            ->preventFilePathTampering()
                            ->helperText('Opsional. Maksimal 5 MB dan hanya file PDF.'),

                        FileUpload::make('image_file')
                            ->label('Materi Gambar')
                            ->image()
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                            ])
                            ->maxSize(5120)
                            ->storeFiles(false)
                            ->imagePreviewHeight('160')
                            ->downloadable()
                            ->openable()
                            ->preventFilePathTampering()
                            ->helperText('Opsional. File JPG atau PNG asli akan tetap disimpan untuk unduhan dan dibuatkan preview WebP.'),

                        Toggle::make('is_published')
                            ->label('Dipublikasikan')
                            ->default(true),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
