<?php

namespace App\Filament\Resources\SpmbSettings\Tables;

use App\Models\SpmbSetting;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SpmbSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label('Keterangan SPMB')
                    ->limit(80)
                    ->wrap()
                    ->placeholder('Belum ada keterangan'),

                TextColumn::make('information_file')
                    ->label('File Informasi')
                    ->getStateUsing(
                        fn (SpmbSetting $record): bool => filled(
                            $record->information_file,
                        )
                    )
                    ->badge()
                    ->formatStateUsing(
                        fn (bool $state): string => $state
                            ? 'Tersedia'
                            : 'Belum Ada'
                    )
                    ->color(
                        fn (bool $state): string => $state
                            ? 'success'
                            : 'gray'
                    ),

                TextColumn::make('brochure_file')
                    ->label('Brosur')
                    ->getStateUsing(
                        fn (SpmbSetting $record): bool => filled(
                            $record->brochure_file,
                        )
                    )
                    ->badge()
                    ->formatStateUsing(
                        fn (bool $state): string => $state
                            ? 'Tersedia'
                            : 'Belum Ada'
                    )
                    ->color(
                        fn (bool $state): string => $state
                            ? 'success'
                            : 'gray'
                    ),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
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
