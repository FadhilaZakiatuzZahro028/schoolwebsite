<?php

namespace Tests\Feature\Public;

use App\Models\Extracurricular;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExtracurricularPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_extracurricular_index_displays_available_items(): void
    {
        $extracurricular = $this->createExtracurricular(
            name: 'Pramuka',
            slug: 'pramuka',
        );

        $this->get(route('extracurriculars.index'))
            ->assertSuccessful()
            ->assertSee('Ekstrakurikuler')
            ->assertSee($extracurricular->name)
            ->assertSee($extracurricular->coach_name)
            ->assertSee($extracurricular->schedule)
            ->assertSee(route('extracurriculars.show', [
                'slug' => $extracurricular->slug,
            ]), false);
    }

    public function test_extracurricular_detail_displays_selected_item(): void
    {
        $extracurricular = $this->createExtracurricular(
            name: 'Paskibra',
            slug: 'paskibra',
        );

        $this->get(route('extracurriculars.show', [
            'slug' => $extracurricular->slug,
        ]))
            ->assertSuccessful()
            ->assertSee($extracurricular->name)
            ->assertSee($extracurricular->description)
            ->assertSee($extracurricular->coach_name)
            ->assertSee($extracurricular->schedule);
    }

    public function test_extracurricular_detail_returns_not_found_for_unknown_slug(): void
    {
        $this->get(route('extracurriculars.show', [
            'slug' => 'kegiatan-tidak-tersedia',
        ]))
            ->assertNotFound();
    }

    public function test_soft_deleted_extracurricular_is_not_publicly_accessible(): void
    {
        $extracurricular = $this->createExtracurricular(
            name: 'Kegiatan Dihapus',
            slug: 'kegiatan-dihapus',
        );

        $extracurricular->delete();

        $this->get(route('extracurriculars.show', [
            'slug' => $extracurricular->slug,
        ]))
            ->assertNotFound();

        $this->get(route('extracurriculars.index'))
            ->assertSuccessful()
            ->assertDontSee($extracurricular->name);
    }

    private function createExtracurricular(
        string $name,
        string $slug,
    ): Extracurricular {
        return Extracurricular::query()->create([
            'name' => $name,
            'slug' => $slug,
            'description' => "Deskripsi kegiatan {$name}.",
            'coach_name' => 'Pembina Pengujian',
            'schedule' => 'Jumat, 15.00 WIB',
            'image' => "extracurriculars/{$slug}.webp",
        ]);
    }
}