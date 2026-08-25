<?php

namespace App\Filament\Resources\FeaturedProgramSettings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FeaturedProgramSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(
                    'Pengaturan Halaman Program Unggulan',
                )
                    ->description(
                        'Kelola pengantar halaman dan informasi umum kolaborasi program keterampilan.',
                    )
                    ->schema([
                        Textarea::make('introduction')
                            ->label('Pengantar Program Unggulan')
                            ->rows(7)
                            ->helperText(
                                'Opsional. Jelaskan secara singkat tujuan dan nilai Program Unggulan bagi siswa.',
                            )
                            ->columnSpanFull(),

                        Textarea::make('collaboration_text')
                            ->label('Informasi Kolaborasi LPK / BLK')
                            ->rows(7)
                            ->helperText(
                                'Opsional. Gunakan informasi yang telah dikonfirmasi sekolah. Hindari klaim sertifikasi, penyaluran kerja, jaminan pekerjaan, atau nama mitra yang belum resmi.',
                            )
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}