<?php

namespace App\Filament\Resources\HeroBanners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HeroBannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Hero Banner')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Utama')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('subtitle')
                            ->label('Subjudul')
                            ->maxLength(255)
                            ->helperText('Opsional. Contoh: Selamat Datang di Website Resmi Sekolah.'),

                        FileUpload::make('image')
                            ->label('Gambar Banner')
                            ->image()
                            ->disk('public')
                            ->directory('heroes')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048)
                            ->imagePreviewHeight('180')
                            ->downloadable()
                            ->openable()
                            ->preventFilePathTampering()
                            ->required(),

                        TextInput::make('button_text')
                            ->label('Teks Tombol CTA')
                            ->maxLength(255)
                            ->helperText('Opsional. Contoh: Lihat Profil'),

                        TextInput::make('button_url')
                            ->label('URL Tombol CTA')
                            ->maxLength(255)
                            ->helperText('Opsional. Contoh: /profil atau /kontak'),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->minValue(0),

                        Toggle::make('is_active')
                            ->label('Aktifkan Banner Ini')
                            ->default(true)
                            ->helperText('Jika aktif, banner aktif sebelumnya otomatis dinonaktifkan.'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}