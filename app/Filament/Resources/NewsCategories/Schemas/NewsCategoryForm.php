<?php

namespace App\Filament\Resources\NewsCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NewsCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Contoh: Berita Sekolah, Pengumuman, Kegiatan, Akademik.'),

                TextInput::make('slug')
                    ->label('Slug')
                    ->maxLength(255)
                    ->unique(table: 'news_categories', column: 'slug', ignoreRecord: true)
                    ->helperText('Boleh dikosongkan. Sistem akan membuat slug otomatis dari nama kategori.'),
            ]);
    }
}