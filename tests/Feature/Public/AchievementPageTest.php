<?php

namespace Tests\Feature\Public;

use App\Models\Achievement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AchievementPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_achievement_index_displays_available_achievements(): void
    {
        $achievement = Achievement::query()->create([
            'title' => 'Juara Olimpiade Nasional',
            'slug' => 'juara-olimpiade-nasional',
            'description' => 'Prestasi siswa dalam olimpiade nasional.',
            'level' => 'Nasional',
            'year' => 2026,
            'image' => 'achievements/olimpiade.webp',
        ]);

        $this->get(route('achievements.index'))
            ->assertSuccessful()
            ->assertSee('Prestasi Sekolah')
            ->assertSee($achievement->title)
            ->assertSee(route('achievements.show', [
                'slug' => $achievement->slug,
            ]), false);
    }

    public function test_achievement_detail_displays_selected_achievement(): void
    {
        $achievement = Achievement::query()->create([
            'title' => 'Juara Tingkat Provinsi',
            'slug' => 'juara-tingkat-provinsi',
            'description' => 'Deskripsi lengkap prestasi tingkat provinsi.',
            'level' => 'Provinsi',
            'year' => 2025,
            'image' => 'achievements/provinsi.webp',
        ]);

        $this->get(route('achievements.show', [
            'slug' => $achievement->slug,
        ]))
            ->assertSuccessful()
            ->assertSee($achievement->title)
            ->assertSee($achievement->description)
            ->assertSee($achievement->level)
            ->assertSee((string) $achievement->year);
    }

    public function test_achievement_detail_returns_not_found_for_unknown_slug(): void
    {
        $this->get(route('achievements.show', [
            'slug' => 'prestasi-tidak-tersedia',
        ]))
            ->assertNotFound();
    }

    public function test_soft_deleted_achievement_is_not_publicly_accessible(): void
    {
        $achievement = Achievement::query()->create([
            'title' => 'Prestasi Dihapus',
            'slug' => 'prestasi-dihapus',
            'description' => 'Prestasi yang sudah dihapus.',
            'level' => 'Sekolah',
            'year' => 2024,
            'image' => 'achievements/dihapus.webp',
        ]);

        $achievement->delete();

        $this->get(route('achievements.show', [
            'slug' => $achievement->slug,
        ]))
            ->assertNotFound();
    }
}