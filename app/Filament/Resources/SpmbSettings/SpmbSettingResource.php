<?php

namespace App\Filament\Resources\SpmbSettings;

use App\Filament\Resources\SpmbSettings\Schemas\SpmbSettingForm;
use App\Filament\Resources\SpmbSettings\Tables\SpmbSettingsTable;
use App\Models\SpmbSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class SpmbSettingResource extends Resource
{
    protected static ?string $model = SpmbSetting::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|UnitEnum|null $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'SPMB';

    protected static ?string $modelLabel = 'Informasi SPMB';

    protected static ?string $pluralModelLabel = 'Informasi SPMB';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return SpmbSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpmbSettingsTable::configure($table);
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
        return static::canViewAny()
            && ! SpmbSetting::query()->exists();
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
            'index' => Pages\ListSpmbSettings::route('/'),
            'create' => Pages\CreateSpmbSetting::route('/create'),
            'edit' => Pages\EditSpmbSetting::route('/{record}/edit'),
        ];
    }
}
