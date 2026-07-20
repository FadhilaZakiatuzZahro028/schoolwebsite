<?php

namespace App\Filament\Resources\Facilities\Schemas;

use App\Filament\Forms\Components\WebpImageUpload;
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

                        WebpImageUpload::make(
                            name: 'image',
                            label: 'Foto Fasilitas',
                            aspectRatio: '4:3',
                        )
                            ->directory('facilities')
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
