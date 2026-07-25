<?php

namespace App\Filament\Resources\StaffMembers\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\StaffMembers\StaffMemberResource;
use App\Models\StaffMember;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStaffMember extends EditRecord
{
    use HandlesWebpUploads;

    protected static string $resource = StaffMemberResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = $this->normalizeTypeFields($data);

        return $this->processWebpUpload(
            data: $data,
            field: 'photo',
            directory: 'staff',
            oldPath: $this->record->photo,
            maxWidth: 1200,
            quality: 80,
        );
    }

    protected function afterSave(): void
    {
        $this->deleteReplacedWebpFiles();
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->requiresConfirmation(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    private function normalizeTypeFields(array $data): array
    {
        if (($data['staff_type'] ?? null) === StaffMember::TYPE_TEACHER) {
            $data['department'] = null;
        }

        if (($data['staff_type'] ?? null) === StaffMember::TYPE_EMPLOYEE) {
            $data['subject'] = null;
        }

        return $data;
    }
}
