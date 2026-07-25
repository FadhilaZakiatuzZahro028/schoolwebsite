<?php

namespace App\Filament\Resources\StaffMembers\Tables;

use App\Models\StaffMember;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StaffMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('staff_type')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string => match ($state) {
                            StaffMember::TYPE_TEACHER => 'Guru',
                            StaffMember::TYPE_EMPLOYEE => 'Karyawan',
                            default => $state,
                        }
                    )
                    ->color(
                        fn (string $state): string => match ($state) {
                            StaffMember::TYPE_TEACHER => 'info',
                            StaffMember::TYPE_EMPLOYEE => 'warning',
                            default => 'gray',
                        }
                    ),

                TextColumn::make('position')
                    ->label('Jabatan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject')
                    ->label('Mata Pelajaran')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('department')
                    ->label('Bagian / Unit')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn (bool $state): string => $state
                            ? 'Aktif'
                            : 'Tidak Aktif'
                    )
                    ->color(
                        fn (bool $state): string => $state
                            ? 'success'
                            : 'gray'
                    ),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('staff_type')
                    ->label('Jenis Staf')
                    ->options([
                        StaffMember::TYPE_TEACHER => 'Guru',
                        StaffMember::TYPE_EMPLOYEE => 'Karyawan',
                    ]),

                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ]),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make()
                    ->label('Edit'),

                DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation(),
            ])
            ->toolbarActions([]);
    }
}
