<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use App\Filament\Forms\Components\WebpImageUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Site Settings')
                    ->tabs([
                        Tab::make('Identitas Situs')
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Nama Situs')
                                    ->required()
                                    ->maxLength(255),

                                Textarea::make('site_description')
                                    ->label('Deskripsi Situs')
                                    ->required()
                                    ->rows(5)
                                    ->columnSpanFull(),

                                TextInput::make('copyright_text')
                                    ->label('Teks Copyright')
                                    ->required()
                                    ->maxLength(255),

                                Toggle::make('is_maintenance')
                                    ->label('Mode Maintenance')
                                    ->helperText('Aktifkan hanya jika website publik perlu ditutup sementara.'),
                            ])
                            ->columns(2),

                        Tab::make('SEO Global')
                            ->schema([
                                TextInput::make('default_meta_keywords')
                                    ->label('Default Meta Keywords')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Pisahkan keyword dengan koma.'),

                                WebpImageUpload::make(
                                    'default_og_image',
                                    'Default Open Graph Image',
                                ),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
