<?php

namespace App\Filament\Resources\FeaturedProgramSettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FeaturedProgramSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('introduction')
                    ->label('Pengantar')
                    ->limit(70)
                    ->placeholder('Belum diisi'),

                TextColumn::make('collaboration_text')
                    ->label('Kolaborasi LPK / BLK')
                    ->limit(70)
                    ->placeholder('Belum diisi'),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit Pengaturan'),
            ])
            ->toolbarActions([]);
    }
}