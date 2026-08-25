<?php

namespace Tests\Feature\Public;

use App\Models\AlumniHighlight;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AlumniPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_alumni_page_only_displays_active_alumni(): void
    {
        $activeAlumni = $this->createAlumni([
            'name' => 'Alumni Aktif Pengujian',
            'is_active' => true,
        ]);

        $inactiveAlumni = $this->createAlumni([
            'name' => 'Alumni Tidak Aktif Pengujian',
            'is_active' => false,
        ]);

        $this->get(route('alumni.index'))
            ->assertSuccessful()
            ->assertSee('Alumni')
            ->assertSee($activeAlumni->name)
            ->assertDontSee($inactiveAlumni->name);
    }

    public function test_alumni_page_limits_active_alumni_to_four(): void
    {
        $alumni = collect(range(1, 5))
            ->map(function (int $index): AlumniHighlight {
                return $this->createAlumni([
                    'name' => "Alumni Pilihan {$index}",
                    'is_active' => false,
                    'sort_order' => $index,
                ]);
            });

        DB::table('alumni_highlights')
            ->update([
                'is_active' => true,
            ]);

        $this->get(route('alumni.index'))
            ->assertSuccessful()
            ->assertSee($alumni[0]->name)
            ->assertSee($alumni[1]->name)
            ->assertSee($alumni[2]->name)
            ->assertSee($alumni[3]->name)
            ->assertDontSee($alumni[4]->name)
            ->assertSee('Alumni Pilihan')
            ->assertSee('4');
    }

    public function test_alumni_page_orders_data_by_sort_order_then_name(): void
    {
        $third = $this->createAlumni([
            'name' => 'Citra Alumni',
            'sort_order' => 2,
        ]);

        $second = $this->createAlumni([
            'name' => 'Budi Alumni',
            'sort_order' => 1,
        ]);

        $first = $this->createAlumni([
            'name' => 'Andi Alumni',
            'sort_order' => 1,
        ]);

        $this->get(route('alumni.index'))
            ->assertSuccessful()
            ->assertSeeInOrder([
                $first->name,
                $second->name,
                $third->name,
            ]);
    }

    public function test_alumni_page_displays_available_profile_information(): void
    {
        $alumni = $this->createAlumni([
            'name' => 'Alumni Berprestasi',
            'graduation_year' => 2020,
            'photo' => 'alumni/highlights/alumni.webp',
            'current_activity' => 'Pengusaha',
            'institution' => 'Perusahaan Alumni',
            'quote' => 'Sekolah memberikan fondasi terbaik.',
        ]);

        $this->get(route('alumni.index'))
            ->assertSuccessful()
            ->assertSee($alumni->name)
            ->assertSee((string) $alumni->graduation_year)
            ->assertSee($alumni->current_activity)
            ->assertSee($alumni->institution)
            ->assertSee($alumni->quote)
            ->assertSee(
                '/storage/' . $alumni->photo,
                false,
            );
    }

    public function test_alumni_page_displays_google_form_cta_when_url_is_available(): void
    {
        $siteSetting = $this->createSiteSetting([
            'alumni_form_url' => 'https://forms.gle/alumni-sekolah',
        ]);

        $this->get(route('alumni.index'))
            ->assertSuccessful()
            ->assertSee('Isi Data Alumni')
            ->assertSee(
                $siteSetting->alumni_form_url,
                false,
            )
            ->assertSee('target="_blank"', false)
            ->assertSee(
                'rel="noopener noreferrer"',
                false,
            )
            ->assertDontSee(
                'Formulir pendataan alumni belum tersedia.',
            );
    }

    public function test_alumni_page_displays_form_fallback_when_url_is_unavailable(): void
    {
        $this->createSiteSetting([
            'alumni_form_url' => null,
        ]);

        $this->get(route('alumni.index'))
            ->assertSuccessful()
            ->assertSee(
                'Formulir pendataan alumni belum tersedia.',
            )
            ->assertDontSee('Isi Data Alumni');
    }

    public function test_alumni_page_displays_empty_state_when_active_data_is_unavailable(): void
    {
        $this->createAlumni([
            'name' => 'Alumni Nonaktif',
            'is_active' => false,
        ]);

        $this->get(route('alumni.index'))
            ->assertSuccessful()
            ->assertSee('Alumni Pilihan Belum Tersedia')
            ->assertSee(
                'Profil alumni pilihan akan ditampilkan setelah',
            )
            ->assertSee(
                'ditambahkan melalui panel admin.',
            )
            ->assertDontSee('Alumni Nonaktif');
    }

    private function createAlumni(
        array $attributes = [],
    ): AlumniHighlight {
        return AlumniHighlight::query()->create(array_merge([
            'name' => 'Alumni Pengujian',
            'graduation_year' => 2020,
            'photo' => null,
            'current_activity' => null,
            'institution' => null,
            'quote' => null,
            'is_active' => true,
            'sort_order' => 0,
        ], $attributes));
    }

    private function createSiteSetting(
        array $attributes = [],
    ): SiteSetting {
        return SiteSetting::query()->create(array_merge([
            'site_name' => 'SMA PGRI 1 Tulungagung',
            'site_description' => 'Website resmi sekolah.',
            'default_meta_keywords' => 'sekolah, pendidikan',
            'default_og_image' => null,
            'copyright_text' => 'SMA PGRI 1 Tulungagung',
            'alumni_form_url' => null,
            'is_maintenance' => false,
        ], $attributes));
    }
}