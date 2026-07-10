<?php

namespace App\Filament\Resources\Facilities\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class FacilitiesTable
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
                    ->label('Nama Fasilitas')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(45),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->limit(40),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(60)
                    ->toggleable(),

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
                TrashedFilter::make(),
            ])
            ->defaultSort('name')
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