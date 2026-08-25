<?php

namespace Tests\Feature\Public;

use App\Models\Facility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacilityPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_facility_index_displays_available_facilities(): void
    {
        $facility = $this->createFacility(
            name: 'Laboratorium Komputer',
            slug: 'laboratorium-komputer',
        );

        $this->get(route('facilities.index'))
            ->assertSuccessful()
            ->assertSee('Fasilitas Sekolah')
            ->assertSee($facility->name)
            ->assertSee($facility->description)
            ->assertSee(route('facilities.show', [
                'slug' => $facility->slug,
            ]), false);
    }

    public function test_facility_detail_displays_selected_facility(): void
    {
        $facility = $this->createFacility(
            name: 'Perpustakaan',
            slug: 'perpustakaan',
        );

        $this->get(route('facilities.show', [
            'slug' => $facility->slug,
        ]))
            ->assertSuccessful()
            ->assertSee($facility->name)
            ->assertSee($facility->description);
    }

    public function test_facility_detail_returns_not_found_for_unknown_slug(): void
    {
        $this->get(route('facilities.show', [
            'slug' => 'fasilitas-tidak-tersedia',
        ]))
            ->assertNotFound();
    }

    public function test_soft_deleted_facility_is_not_publicly_accessible(): void
    {
        $facility = $this->createFacility(
            name: 'Fasilitas Dihapus',
            slug: 'fasilitas-dihapus',
        );

        $facility->delete();

        $this->get(route('facilities.show', [
            'slug' => $facility->slug,
        ]))
            ->assertNotFound();

        $this->get(route('facilities.index'))
            ->assertSuccessful()
            ->assertDontSee($facility->name);
    }

    private function createFacility(
        string $name,
        string $slug,
    ): Facility {
        return Facility::query()->create([
            'name' => $name,
            'slug' => $slug,
            'description' => "Deskripsi fasilitas {$name}.",
            'image' => "facilities/{$slug}.webp",
        ]);
    }
}