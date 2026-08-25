<?php

namespace App\Filament\Resources\FeaturedPrograms;

use App\Filament\Resources\FeaturedPrograms\Schemas\FeaturedProgramForm;
use App\Filament\Resources\FeaturedPrograms\Tables\FeaturedProgramsTable;
use App\Models\FeaturedProgram;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class FeaturedProgramResource extends Resource
{
    protected static ?string $model = FeaturedProgram::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static string|UnitEnum|null $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Program Unggulan';

    protected static ?string $modelLabel = 'Program Unggulan';

    protected static ?string $pluralModelLabel = 'Program Unggulan';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return FeaturedProgramForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FeaturedProgramsTable::configure($table);
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
            'index' => Pages\ListFeaturedPrograms::route('/'),
            'create' => Pages\CreateFeaturedProgram::route('/create'),
            'edit' => Pages\EditFeaturedProgram::route('/{record}/edit'),
        ];
    }
}