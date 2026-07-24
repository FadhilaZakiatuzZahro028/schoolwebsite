<?php

namespace Tests\Feature\Filament\Facilities;

use App\Models\Facility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FacilityMediaCleanupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_it_keeps_image_when_facility_is_soft_deleted(): void
    {
        $imagePath = 'facilities/soft-delete-facility.webp';

        Storage::disk('public')->put(
            $imagePath,
            'fake image contents',
        );

        $facility = $this->createFacility(
            imagePath: $imagePath,
            slug: 'laboratorium-soft-delete',
        );

        $facility->delete();

        $this->assertSoftDeleted('facilities', [
            'id' => $facility->getKey(),
        ]);

        Storage::disk('public')->assertExists(
            $imagePath,
        );
    }

    public function test_it_deletes_image_when_facility_is_force_deleted(): void
    {
        $imagePath = 'facilities/force-delete-facility.webp';

        Storage::disk('public')->put(
            $imagePath,
            'fake image contents',
        );

        $facility = $this->createFacility(
            imagePath: $imagePath,
            slug: 'laboratorium-force-delete',
        );

        $facility->forceDelete();

        $this->assertDatabaseMissing('facilities', [
            'id' => $facility->getKey(),
        ]);

        Storage::disk('public')->assertMissing(
            $imagePath,
        );
    }

    private function createFacility(
        string $imagePath,
        string $slug,
    ): Facility {
        return Facility::query()->create([
            'name' => 'Laboratorium Komputer',
            'slug' => $slug,
            'description' => 'Data pengujian cleanup media fasilitas.',
            'image' => $imagePath,
        ]);
    }
}
