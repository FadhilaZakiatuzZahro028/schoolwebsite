<?php

namespace App\Filament\Resources\Achievements\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class AchievementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->square(),

                TextColumn::make('title')
                    ->label('Nama Prestasi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(45),

                TextColumn::make('level')
                    ->label('Tingkat')
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'Sekolah' => 'gray',
                        'Kabupaten' => 'info',
                        'Provinsi' => 'primary',
                        'Nasional' => 'success',
                        'Internasional' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('level')
                    ->label('Tingkat')
                    ->options([
                        'Sekolah' => 'Sekolah',
                        'Kabupaten' => 'Kabupaten',
                        'Provinsi' => 'Provinsi',
                        'Nasional' => 'Nasional',
                        'Internasional' => 'Internasional',
                    ]),

                SelectFilter::make('year')
                    ->label('Tahun')
                    ->options(function (): array {
                        $currentYear = (int) date('Y');
                        $years = range($currentYear + 1, 2000);

                        return array_combine($years, $years);
                    }),

                TrashedFilter::make(),
            ])
            ->defaultSort('year', 'desc')
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->visible(fn ($record): bool => ! method_exists($record, 'trashed') || ! $record->trashed()),

                DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation()
                    ->visible(fn ($record): bool => ! method_exists($record, 'trashed') || ! $record->trashed()),

                RestoreAction::make()
                    ->label('Pulihkan')
                    ->visible(fn ($record): bool => method_exists($record, 'trashed') && $record->trashed()),

                ForceDeleteAction::make()
                    ->label('Hapus Permanen')
                    ->requiresConfirmation()
                    ->visible(fn ($record): bool => auth()->user()?->role === 'super_admin'
                        && method_exists($record, 'trashed')
                        && $record->trashed()),
            ])
            ->toolbarActions([]);
    }
}
