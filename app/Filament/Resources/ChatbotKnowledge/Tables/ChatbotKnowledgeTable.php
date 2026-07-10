<?php

namespace App\Filament\Resources\ChatbotKnowledge\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ChatbotKnowledgeTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Aktif' : 'Nonaktif')
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray')
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('keywords')
                    ->label('Kata Kunci')
                    ->searchable()
                    ->limit(70)
                    ->wrap(),

                TextColumn::make('answer')
                    ->label('Jawaban')
                    ->searchable()
                    ->limit(80)
                    ->wrap(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Nonaktif',
                    ]),

                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'umum' => 'Umum',
                        'profil' => 'Profil Sekolah',
                        'alamat' => 'Alamat',
                        'kontak' => 'Kontak',
                        'ppdb' => 'PPDB',
                        'berita' => 'Berita',
                        'prestasi' => 'Prestasi',
                        'ekstrakurikuler' => 'Ekstrakurikuler',
                        'fasilitas' => 'Fasilitas',
                    ]),
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