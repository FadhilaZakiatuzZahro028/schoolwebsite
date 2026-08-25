<?php

namespace Tests\Feature\Public;

use App\Models\SchoolProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_displays_school_information(): void
    {
        $schoolProfile = $this->createSchoolProfile();

        $this->get(route('profile.index'))
            ->assertSuccessful()
            ->assertSee('Profil Sekolah')
            ->assertSee($schoolProfile->school_name)
            ->assertSee($schoolProfile->tagline)
            ->assertSee($schoolProfile->vision)
            ->assertSee($schoolProfile->mission)
            ->assertSee($schoolProfile->principal_name)
            ->assertSee($schoolProfile->principal_message)
            ->assertSee($schoolProfile->address)
            ->assertSee($schoolProfile->phone)
            ->assertSee($schoolProfile->email);
    }

    public function test_history_page_displays_school_history(): void
    {
        $schoolProfile = $this->createSchoolProfile();

        $this->get(route('history.index'))
            ->assertSuccessful()
            ->assertSee('Sejarah Sekolah')
            ->assertSee($schoolProfile->school_name)
            ->assertSee($schoolProfile->tagline)
            ->assertSee($schoolProfile->history)
            ->assertSee(route('profile.index'), false);
    }

    public function test_profile_page_displays_empty_state_when_data_is_unavailable(): void
    {
        $this->get(route('profile.index'))
            ->assertSuccessful()
            ->assertSee('Profil Sekolah Belum Tersedia')
            ->assertSee(
                'Informasi profil sekolah akan ditampilkan setelah',
            )
            ->assertSee(
                'dikonfigurasi melalui panel admin.',
            );
    }

    public function test_history_page_displays_empty_state_when_data_is_unavailable(): void
    {
        $this->get(route('history.index'))
            ->assertSuccessful()
            ->assertSee('Sejarah Sekolah Belum Tersedia')
            ->assertSee(
                'Informasi sejarah sekolah akan ditampilkan setelah',
            )
            ->assertSee(
                'dikonfigurasi melalui panel admin.',
            );
    }

    private function createSchoolProfile(): SchoolProfile
    {
        return SchoolProfile::query()->create([
            'school_name' => 'SMA PGRI 1 Tulungagung',
            'tagline' => 'Unggul, Berkarakter, dan Berprestasi',
            'history' => 'Sekolah didirikan untuk memberikan layanan pendidikan berkualitas.',
            'vision' => 'Terwujudnya sekolah unggul dan berkarakter.',
            'mission' => 'Menyelenggarakan pembelajaran yang aktif dan bermutu.',
            'principal_name' => 'Kepala Sekolah Pengujian',
            'principal_message' => 'Selamat datang di website resmi sekolah.',
            'address' => 'Jalan Pengujian Nomor 1, Tulungagung',
            'phone' => '0355-123456',
            'email' => 'sekolah@example.com',
        ]);
    }
}