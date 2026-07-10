<?php

namespace App\Filament\Resources\Achievements\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AchievementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Prestasi')
                    ->schema([
                        TextInput::make('title')
                            ->label('Nama Prestasi')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->unique(table: 'achievements', column: 'slug', ignoreRecord: true)
                            ->helperText('Boleh dikosongkan. Sistem akan membuat slug otomatis dari nama prestasi.'),

                        Select::make('level')
                            ->label('Tingkat Prestasi')
                            ->options([
                                'Sekolah' => 'Sekolah',
                                'Kabupaten' => 'Kabupaten',
                                'Provinsi' => 'Provinsi',
                                'Nasional' => 'Nasional',
                                'Internasional' => 'Internasional',
                            ])
                            ->required(),

                        TextInput::make('year')
                            ->label('Tahun')
                            ->numeric()
                            ->required()
                            ->minValue(2000)
                            ->maxValue((int) date('Y') + 1),

                        FileUpload::make('image')
                            ->label('Foto Dokumentasi')
                            ->image()
                            ->disk('public')
                            ->directory('achievements')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048)
                            ->imagePreviewHeight('160')
                            ->downloadable()
                            ->openable()
                            ->preventFilePathTampering()
                            ->required(),

                        Textarea::make('description')
                            ->label('Deskripsi Prestasi')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}