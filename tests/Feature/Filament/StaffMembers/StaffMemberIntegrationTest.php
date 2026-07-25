<?php

namespace Tests\Feature\Filament\StaffMembers;

use App\Filament\Resources\StaffMembers\Pages\CreateStaffMember;
use App\Filament\Resources\StaffMembers\Pages\EditStaffMember;
use App\Models\StaffMember;
use App\Models\User;
use App\Services\ImageUploadService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class StaffMemberIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        Filament::setCurrentPanel('admin');

        $this->actingAs(
            User::factory()->create([
                'role' => 'super_admin',
            ])
        );
    }

    public function test_it_creates_teacher_with_webp_photo(): void
    {
        $photo = UploadedFile::fake()
            ->image('teacher.jpg', 600, 600)
            ->size(1024);

        Livewire::test(CreateStaffMember::class)
            ->fillForm([
                'name' => 'Budi Santoso, S.Pd.',
                'staff_type' => StaffMember::TYPE_TEACHER,
                'photo' => $photo,
                'position' => 'Guru Mata Pelajaran',
                'subject' => 'Matematika',
                'is_active' => true,
                'sort_order' => 1,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $staffMember = StaffMember::query()->firstOrFail();

        $this->assertSame(
            StaffMember::TYPE_TEACHER,
            $staffMember->staff_type,
        );

        $this->assertSame(
            'Matematika',
            $staffMember->subject,
        );

        $this->assertNull($staffMember->department);
        $this->assertNotNull($staffMember->photo);

        $this->assertStringStartsWith(
            'staff/',
            $staffMember->photo,
        );

        $this->assertStringEndsWith(
            '.webp',
            $staffMember->photo,
        );

        Storage::disk('public')->assertExists(
            $staffMember->photo,
        );
    }

    public function test_it_creates_employee_without_teacher_subject(): void
    {
        Livewire::test(CreateStaffMember::class)
            ->fillForm([
                'name' => 'Siti Aminah',
                'staff_type' => StaffMember::TYPE_EMPLOYEE,
                'position' => 'Staf Administrasi',
                'department' => 'Tata Usaha',
                'is_active' => true,
                'sort_order' => 2,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $staffMember = StaffMember::query()->firstOrFail();

        $this->assertSame(
            StaffMember::TYPE_EMPLOYEE,
            $staffMember->staff_type,
        );

        $this->assertSame(
            'Tata Usaha',
            $staffMember->department,
        );

        $this->assertNull($staffMember->subject);
        $this->assertNull($staffMember->photo);
    }

    public function test_it_replaces_photo_and_normalizes_type_specific_fields(): void
    {
        $oldPhoto = app(ImageUploadService::class)->storeAsWebp(
            file: UploadedFile::fake()
                ->image('old-teacher.jpg', 600, 600)
                ->size(1024),
            directory: 'staff',
            maxWidth: 1200,
            quality: 80,
        );

        $this->assertNotNull($oldPhoto);

        $staffMember = StaffMember::query()->create([
            'name' => 'Ahmad Fauzi, S.Pd.',
            'staff_type' => StaffMember::TYPE_TEACHER,
            'photo' => $oldPhoto,
            'position' => 'Guru',
            'subject' => 'Bahasa Indonesia',
            'department' => null,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $newPhoto = UploadedFile::fake()
            ->image('new-employee.png', 600, 600)
            ->size(1024);

        Livewire::test(EditStaffMember::class, [
            'record' => $staffMember->getRouteKey(),
        ])
            ->fillForm([
                'name' => 'Ahmad Fauzi',
                'staff_type' => StaffMember::TYPE_EMPLOYEE,
                'position' => 'Kepala Tata Usaha',
                'department' => 'Tata Usaha',
                'is_active' => true,
                'sort_order' => 1,
            ])
            ->set('data.photo', [])
            ->set('data.photo', [$newPhoto])
            ->call('save')
            ->assertHasNoFormErrors();

        $staffMember->refresh();

        $this->assertSame(
            StaffMember::TYPE_EMPLOYEE,
            $staffMember->staff_type,
        );

        $this->assertNull($staffMember->subject);

        $this->assertSame(
            'Tata Usaha',
            $staffMember->department,
        );

        $this->assertNotSame(
            $oldPhoto,
            $staffMember->photo,
        );

        Storage::disk('public')->assertMissing($oldPhoto);

        Storage::disk('public')->assertExists(
            $staffMember->photo,
        );
    }

    public function test_it_deletes_staff_member_and_photo(): void
    {
        $photo = app(ImageUploadService::class)->storeAsWebp(
            file: UploadedFile::fake()
                ->image('deleted-staff.jpg', 600, 600)
                ->size(1024),
            directory: 'staff',
            maxWidth: 1200,
            quality: 80,
        );

        $this->assertNotNull($photo);

        $staffMember = StaffMember::query()->create([
            'name' => 'Rina Wulandari, S.Pd.',
            'staff_type' => StaffMember::TYPE_TEACHER,
            'photo' => $photo,
            'position' => 'Guru',
            'subject' => 'Biologi',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(EditStaffMember::class, [
            'record' => $staffMember->getRouteKey(),
        ])
            ->callAction('delete');

        $this->assertDatabaseMissing('staff_members', [
            'id' => $staffMember->getKey(),
        ]);

        Storage::disk('public')->assertMissing($photo);
    }
}
