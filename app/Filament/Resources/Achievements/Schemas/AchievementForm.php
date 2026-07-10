<?php

namespace App\Filament\Resources\Achievements\Schemas;

use App\Filament\Forms\Components\WebpImageUpload;
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

                        WebpImageUpload::make(
                            name: 'image',
                            label: 'Foto Dokumentasi',
                            aspectRatio: '4:3',
                        )
                            ->directory('achievements')
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
