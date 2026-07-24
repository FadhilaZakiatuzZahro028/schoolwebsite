<?php

namespace App\Filament\Resources\Curricula\Tables;

use App\Models\Curriculum;
use App\Services\CurriculumFileService;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CurriculaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('preview_image')
                    ->label('Preview')
                    ->disk('public')
                    ->square(),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(45),

                TextColumn::make('academic_year')
                    ->label('Tahun Ajaran')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),

                TextColumn::make('is_published')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn (bool $state): string => $state
                            ? 'Dipublikasikan'
                            : 'Tidak Dipublikasikan'
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
            ->filters([
                SelectFilter::make('is_published')
                    ->label('Status Publikasi')
                    ->options([
                        1 => 'Dipublikasikan',
                        0 => 'Tidak Dipublikasikan',
                    ]),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make()
                    ->label('Edit'),

                DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation()
                    ->using(function (Curriculum $record): bool {
                        $deleted = $record->delete();

                        if ($deleted) {
                            app(CurriculumFileService::class)->deleteFiles($record);
                        }

                        return $deleted;
                    }),
            ])
            ->toolbarActions([]);
    }
}
