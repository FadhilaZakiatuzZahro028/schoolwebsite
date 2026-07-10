<?php

namespace App\Filament\Resources\SchoolProfiles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SchoolProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('School Profile')
                    ->tabs([
                        Tab::make('Identitas Sekolah')
                            ->schema([
                                TextInput::make('school_name')
                                    ->label('Nama Sekolah')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('tagline')
                                    ->label('Tagline')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('principal_name')
                                    ->label('Nama Kepala Sekolah')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->label('Email Resmi')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('phone')
                                    ->label('Nomor Telepon / WhatsApp')
                                    ->required()
                                    ->maxLength(255),

                                Textarea::make('address')
                                    ->label('Alamat Lengkap')
                                    ->required()
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tab::make('Profil & Sambutan')
                            ->schema([
                                Textarea::make('history')
                                    ->label('Sejarah Sekolah')
                                    ->required()
                                    ->rows(8)
                                    ->columnSpanFull(),

                                Textarea::make('vision')
                                    ->label('Visi')
                                    ->required()
                                    ->rows(5)
                                    ->columnSpanFull(),

                                Textarea::make('mission')
                                    ->label('Misi')
                                    ->required()
                                    ->rows(7)
                                    ->columnSpanFull(),

                                Textarea::make('principal_message')
                                    ->label('Sambutan Kepala Sekolah')
                                    ->required()
                                    ->rows(8)
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Logo & Media')
                            ->schema([
                                FileUpload::make('logo')
                                    ->label('Logo Sekolah')
                                    ->image()
                                    ->disk('public')
                                    ->directory('logos')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->maxSize(2048)
                                    ->imagePreviewHeight('120')
                                    ->downloadable()
                                    ->openable()
                                    ->preventFilePathTampering(),

                                FileUpload::make('favicon')
                                    ->label('Favicon')
                                    ->image()
                                    ->disk('public')
                                    ->directory('logos')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->maxSize(1024)
                                    ->imagePreviewHeight('80')
                                    ->downloadable()
                                    ->openable()
                                    ->preventFilePathTampering(),

                                Textarea::make('maps_embed')
                                    ->label('Embed Google Maps')
                                    ->rows(4)
                                    ->columnSpanFull()
                                    ->helperText('Masukkan iframe embed Google Maps dari alamat sekolah.'),

                                TextInput::make('instagram')
                                    ->label('URL Instagram')
                                    ->url()
                                    ->maxLength(255),

                                TextInput::make('facebook')
                                    ->label('URL Facebook')
                                    ->url()
                                    ->maxLength(255),

                                TextInput::make('youtube')
                                    ->label('URL YouTube')
                                    ->url()
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        Tab::make('Informasi PPDB')
                            ->schema([
                                Textarea::make('ppdb_info')
                                    ->label('Informasi PPDB')
                                    ->rows(10)
                                    ->columnSpanFull()
                                    ->helperText('Isi alur, syarat, jadwal, biaya, dan informasi pendaftaran siswa baru.'),

                                FileUpload::make('ppdb_brochure')
                                    ->label('Brosur PPDB PDF')
                                    ->disk('public')
                                    ->directory('documents')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(5120)
                                    ->downloadable()
                                    ->openable()
                                    ->preventFilePathTampering(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}