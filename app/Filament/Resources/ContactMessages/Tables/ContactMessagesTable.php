<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('is_read')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Sudah Dibaca' : 'Belum Dibaca')
                    ->color(fn (bool $state): string => $state ? 'success' : 'warning')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('subject')
                    ->label('Subjek')
                    ->searchable()
                    ->limit(45),

                TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(60)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('is_read')
                    ->label('Status Baca')
                    ->options([
                        0 => 'Belum Dibaca',
                        1 => 'Sudah Dibaca',
                    ]),

                TrashedFilter::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make()
                    ->label('Baca / Ubah Status')
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
