<?php

namespace App\Filament\Resources\Extracurriculars;

use App\Filament\Resources\Extracurriculars\Pages;
use App\Filament\Resources\Extracurriculars\Schemas\ExtracurricularForm;
use App\Filament\Resources\Extracurriculars\Tables\ExtracurricularsTable;
use App\Models\Extracurricular;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ExtracurricularResource extends Resource
{
    protected static ?string $model = Extracurricular::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user-group';

    protected static string | UnitEnum | null $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Ekstrakurikuler';

    protected static ?string $modelLabel = 'Ekstrakurikuler';

    protected static ?string $pluralModelLabel = 'Ekstrakurikuler';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return ExtracurricularForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExtracurricularsTable::configure($table);
    }

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, ['super_admin', 'admin'], true);
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

    public static function canRestore(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function canForceDelete(Model $record): bool
    {
        return auth()->user()?->role === 'super_admin';
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canForceDeleteAny(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExtracurriculars::route('/'),
            'create' => Pages\CreateExtracurricular::route('/create'),
            'edit' => Pages\EditExtracurricular::route('/{record}/edit'),
        ];
    }
}