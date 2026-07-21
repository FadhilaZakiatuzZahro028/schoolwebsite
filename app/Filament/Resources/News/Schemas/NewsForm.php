<?php

namespace App\Filament\Resources\News\Schemas;

use App\Filament\Forms\Components\WebpImageUpload;
use App\Models\News;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Berita')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Berita')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->unique(table: 'news', column: 'slug', ignoreRecord: true)
                            ->disabled(fn (?News $record): bool => $record?->status === 'published')
                            ->helperText('Boleh dikosongkan. Sistem akan membuat slug otomatis dari judul. Setelah berita published, slug dikunci untuk menjaga SEO.'),

                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('draft')
                            ->required(),

                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publish')
                            ->seconds(false)
                            ->helperText('Boleh dikosongkan. Jika status Published, sistem akan mengisi otomatis waktu sekarang.'),

                        WebpImageUpload::make(
    'thumbnail',
    'Gambar Utama',
)
    ->required(),

                        Textarea::make('excerpt')
                            ->label('Ringkasan Berita')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Ringkasan singkat untuk kartu berita di halaman publik.'),

                        RichEditor::make('content')
                            ->label('Isi Berita')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('SEO Berita')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->helperText('Maksimal 60 karakter. Jika kosong, sistem memakai judul berita.'),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Maksimal 160 karakter. Jika kosong, sistem mengambil ringkasan dari isi berita.'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}