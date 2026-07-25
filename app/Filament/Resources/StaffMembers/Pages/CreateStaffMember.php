<?php

namespace App\Filament\Resources\StaffMembers\Pages;

use App\Filament\Concerns\HandlesWebpUploads;
use App\Filament\Resources\StaffMembers\StaffMemberResource;
use App\Models\StaffMember;
use Filament\Resources\Pages\CreateRecord;

class CreateStaffMember extends CreateRecord
{
    use HandlesWebpUploads;

    protected static string $resource = StaffMemberResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = $this->normalizeTypeFields($data);

        return $this->processWebpUpload(
            data: $data,
            field: 'photo',
            directory: 'staff',
            maxWidth: 1200,
            quality: 80,
        );
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
