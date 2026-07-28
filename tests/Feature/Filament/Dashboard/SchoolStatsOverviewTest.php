<?php

namespace Tests\Feature\Filament\Dashboard;

use App\Filament\Widgets\SchoolStatsOverview;
use App\Models\Achievement;
use App\Models\ContactMessage;
use App\Models\Extracurricular;
use App\Models\Facility;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SchoolStatsOverviewTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;

    private NewsCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('admin');

        $this->superAdmin = User::factory()->create([
            'role' => 'super_admin',
        ]);

        $this->actingAs($this->superAdmin);

        $this->category = NewsCategory::query()->create([
            'name' => 'Berita Sekolah',
            'slug' => 'berita-sekolah',
        ]);
    }

    public function test_widget_displays_current_backend_statistics(): void
    {
        $this->createPublishedNews('berita-aktif-1');
        $this->createPublishedNews('berita-aktif-2');

        $this->createNews([
            'title' => 'Berita Draft',
            'slug' => 'berita-draft',
            'status' => 'draft',
            'published_at' => null,
        ]);

        $this->createNews([
            'title' => 'Berita Masa Depan',
            'slug' => 'berita-masa-depan',
            'status' => 'published',
            'published_at' => now()->addDay(),
        ]);

        $deletedNews = $this->createPublishedNews(
            'berita-terhapus',
        );

        $deletedNews->delete();

        $this->createAchievements(3);
        $this->createExtracurriculars(4);
        $this->createFacilities(5);
        $this->createUnreadMessages(6);

        Achievement::query()
            ->firstOrFail()
            ->delete();

        Extracurricular::query()
            ->firstOrFail()
            ->delete();

        Facility::query()
            ->firstOrFail()
            ->delete();

        $readMessage = ContactMessage::query()->create([
            'name' => 'Pengirim Pesan Dibaca',
            'email' => 'dibaca@example.com',
            'subject' => 'Pesan Dibaca',
            'message' => 'Pesan ini sudah dibaca.',
            'is_read' => true,
            'ip_address' => '127.0.0.1',
        ]);

        $deletedUnreadMessage = ContactMessage::query()->create([
            'name' => 'Pengirim Pesan Terhapus',
            'email' => 'terhapus@example.com',
            'subject' => 'Pesan Terhapus',
            'message' => 'Pesan belum dibaca tetapi sudah dihapus.',
            'is_read' => false,
            'ip_address' => '127.0.0.1',
        ]);

        $deletedUnreadMessage->delete();

        Livewire::test(SchoolStatsOverview::class)
            ->assertSuccessful()
            ->assertSee('Total Berita Aktif')
            ->assertSee('2')
            ->assertSee('Total Prestasi')
            ->assertSee('2')
            ->assertSee('Total Ekstrakurikuler')
            ->assertSee('3')
            ->assertSee('Total Fasilitas')
            ->assertSee('4')
            ->assertSee('Pesan Kontak Belum Dibaca')
            ->assertSee('6');

        $this->assertTrue($readMessage->is_read);
    }

    public function test_widget_is_registered_in_admin_panel(): void
    {
        $this->assertContains(
            SchoolStatsOverview::class,
            Filament::getCurrentPanel()->getWidgets(),
        );
    }

    private function createPublishedNews(
        string $slug,
    ): News {
        return $this->createNews([
            'title' => str($slug)
                ->replace('-', ' ')
                ->title()
                ->toString(),
            'slug' => $slug,
            'status' => 'published',
            'published_at' => now()->subMinute(),
        ]);
    }

    private function createNews(
        array $attributes,
    ): News {
        return News::query()->create(
            array_merge([
                'category_id' => $this->category->getKey(),
                'author_id' => $this->superAdmin->getKey(),
                'excerpt' => 'Ringkasan berita pengujian.',
                'content' => '<p>Isi berita pengujian.</p>',
                'thumbnail' => 'news/testing.webp',
                'meta_title' => null,
                'meta_description' => null,
                'view_count' => 0,
            ], $attributes)
        );
    }

    private function createAchievements(int $total): void
    {
        foreach (range(1, $total) as $number) {
            Achievement::query()->create([
                'title' => "Prestasi {$number}",
                'slug' => "prestasi-{$number}",
                'description' => "Deskripsi prestasi {$number}.",
                'level' => 'Sekolah',
                'year' => now()->year,
                'image' => "achievements/{$number}.webp",
            ]);
        }
    }

    private function createExtracurriculars(int $total): void
    {
        foreach (range(1, $total) as $number) {
            Extracurricular::query()->create([
                'name' => "Ekstrakurikuler {$number}",
                'slug' => "ekstrakurikuler-{$number}",
                'description' => "Deskripsi ekstrakurikuler {$number}.",
                'coach_name' => "Pembina {$number}",
                'schedule' => 'Sabtu',
                'image' => "extracurriculars/{$number}.webp",
            ]);
        }
    }

    private function createFacilities(int $total): void
    {
        foreach (range(1, $total) as $number) {
            Facility::query()->create([
                'name' => "Fasilitas {$number}",
                'slug' => "fasilitas-{$number}",
                'description' => "Deskripsi fasilitas {$number}.",
                'image' => "facilities/{$number}.webp",
            ]);
        }
    }

    private function createUnreadMessages(int $total): void
    {
        foreach (range(1, $total) as $number) {
            ContactMessage::query()->create([
                'name' => "Pengirim {$number}",
                'email' => "pengirim{$number}@example.com",
                'subject' => "Pesan {$number}",
                'message' => "Isi pesan {$number}.",
                'is_read' => false,
                'ip_address' => '127.0.0.1',
            ]);
        }
    }
}