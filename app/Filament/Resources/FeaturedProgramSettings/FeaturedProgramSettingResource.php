<?php

namespace App\Filament\Resources\FeaturedProgramSettings;

use App\Filament\Resources\FeaturedProgramSettings\Schemas\FeaturedProgramSettingForm;
use App\Filament\Resources\FeaturedProgramSettings\Tables\FeaturedProgramSettingsTable;
use App\Models\FeaturedProgramSetting;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class FeaturedProgramSettingResource extends Resource
{
    protected static ?string $model = FeaturedProgramSetting::class;

    protected static ?string $modelLabel = 'Pengaturan Program Unggulan';

    protected static ?string $pluralModelLabel = 'Pengaturan Program Unggulan';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return FeaturedProgramSettingForm::configure(
            $schema,
        );
    }

    public static function table(Table $table): Table
    {
        return FeaturedProgramSettingsTable::configure(
            $table,
        );
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
            && ! FeaturedProgramSetting::query()->exists();
    }

    public static function canEdit(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeaturedProgramSettings::route('/'),
            'create' => Pages\CreateFeaturedProgramSetting::route('/create'),
            'edit' => Pages\EditFeaturedProgramSetting::route('/{record}/edit'),
        ];
    }
}