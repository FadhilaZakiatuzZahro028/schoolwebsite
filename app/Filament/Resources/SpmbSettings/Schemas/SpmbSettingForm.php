<?php

namespace App\Filament\Resources\SpmbSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SpmbSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama SPMB')
                    ->schema([
                        Textarea::make('description')
                            ->label('Keterangan SPMB')
                            ->rows(12)
                            ->columnSpanFull()
                            ->helperText(
                                'Isi alur, persyaratan, jadwal, biaya, dan informasi penerimaan murid baru.'
                            ),
                    ])
                    ->columnSpanFull(),

                Section::make('Dokumen SPMB')
                    ->description(
                        'File dapat berupa PDF atau gambar. File asli dipertahankan untuk diunduh.'
                    )
                    ->schema([
                        FileUpload::make('information_file')
                            ->label('File Informasi')
                            ->disk('public')
                            ->visibility('public')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->maxSize(5120)
                            ->storeFiles(false)
                            ->downloadable()
                            ->openable()
                            ->preventFilePathTampering()
                            ->helperText(
                                'Opsional. PDF, JPG, PNG, atau WebP. Maksimal 5 MB.'
                            ),

                        FileUpload::make('brochure_file')
                            ->label('Brosur SPMB')
                            ->disk('public')
                            ->visibility('public')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->maxSize(5120)
                            ->storeFiles(false)
                            ->downloadable()
                            ->openable()
                            ->preventFilePathTampering()
                            ->helperText(
                                'Opsional. PDF, JPG, PNG, atau WebP. Maksimal 5 MB.'
                            ),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
