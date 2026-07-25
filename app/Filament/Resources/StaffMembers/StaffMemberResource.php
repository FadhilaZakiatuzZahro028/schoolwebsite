<?php

namespace App\Filament\Resources\StaffMembers;

use App\Filament\Resources\StaffMembers\Schemas\StaffMemberForm;
use App\Filament\Resources\StaffMembers\Tables\StaffMembersTable;
use App\Models\StaffMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class StaffMemberResource extends Resource
{
    protected static ?string $model = StaffMember::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|UnitEnum|null $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Guru & Karyawan';

    protected static ?string $modelLabel = 'Staf';

    protected static ?string $pluralModelLabel = 'Guru & Karyawan';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return StaffMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StaffMembersTable::configure($table);
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
            'index' => Pages\ListStaffMembers::route('/'),
            'create' => Pages\CreateStaffMember::route('/create'),
            'edit' => Pages\EditStaffMember::route('/{record}/edit'),
        ];
    }
}
