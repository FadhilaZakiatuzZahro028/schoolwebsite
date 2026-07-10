<?php

namespace App\Filament\Resources\NewsCategories\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NewsCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->recordActions([
                EditAction::make()
                    ->label('Edit'),

                DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation()
                    ->visible(function ($record): bool {
                        if (! method_exists($record, 'news')) {
                            return true;
                        }

                        return ! $record->news()->exists();
                    }),
            ])
            ->toolbarActions([]);
    }
}