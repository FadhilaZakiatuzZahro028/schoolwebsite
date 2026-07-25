<?php

namespace App\Filament\Resources\AlumniHighlights\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AlumniHighlightsTable
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
                    ->label('Nama Alumni')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('graduation_year')
                    ->label('Tahun Lulus')
                    ->sortable(),

                TextColumn::make('current_activity')
                    ->label('Aktivitas / Pekerjaan')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-')
                    ->wrap(),

                TextColumn::make('institution')
                    ->label('Instansi')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-')
                    ->wrap(),

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
