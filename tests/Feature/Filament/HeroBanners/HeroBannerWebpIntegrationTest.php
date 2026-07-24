<?php

namespace Tests\Feature\Filament\HeroBanners;

use App\Filament\Resources\HeroBanners\Pages\CreateHeroBanner;
use App\Filament\Resources\HeroBanners\Pages\EditHeroBanner;
use App\Models\HeroBanner;
use App\Models\User;
use App\Services\ImageUploadService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class HeroBannerWebpIntegrationTest extends TestCase
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

    public function test_it_creates_a_hero_banner_as_webp_and_deactivates_the_previous_banner(): void
    {
        $previousBanner = HeroBanner::query()->create([
            'title' => 'Banner Lama',
            'subtitle' => null,
            'image' => 'heroes/previous-banner.webp',
            'button_text' => null,
            'button_url' => null,
            'sort_order' => 0,
            'is_active' => true,
        ]);

        $upload = UploadedFile::fake()
            ->image('hero-source.jpg', 480, 270)
            ->size(1024);

        Livewire::test(CreateHeroBanner::class)
            ->fillForm([
                'title' => 'Banner Baru',
                'subtitle' => 'Selamat datang di website sekolah',
                'image' => $upload,
                'button_text' => 'Lihat Profil',
                'button_url' => '/profil',
                'sort_order' => 1,
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $createdBanner = HeroBanner::query()
            ->whereKeyNot($previousBanner->getKey())
            ->firstOrFail();

        $this->assertFalse($previousBanner->fresh()->is_active);
        $this->assertTrue($createdBanner->is_active);
        $this->assertStringStartsWith('heroes/', $createdBanner->image);
        $this->assertStringEndsWith('.webp', $createdBanner->image);

        $this->assertTrue(
            Storage::disk('public')->exists($createdBanner->image)
        );
        $this->assertStoredImageIsValidWebp($createdBanner->image);
    }

    public function test_it_replaces_the_image_and_deletes_the_old_file_after_save(): void
    {
        $oldPath = $this->storeExistingHeroImage('old-hero.jpg');

        $banner = HeroBanner::query()->create([
            'title' => 'Banner Utama',
            'subtitle' => null,
            'image' => $oldPath,
            'button_text' => null,
            'button_url' => null,
            'sort_order' => 0,
            'is_active' => true,
        ]);

        $newUpload = UploadedFile::fake()
            ->image('replacement.png', 480, 270)
            ->size(1024);

        Livewire::test(EditHeroBanner::class, [
            'record' => $banner->getRouteKey(),
        ])
            ->fillForm([
                'title' => 'Banner Utama Diperbarui',
                'subtitle' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 0,
                'is_active' => true,
            ])
            ->set('data.image', [])
            ->set('data.image', [$newUpload])
            ->call('save')
            ->assertHasNoFormErrors();

        $banner->refresh();

        $this->assertNotSame($oldPath, $banner->image);
        $this->assertStringStartsWith('heroes/', $banner->image);
        $this->assertStringEndsWith('.webp', $banner->image);

        $this->assertFalse(
            Storage::disk('public')->exists($oldPath)
        );

        $this->assertTrue(
            Storage::disk('public')->exists($banner->image)
        );

        $this->assertStoredImageIsValidWebp($banner->image);
    }

    public function test_it_keeps_the_existing_image_when_no_new_image_is_uploaded(): void
    {
        $existingPath = $this->storeExistingHeroImage('existing-hero.jpg');

        $banner = HeroBanner::query()->create([
            'title' => 'Banner Sebelum Edit',
            'subtitle' => null,
            'image' => $existingPath,
            'button_text' => null,
            'button_url' => null,
            'sort_order' => 0,
            'is_active' => true,
        ]);

        Livewire::test(EditHeroBanner::class, [
            'record' => $banner->getRouteKey(),
        ])
            ->fillForm([
                'title' => 'Banner Setelah Edit',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $banner->refresh();

        $this->assertSame($existingPath, $banner->image);
        $this->assertTrue(
            Storage::disk('public')->exists($existingPath)
        );
    }

    private function storeExistingHeroImage(string $filename): string
    {
        $path = app(ImageUploadService::class)->storeAsWebp(
            file: UploadedFile::fake()->image($filename, 480, 270),
            directory: 'heroes',
            maxWidth: 1600,
            quality: 80,
        );

        $this->assertNotNull($path);

        return $path;
    }

    private function assertStoredImageIsValidWebp(string $path): void
    {
        $contents = Storage::disk('public')->get($path);
        $imageInformation = getimagesizefromstring($contents);

        $this->assertIsArray($imageInformation);
        $this->assertSame('image/webp', $imageInformation['mime']);
        $this->assertLessThanOrEqual(1600, $imageInformation[0]);
    }
}
