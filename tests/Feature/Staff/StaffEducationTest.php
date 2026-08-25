<?php

use App\Models\StaffEducation;
use App\Models\StaffMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffEducationTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_member_can_have_multiple_ordered_educations(): void
    {
        $staff = $this->createStaff();

        $secondEducation = StaffEducation::query()->create([
            'staff_member_id' => $staff->id,
            'education_level' => 'S2',
            'study_program' => 'Pendidikan Matematika',
            'institution' => 'Universitas Negeri Surabaya',
            'sort_order' => 2,
        ]);

        $firstEducation = StaffEducation::query()->create([
            'staff_member_id' => $staff->id,
            'education_level' => 'S1',
            'study_program' => 'Pendidikan Matematika',
            'institution' => 'Universitas Negeri Malang',
            'sort_order' => 1,
        ]);

        $this->assertCount(2, $staff->educations);

        $this->assertSame(
            [
                $firstEducation->id,
                $secondEducation->id,
            ],
            $staff->educations->pluck('id')->all(),
        );
    }

    public function test_staff_education_belongs_to_staff_member(): void
    {
        $staff = $this->createStaff();

        $education = StaffEducation::query()->create([
            'staff_member_id' => $staff->id,
            'education_level' => 'S1',
            'study_program' => 'Pendidikan Matematika',
            'institution' => 'Universitas Negeri Malang',
            'sort_order' => 0,
        ]);

        $this->assertTrue(
            $education->staffMember->is($staff),
        );
    }

    public function test_staff_educations_are_deleted_when_staff_member_is_deleted(): void
    {
        $staff = $this->createStaff();

        $education = StaffEducation::query()->create([
            'staff_member_id' => $staff->id,
            'education_level' => 'S1',
            'study_program' => null,
            'institution' => 'Universitas Negeri Malang',
            'sort_order' => 0,
        ]);

        $staff->delete();

        $this->assertDatabaseMissing('staff_educations', [
            'id' => $education->id,
        ]);
    }

    private function createStaff(): StaffMember
    {
        return StaffMember::query()->create([
            'name' => 'Guru Pengujian',
            'staff_type' => StaffMember::TYPE_TEACHER,
            'photo' => null,
            'position' => 'Guru',
            'subject' => 'Matematika',
            'department' => null,
            'is_active' => true,
            'sort_order' => 0,
        ]);
    }
}