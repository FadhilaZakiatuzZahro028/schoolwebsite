<?php

namespace App\Filament\Resources\Facilities\Schemas;

use App\Filament\Forms\Components\WebpImageUpload;
use App\Services\ImageUploadService;
use Filament\Forms\Components\Repeater;
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
                            ->unique(
                                table: 'facilities',
                                column: 'slug',
                                ignoreRecord: true,
                            )
                            ->helperText(
                                'Boleh dikosongkan. Sistem akan membuat slug otomatis dari nama fasilitas.',
                            ),

                        WebpImageUpload::make(
                            name: 'image',
                            label: 'Foto Utama Fasilitas',
                            aspectRatio: '4:3',
                        )
                            ->directory('facilities')
                            ->preventFilePathTampering(false)
                            ->required(),

                        Textarea::make('description')
                            ->label('Deskripsi Fasilitas')
                            ->required()
                            ->rows(7)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Dokumentasi Tambahan')
                    ->description(
                        'Tambahkan maksimal 2 foto tambahan untuk halaman detail fasilitas.',
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
                                    ->directory('facilities')
                                    ->required(),

                                TextInput::make('alt_text')
                                    ->label('Teks Alternatif')
                                    ->maxLength(255)
                                    ->helperText(
                                        'Opsional. Jelaskan isi foto secara singkat untuk aksesibilitas.',
                                    ),
                            ])
                            ->mutateRelationshipDataBeforeCreateUsing(
                                function (array $data): array {
                                    $data['image'] = app(
                                        ImageUploadService::class,
                                    )->storeAsWebp(
                                        file: $data['image'] ?? null,
                                        directory: 'facilities',
                                        maxWidth: 1600,
                                        quality: 80,
                                    );

                                    return $data;
                                },
                            )
                            ->mutateRelationshipDataBeforeSaveUsing(
                                function (array $data): array {
                                    $data['image'] = app(
                                        ImageUploadService::class,
                                    )->storeAsWebp(
                                        file: $data['image'] ?? null,
                                        directory: 'facilities',
                                        maxWidth: 1600,
                                        quality: 80,
                                    );

                                    return $data;
                                },
                            )
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