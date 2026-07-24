<?php

namespace Tests\Feature\Filament\Galleries;

use App\Filament\Resources\Galleries\Pages\EditGallery;
use App\Filament\Resources\Galleries\Pages\ListGalleries;
use App\Models\Gallery;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class GalleryMediaCleanupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        Filament::setCurrentPanel('admin');

        $this->actingAs(
            User::factory()->create([
                'role' => 'super_admin',
            ])
        );
    }

    public function test_it_deletes_the_image_when_gallery_is_deleted_from_edit_page(): void
    {
        $imagePath = 'gallery/edit-delete-test.webp';

        Storage::disk('public')->put(
            $imagePath,
            'fake image contents',
        );

        $gallery = Gallery::query()->create([
            'title' => 'Galeri untuk Dihapus',
            'description' => 'Pengujian cleanup dari edit.',
            'image' => $imagePath,
        ]);

        Livewire::test(EditGallery::class, [
            'record' => $gallery->getRouteKey(),
        ])
            ->callAction('delete');

        $this->assertDatabaseMissing('galleries', [
            'id' => $gallery->getKey(),
        ]);

        Storage::disk('public')->assertMissing(
            $imagePath,
        );
    }

    public function test_it_deletes_the_image_when_gallery_is_deleted_from_list_page(): void
    {
        $imagePath = 'gallery/list-delete-test.webp';

        Storage::disk('public')->put(
            $imagePath,
            'fake image contents',
        );

        $gallery = Gallery::query()->create([
            'title' => 'Galeri untuk Dihapus dari Tabel',
            'description' => 'Pengujian cleanup dari list.',
            'image' => $imagePath,
        ]);

        Livewire::test(ListGalleries::class)
            ->callTableAction(
                'delete',
                $gallery,
            );

        $this->assertDatabaseMissing('galleries', [
            'id' => $gallery->getKey(),
        ]);

        Storage::disk('public')->assertMissing(
            $imagePath,
        );
    }
}
