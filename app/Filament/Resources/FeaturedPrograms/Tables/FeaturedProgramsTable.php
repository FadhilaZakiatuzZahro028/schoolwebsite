<?php

namespace App\Filament\Resources\FeaturedPrograms\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class FeaturedProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->square(),

                TextColumn::make('name')
                    ->label('Nama Program')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('summary')
                    ->label('Ringkasan')
                    ->limit(55)
                    ->toggleable(),

                TextColumn::make('is_active')
                    ->label('Status')
                    ->formatStateUsing(
                        fn (bool $state): string => $state
                            ? 'Aktif'
                            : 'Nonaktif',
                    )
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->visible(
                        fn ($record): bool => ! method_exists(
                            $record,
                            'trashed',
                        ) || ! $record->trashed(),
                    ),

                DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation()
                    ->visible(
                        fn ($record): bool => ! method_exists(
                            $record,
                            'trashed',
                        ) || ! $record->trashed(),
                    ),

                RestoreAction::make()
                    ->label('Pulihkan')
                    ->visible(
                        fn ($record): bool => method_exists(
                            $record,
                            'trashed',
                        ) && $record->trashed(),
                    ),

                ForceDeleteAction::make()
                    ->label('Hapus Permanen')
                    ->requiresConfirmation()
                    ->visible(
                        fn ($record): bool => auth()->user()?->role
                            === 'super_admin'
                            && method_exists($record, 'trashed')
                            && $record->trashed(),
                    ),
            ])
            ->toolbarActions([]);
    }
}