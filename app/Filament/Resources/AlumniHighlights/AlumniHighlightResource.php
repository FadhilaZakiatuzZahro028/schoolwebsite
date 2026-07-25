<?php

namespace App\Filament\Resources\AlumniHighlights;

use App\Filament\Resources\AlumniHighlights\Schemas\AlumniHighlightForm;
use App\Filament\Resources\AlumniHighlights\Tables\AlumniHighlightsTable;
use App\Models\AlumniHighlight;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class AlumniHighlightResource extends Resource
{
    protected static ?string $model = AlumniHighlight::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static string|UnitEnum|null $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Alumni Pilihan';

    protected static ?string $modelLabel = 'Alumni Pilihan';

    protected static ?string $pluralModelLabel = 'Alumni Pilihan';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return AlumniHighlightForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlumniHighlightsTable::configure($table);
    }

    public static function canViewAny(): bool
    {
        return in_array(
            auth()->user()?->role,
            ['super_admin', 'admin'],
            true,
        );
    }

    public static function canCreate(): bool
    {
        return static::canViewAny();
    }

    public static function canEdit(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function canDelete(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlumniHighlights::route('/'),
            'create' => Pages\CreateAlumniHighlight::route('/create'),
            'edit' => Pages\EditAlumniHighlight::route('/{record}/edit'),
        ];
    }
}
