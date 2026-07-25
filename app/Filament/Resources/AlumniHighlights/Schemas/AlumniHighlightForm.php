<?php

namespace App\Filament\Resources\AlumniHighlights\Schemas;

use App\Filament\Forms\Components\WebpImageUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AlumniHighlightForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profil Alumni Pilihan')
                    ->description(
                        'Kelola profil alumni yang akan ditampilkan pada halaman publik.'
                    )
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Alumni')
                            ->required()
                            ->maxLength(255)
                            ->validationMessages([
                                'required' => 'Nama alumni wajib diisi.',
                                'max' => 'Nama alumni maksimal 255 karakter.',
                            ]),

                        TextInput::make('graduation_year')
                            ->label('Tahun Kelulusan')
                            ->required()
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue((int) now()->year)
                            ->validationMessages([
                                'required' => 'Tahun kelulusan wajib diisi.',
                                'numeric' => 'Tahun kelulusan harus berupa angka.',
                                'min' => 'Tahun kelulusan tidak boleh kurang dari 1900.',
                                'max' => 'Tahun kelulusan tidak boleh melebihi tahun saat ini.',
                            ]),

                        WebpImageUpload::make(
                            name: 'photo',
                            label: 'Foto Alumni',
                            aspectRatio: '1:1',
                        )
                            ->helperText(
                                'Opsional. JPG, PNG, atau WebP maksimal 2 MB. Foto akan dikonversi otomatis menjadi WebP.'
                            ),

                        TextInput::make('current_activity')
                            ->label('Aktivitas / Pekerjaan Saat Ini')
                            ->maxLength(255)
                            ->validationMessages([
                                'max' => 'Aktivitas atau pekerjaan maksimal 255 karakter.',
                            ]),

                        TextInput::make('institution')
                            ->label('Instansi / Perusahaan')
                            ->maxLength(255)
                            ->validationMessages([
                                'max' => 'Nama instansi atau perusahaan maksimal 255 karakter.',
                            ]),

                        Textarea::make('quote')
                            ->label('Kutipan')
                            ->rows(4)
                            ->maxLength(1000)
                            ->helperText(
                                'Opsional. Gunakan kutipan singkat yang layak ditampilkan kepada publik.'
                            )
                            ->validationMessages([
                                'max' => 'Kutipan maksimal 1.000 karakter.',
                            ])
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText(
                                'Maksimal 4 alumni pilihan dapat berstatus aktif.'
                            ),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->validationMessages([
                                'required' => 'Urutan tampil wajib diisi.',
                                'numeric' => 'Urutan tampil harus berupa angka.',
                                'min' => 'Urutan tampil tidak boleh bernilai negatif.',
                            ]),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
