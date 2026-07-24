<?php

namespace Tests\Feature\Filament\Extracurriculars;

use App\Models\Extracurricular;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExtracurricularMediaCleanupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_it_keeps_image_when_extracurricular_is_soft_deleted(): void
    {
        $imagePath = 'extracurriculars/soft-delete-extracurricular.webp';

        Storage::disk('public')->put(
            $imagePath,
            'fake image contents',
        );

        $extracurricular = $this->createExtracurricular(
            imagePath: $imagePath,
            slug: 'basket-soft-delete',
        );

        $extracurricular->delete();

        $this->assertSoftDeleted('extracurriculars', [
            'id' => $extracurricular->getKey(),
        ]);

        Storage::disk('public')->assertExists(
            $imagePath,
        );
    }

    public function test_it_deletes_image_when_extracurricular_is_force_deleted(): void
    {
        $imagePath = 'extracurriculars/force-delete-extracurricular.webp';

        Storage::disk('public')->put(
            $imagePath,
            'fake image contents',
        );

        $extracurricular = $this->createExtracurricular(
            imagePath: $imagePath,
            slug: 'basket-force-delete',
        );

        $extracurricular->forceDelete();

        $this->assertDatabaseMissing('extracurriculars', [
            'id' => $extracurricular->getKey(),
        ]);

        Storage::disk('public')->assertMissing(
            $imagePath,
        );
    }

    private function createExtracurricular(
        string $imagePath,
        string $slug,
    ): Extracurricular {
        return Extracurricular::query()->create([
            'name' => 'Ekstrakurikuler Basket',
            'slug' => $slug,
            'description' => 'Data pengujian cleanup media.',
            'coach_name' => 'Bapak Pembina',
            'schedule' => 'Jumat, 15.00 WIB',
            'image' => $imagePath,
        ]);
    }
}
