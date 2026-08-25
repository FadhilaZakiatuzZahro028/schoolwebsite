<?php

namespace Tests\Feature\Public;

use App\Models\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_gallery_index_displays_available_items(): void
    {
        $galleryItem = $this->createGalleryItem(
            title: 'Upacara Bendera',
            image: 'galleries/upacara-bendera.webp',
            daysAgo: 0,
        );

        $this->get(route('gallery.index'))
            ->assertSuccessful()
            ->assertSee('Galeri Sekolah')
            ->assertSee($galleryItem->title)
            ->assertSee($galleryItem->description);
    }

    public function test_gallery_index_displays_newest_items_first(): void
    {
        $olderItem = $this->createGalleryItem(
            title: 'Kegiatan Lama',
            image: 'galleries/kegiatan-lama.webp',
            daysAgo: 5,
        );

        $newerItem = $this->createGalleryItem(
            title: 'Kegiatan Terbaru',
            image: 'galleries/kegiatan-terbaru.webp',
            daysAgo: 1,
        );

        $this->get(route('gallery.index'))
            ->assertSuccessful()
            ->assertSeeInOrder([
                $newerItem->title,
                $olderItem->title,
            ]);
    }

    public function test_gallery_index_displays_empty_state(): void
    {
        $this->get(route('gallery.index'))
            ->assertSuccessful()
            ->assertSee('Belum Ada Foto')
            ->assertSee(
    'Dokumentasi sekolah akan ditampilkan setelah',
)
->assertSee(
    'ditambahkan melalui panel admin.',
);
    }

    private function createGalleryItem(
        string $title,
        string $image,
        int $daysAgo,
    ): Gallery {
        $galleryItem = Gallery::query()->create([
            'title' => $title,
            'description' => "Dokumentasi {$title}.",
            'image' => $image,
        ]);

        $timestamp = now()->subDays($daysAgo);

        $galleryItem->forceFill([
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ])->saveQuietly();

        return $galleryItem->refresh();
    }
}