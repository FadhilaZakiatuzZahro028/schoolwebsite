
<?php


use App\Models\StaffMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_page_only_displays_active_teachers(): void
    {
        $activeTeacher = $this->createStaff([
            'name' => 'Guru Aktif',
            'staff_type' => StaffMember::TYPE_TEACHER,
            'is_active' => true,
        ]);

        $inactiveTeacher = $this->createStaff([
            'name' => 'Guru Tidak Aktif',
            'staff_type' => StaffMember::TYPE_TEACHER,
            'is_active' => false,
        ]);

        $employee = $this->createStaff([
            'name' => 'Karyawan Aktif',
            'staff_type' => StaffMember::TYPE_EMPLOYEE,
            'is_active' => true,
        ]);

        $this->get(route('teachers.index'))
            ->assertSuccessful()
            ->assertSee($activeTeacher->name)
            ->assertDontSee($inactiveTeacher->name)
            ->assertDontSee($employee->name);
    }

    public function test_employee_page_only_displays_active_employees(): void
    {
        $activeEmployee = $this->createStaff([
            'name' => 'Karyawan Aktif',
            'staff_type' => StaffMember::TYPE_EMPLOYEE,
            'is_active' => true,
        ]);

        $inactiveEmployee = $this->createStaff([
            'name' => 'Karyawan Tidak Aktif',
            'staff_type' => StaffMember::TYPE_EMPLOYEE,
            'is_active' => false,
        ]);

        $teacher = $this->createStaff([
            'name' => 'Guru Aktif',
            'staff_type' => StaffMember::TYPE_TEACHER,
            'is_active' => true,
        ]);

        $this->get(route('employees.index'))
            ->assertSuccessful()
            ->assertSee($activeEmployee->name)
            ->assertDontSee($inactiveEmployee->name)
            ->assertDontSee($teacher->name);
    }

    public function test_teacher_page_orders_staff_by_sort_order_then_name(): void
    {
        $teacherC = $this->createStaff([
            'name' => 'Citra Guru',
            'staff_type' => StaffMember::TYPE_TEACHER,
            'sort_order' => 2,
        ]);

        $teacherB = $this->createStaff([
            'name' => 'Budi Guru',
            'staff_type' => StaffMember::TYPE_TEACHER,
            'sort_order' => 1,
        ]);

        $teacherA = $this->createStaff([
            'name' => 'Andi Guru',
            'staff_type' => StaffMember::TYPE_TEACHER,
            'sort_order' => 1,
        ]);

        $this->get(route('teachers.index'))
            ->assertSuccessful()
            ->assertSeeInOrder([
                $teacherA->name,
                $teacherB->name,
                $teacherC->name,
            ]);
    }

    public function test_employee_page_orders_staff_by_sort_order_then_name(): void
    {
        $employeeC = $this->createStaff([
            'name' => 'Citra Karyawan',
            'staff_type' => StaffMember::TYPE_EMPLOYEE,
            'sort_order' => 2,
        ]);

        $employeeB = $this->createStaff([
            'name' => 'Budi Karyawan',
            'staff_type' => StaffMember::TYPE_EMPLOYEE,
            'sort_order' => 1,
        ]);

        $employeeA = $this->createStaff([
            'name' => 'Andi Karyawan',
            'staff_type' => StaffMember::TYPE_EMPLOYEE,
            'sort_order' => 1,
        ]);

        $this->get(route('employees.index'))
            ->assertSuccessful()
            ->assertSeeInOrder([
                $employeeA->name,
                $employeeB->name,
                $employeeC->name,
            ]);
    }

    public function test_teacher_page_displays_subject(): void
    {
        $teacher = $this->createStaff([
            'name' => 'Guru Matematika',
            'staff_type' => StaffMember::TYPE_TEACHER,
            'subject' => 'Matematika',
            'department' => 'Tidak Boleh Tampil',
        ]);

        $this->get(route('teachers.index'))
            ->assertSuccessful()
            ->assertSee($teacher->subject)
            ->assertSee('Mata Pelajaran')
            ->assertDontSee($teacher->department);
    }

    public function test_teacher_page_displays_multiple_ordered_educations(): void
{
    $teacher = $this->createStaff([
        'name' => 'Guru Berpendidikan',
        'staff_type' => StaffMember::TYPE_TEACHER,
        'subject' => 'Matematika',
    ]);

    $teacher->educations()->create([
        'education_level' => 'S2',
        'study_program' => 'Pendidikan Matematika',
        'institution' => 'Universitas Negeri Surabaya',
        'sort_order' => 2,
    ]);

    $teacher->educations()->create([
        'education_level' => 'S1',
        'study_program' => 'Pendidikan Matematika',
        'institution' => 'Universitas Negeri Malang',
        'sort_order' => 1,
    ]);

    $this->get(route('teachers.index'))
        ->assertSuccessful()
        ->assertSee('Riwayat Pendidikan')
        ->assertSeeInOrder([
            'S1 Pendidikan Matematika',
            'Universitas Negeri Malang',
            'S2 Pendidikan Matematika',
            'Universitas Negeri Surabaya',
        ]);
}

    public function test_employee_page_displays_department(): void
    {
        $employee = $this->createStaff([
            'name' => 'Staf Tata Usaha',
            'staff_type' => StaffMember::TYPE_EMPLOYEE,
            'subject' => 'Tidak Boleh Tampil',
            'department' => 'Tata Usaha',
        ]);

        $this->get(route('employees.index'))
            ->assertSuccessful()
            ->assertSee($employee->department)
            ->assertSee('Bagian / Unit')
            ->assertDontSee($employee->subject);
    }

    public function test_employee_page_displays_education_without_study_program(): void
{
    $employee = $this->createStaff([
        'name' => 'Karyawan Berpendidikan',
        'staff_type' => StaffMember::TYPE_EMPLOYEE,
        'department' => 'Tata Usaha',
    ]);

    $employee->educations()->create([
        'education_level' => 'S1',
        'study_program' => null,
        'institution' => 'Universitas Terbuka',
        'sort_order' => 1,
    ]);

    $this->get(route('employees.index'))
        ->assertSuccessful()
        ->assertSee('Riwayat Pendidikan')
        ->assertSee('S1')
        ->assertSee('Universitas Terbuka');
}
    public function test_teacher_page_displays_empty_state(): void
    {
        $this->get(route('teachers.index'))
            ->assertSuccessful()
            ->assertSee('Data Guru Belum Tersedia')
            ->assertSee(
                'Informasi tenaga pendidik akan ditampilkan setelah',
            )
            ->assertSee(
                'ditambahkan melalui panel admin.',
            );
    }

    public function test_employee_page_displays_empty_state(): void
    {
        $this->get(route('employees.index'))
            ->assertSuccessful()
            ->assertSee('Data Karyawan Belum Tersedia')
            ->assertSee(
                'Informasi tenaga kependidikan akan ditampilkan',
            )
            ->assertSee(
                'setelah ditambahkan melalui panel admin.',
            );
    }

    private function createStaff(array $attributes = []): StaffMember
    {
        return StaffMember::query()->create(array_merge([
            'name' => 'Staf Pengujian',
            'staff_type' => StaffMember::TYPE_TEACHER,
            'photo' => null,
            'position' => 'Staf Sekolah',
            'subject' => null,
            'department' => null,
            'is_active' => true,
            'sort_order' => 0,
        ], $attributes));
    }
}
