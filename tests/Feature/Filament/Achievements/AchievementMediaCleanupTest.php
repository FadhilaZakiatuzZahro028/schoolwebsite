<?php

namespace Tests\Feature\Filament\Achievements;

use App\Models\Achievement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AchievementMediaCleanupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_it_keeps_image_when_achievement_is_soft_deleted(): void
    {
        $imagePath = 'achievements/soft-delete-achievement.webp';

        Storage::disk('public')->put(
            $imagePath,
            'fake image contents',
        );

        $achievement = $this->createAchievement(
            imagePath: $imagePath,
            slug: 'prestasi-soft-delete',
        );

        $achievement->delete();

        $this->assertSoftDeleted('achievements', [
            'id' => $achievement->getKey(),
        ]);

        Storage::disk('public')->assertExists(
            $imagePath,
        );
    }

    public function test_it_deletes_image_when_achievement_is_force_deleted(): void
    {
        $imagePath = 'achievements/force-delete-achievement.webp';

        Storage::disk('public')->put(
            $imagePath,
            'fake image contents',
        );

        $achievement = $this->createAchievement(
            imagePath: $imagePath,
            slug: 'prestasi-force-delete',
        );

        $achievement->forceDelete();

        $this->assertDatabaseMissing('achievements', [
            'id' => $achievement->getKey(),
        ]);

        Storage::disk('public')->assertMissing(
            $imagePath,
        );
    }

    private function createAchievement(
        string $imagePath,
        string $slug,
    ): Achievement {
        return Achievement::query()->create([
            'title' => 'Juara Olimpiade Sekolah',
            'slug' => $slug,
            'description' => 'Prestasi untuk pengujian cleanup media.',
            'level' => 'Kabupaten',
            'year' => 2026,
            'image' => $imagePath,
        ]);
    }
}
