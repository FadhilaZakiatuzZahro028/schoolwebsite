<?php

namespace Tests\Feature\Public;

use App\Models\FeaturedProgram;
use App\Models\FeaturedProgramSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeaturedProgramPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_displays_setting_and_active_programs_in_order(): void
    {
        FeaturedProgramSetting::query()->create([
            'introduction' => 'Pengantar Program Unggulan sekolah.',
            'collaboration_text' => 'Kolaborasi pengembangan keterampilan bersama LPK dan BLK.',
        ]);

        $secondProgram = $this->createProgram([
            'name' => 'Bahasa Korea',
            'sort_order' => 2,
        ]);

        $firstProgram = $this->createProgram([
            'name' => 'Tata Boga',
            'sort_order' => 1,
        ]);

        $inactiveProgram = $this->createProgram([
            'name' => 'Program Nonaktif',
            'sort_order' => 0,
            'is_active' => false,
        ]);

        $response = $this->get(
            route('featured-programs.index'),
        );

        $response
            ->assertSuccessful()
            ->assertSee('Program Unggulan')
            ->assertSee(
                'Pengantar Program Unggulan sekolah.',
            )
            ->assertSee(
                'Kolaborasi pengembangan keterampilan bersama LPK dan BLK.',
            )
            ->assertSee($firstProgram->name)
            ->assertSee($secondProgram->name)
            ->assertDontSee($inactiveProgram->name)
            ->assertSeeInOrder([
                $firstProgram->name,
                $secondProgram->name,
            ]);
    }

    public function test_page_displays_optional_documentation_images(): void
    {
        $program = $this->createProgram([
            'name' => 'Desain Grafis',
        ]);

        $firstImage = $program->images()->create([
            'image' => 'featured-programs/desain-1.webp',
            'alt_text' => 'Siswa berlatih desain grafis.',
            'sort_order' => 0,
        ]);

        $secondImage = $program->images()->create([
            'image' => 'featured-programs/desain-2.webp',
            'alt_text' => null,
            'sort_order' => 1,
        ]);

        $this->get(route('featured-programs.index'))
            ->assertSuccessful()
            ->assertSee('Dokumentasi Kegiatan')
            ->assertSee(
                asset('storage/' . $firstImage->image),
                false,
            )
            ->assertSee(
                'Siswa berlatih desain grafis.',
            )
            ->assertSee(
                asset('storage/' . $secondImage->image),
                false,
            )
            ->assertSee(
                'Dokumentasi Desain Grafis',
            );
    }

    public function test_page_still_works_without_page_setting(): void
    {
        $program = $this->createProgram([
            'name' => 'Otomotif',
        ]);

        $this->get(route('featured-programs.index'))
            ->assertSuccessful()
            ->assertSee('Program Unggulan')
            ->assertSee($program->name);
    }

    public function test_page_shows_empty_state_when_no_active_program_exists(): void
    {
        $inactiveProgram = $this->createProgram([
            'name' => 'Program Tidak Aktif',
            'is_active' => false,
        ]);

        $this->get(route('featured-programs.index'))
            ->assertSuccessful()
            ->assertSee(
                'Program Unggulan Belum Tersedia',
            )
            ->assertDontSee(
                $inactiveProgram->name,
            );
    }

    public function test_navigation_contains_featured_program_link(): void
    {
        $this->get(route('featured-programs.index'))
            ->assertSuccessful()
            ->assertSee(
                route('featured-programs.index'),
                false,
            )
            ->assertSee('Program Unggulan');
    }

    private function createProgram(
        array $attributes = [],
    ): FeaturedProgram {
        return FeaturedProgram::query()->create(
            array_merge([
                'name' => 'Bahasa Korea',
                'summary' => 'Ringkasan keterampilan.',
                'description' => 'Deskripsi Program Unggulan.',
                'image' => 'featured-programs/program.webp',
                'is_active' => true,
                'sort_order' => 0,
            ], $attributes),
        );
    }
}