<?php

namespace App\Filament\Resources\StaffMembers\Schemas;

use App\Filament\Forms\Components\WebpImageUpload;
use App\Models\StaffMember;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class StaffMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Guru atau Karyawan')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),

                        Select::make('staff_type')
                            ->label('Jenis Staf')
                            ->options([
                                StaffMember::TYPE_TEACHER => 'Guru',
                                StaffMember::TYPE_EMPLOYEE => 'Karyawan',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),

                        WebpImageUpload::make(
                            name: 'photo',
                            label: 'Foto',
                            aspectRatio: '1:1',
                        )
                            ->helperText(
                                'Opsional. Foto akan dikonversi otomatis ke format WebP.'
                            ),

                        TextInput::make('position')
                            ->label('Jabatan')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('subject')
                            ->label('Mata Pelajaran')
                            ->maxLength(255)
                            ->visible(
                                fn (Get $get): bool => $get('staff_type')
                                    === StaffMember::TYPE_TEACHER
                            ),

                        TextInput::make('department')
                            ->label('Bagian / Unit')
                            ->maxLength(255)
                            ->visible(
                                fn (Get $get): bool => $get('staff_type')
                                    === StaffMember::TYPE_EMPLOYEE
                            ),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
