<?php

namespace App\Filament\Resources\FeaturedPrograms\Schemas;

use App\Filament\Forms\Components\WebpImageUpload;
use App\Services\ImageUploadService;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class FeaturedProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Program Unggulan')
                    ->description(
                        'Kelola bidang keterampilan yang ditampilkan pada halaman Program Unggulan.',
                    )
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Program')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),

                        TextInput::make('summary')
                            ->label('Ringkasan')
                            ->required()
                            ->maxLength(255)
                            ->helperText(
                                'Gunakan kalimat singkat yang menarik dan mudah dipahami.',
                            )
                            ->columnSpanFull(),

                        WebpImageUpload::make(
                            name: 'image',
                            label: 'Foto Utama Kegiatan',
                            aspectRatio: '4:3',
                        )
                            ->directory('featured-programs')
                            ->helperText(
                                'Gunakan foto kegiatan nyata. JPG, PNG, atau WebP maksimal 2 MB.',
                            )
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText(
                                'Hanya program aktif yang ditampilkan pada website.',
                            ),

                        Textarea::make('description')
                            ->label('Deskripsi / Manfaat')
                            ->required()
                            ->rows(7)
                            ->helperText(
                                'Jelaskan pengalaman dan manfaat keterampilan secara profesional tanpa klaim yang belum dikonfirmasi sekolah.',
                            )
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Dokumentasi Kegiatan')
                    ->description(
                        'Tambahkan maksimal 2 foto dokumentasi tambahan.',
                    )
                    ->schema([
                        Repeater::make('images')
                            ->label('Foto Dokumentasi')
                            ->relationship()
                            ->schema([
                                WebpImageUpload::make(
                                    name: 'image',
                                    label: 'Foto',
                                    aspectRatio: '4:3',
                                )
                                    ->directory('featured-programs')
                                    ->storeFiles()
                                    ->saveUploadedFileUsing(
                                        function (
                                            TemporaryUploadedFile $file,
                                        ): ?string {
                                            return app(
                                                ImageUploadService::class,
                                            )->storeAsWebp(
                                                file: $file,
                                                directory: 'featured-programs',
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
                                                str_replace(
                                                    '\\',
                                                    '/',
                                                    $file,
                                                ),
                                                '/',
                                            );

                                            return ! str_contains(
                                                $normalizedPath,
                                                '../',
                                            ) && str_starts_with(
                                                $normalizedPath,
                                                'featured-programs/',
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