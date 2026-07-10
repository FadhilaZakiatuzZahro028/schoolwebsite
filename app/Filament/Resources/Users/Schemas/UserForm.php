<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Akun Admin')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Admin')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(table: 'users', column: 'email', ignoreRecord: true),

                        Select::make('role')
                            ->label('Role')
                            ->options([
                                'super_admin' => 'Super Admin',
                                'admin' => 'Admin Konten',
                            ])
                            ->required()
                            ->default('admin')
                            ->disabled(fn (?User $record): bool => $record?->getKey() === auth()->id())
                            ->helperText('Role akun sendiri dikunci agar super admin tidak sengaja menurunkan aksesnya.'),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->maxLength(255)
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->helperText('Saat edit, kosongkan jika password tidak ingin diubah.'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}