<?php

namespace App\Filament\Resources\Extracurriculars\Schemas;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Services\ImageUploadService;
use Filament\Forms\Components\Repeater;
use App\Filament\Forms\Components\WebpImageUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExtracurricularForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Ekstrakurikuler')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Ekstrakurikuler')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->unique(table: 'extracurriculars', column: 'slug', ignoreRecord: true)
                            ->helperText('Boleh dikosongkan. Sistem akan membuat slug otomatis dari nama ekstrakurikuler.'),

                        TextInput::make('coach_name')
                            ->label('Nama Pembina')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('schedule')
                            ->label('Jadwal Latihan')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Contoh: Jumat, 15.00 - 17.00 WIB'),

                        WebpImageUpload::make(
                            name: 'image',
                            label: 'Foto Kegiatan',
                            aspectRatio: '4:3',
                        )
                            ->directory('extracurriculars')
                            ->required(),

                        Textarea::make('description')
                            ->label('Deskripsi Kegiatan')
                            ->required()
                            ->rows(7)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                    Section::make('Dokumentasi Tambahan')
    ->description(
        'Tambahkan maksimal 2 foto dokumentasi tambahan untuk halaman detail ekstrakurikuler.',
    )
    ->schema([
        Repeater::make('images')
            ->label('Foto Tambahan')
            ->relationship()
            ->schema([
                WebpImageUpload::make(
    name: 'image',
    label: 'Foto',
    aspectRatio: '4:3',
)
    ->directory('extracurriculars')
    ->storeFiles()
    ->saveUploadedFileUsing(
        function (
            TemporaryUploadedFile $file,
        ): ?string {
            return app(
                ImageUploadService::class,
            )->storeAsWebp(
                file: $file,
                directory: 'extracurriculars',
                maxWidth: 1600,
                quality: 80,
            );
        },
    )
    ->preventFilePathTampering(
        allowFilePathUsing: static function (
            string $file,
        ): bool {
            $normalizedPath = ltrim(
                str_replace('\\', '/', $file),
                '/',
            );

            return ! str_contains(
                $normalizedPath,
                '../',
            ) && str_starts_with(
                $normalizedPath,
                'extracurriculars/',
            );
        },
    )
    ->required(),

                TextInput::make('alt_text')
                    ->label('Teks Alternatif')
                    ->maxLength(255)
                    ->helperText(
                        'Opsional. Jelaskan isi foto secara singkat untuk aksesibilitas.',
                    ),
            ])
            ->orderColumn('sort_order')
            ->maxItems(2)
            ->defaultItems(0)
            ->addActionLabel(
                'Tambah Foto Dokumentasi',
            )
            ->columns(2)
            ->columnSpanFull(),
    ])
    ->columnSpanFull(),
            ]);
    }
}
