<?php

namespace Tests\Feature\Filament\SiteSettings;

use App\Filament\Resources\SiteSettings\Pages\CreateSiteSetting;
use App\Filament\Resources\SiteSettings\Pages\EditSiteSetting;
use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use App\Models\User;
use App\Services\ImageUploadService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SiteSettingWebpIntegrationTest extends TestCase
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

    public function test_it_creates_default_og_image_as_webp(): void
    {
        $ogImageUpload = UploadedFile::fake()
            ->image('default-og-image.png', 1200, 630)
            ->size(1024);

        Livewire::test(CreateSiteSetting::class)
            ->fillForm([
                ...$this->validSiteSettingData(),
                'default_og_image' => $ogImageUpload,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $siteSetting = SiteSetting::query()->firstOrFail();

        $this->assertNotNull($siteSetting->default_og_image);

        $this->assertStringStartsWith(
            'logos/og/',
            $siteSetting->default_og_image,
        );

        $this->assertStringEndsWith(
            '.webp',
            $siteSetting->default_og_image,
        );

        $this->assertTrue(
            Storage::disk('public')->exists(
                $siteSetting->default_og_image,
            )
        );

        $this->assertStoredImageIsValidWebp(
            path: $siteSetting->default_og_image,
            maxWidth: 1600,
        );
    }

    public function test_it_keeps_existing_default_og_image_when_no_new_image_is_uploaded(): void
    {
        $ogImagePath = $this->storeExistingImage(
            filename: 'existing-og-image.png',
        );

        $siteSetting = SiteSetting::query()->create([
            ...$this->validSiteSettingData(),
            'default_og_image' => $ogImagePath,
        ]);

        Livewire::test(EditSiteSetting::class, [
            'record' => $siteSetting->getRouteKey(),
        ])
            ->fillForm([
                ...$this->validSiteSettingData([
                    'site_name' => 'SMA PGRI 1 Tulungagung Updated',
                ]),
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $siteSetting->refresh();

        $this->assertSame(
            $ogImagePath,
            $siteSetting->default_og_image,
        );

        $this->assertTrue(
            Storage::disk('public')->exists($ogImagePath)
        );
    }

    public function test_it_replaces_default_og_image_and_deletes_old_file_after_save(): void
    {
        $oldOgImagePath = $this->storeExistingImage(
            filename: 'old-og-image.png',
        );

        $siteSetting = SiteSetting::query()->create([
            ...$this->validSiteSettingData(),
            'default_og_image' => $oldOgImagePath,
        ]);

        $newOgImageUpload = UploadedFile::fake()
            ->image('replacement-og-image.jpg', 1200, 630)
            ->size(1024);

        Livewire::test(EditSiteSetting::class, [
            'record' => $siteSetting->getRouteKey(),
        ])
            ->set('data.default_og_image', [])
            ->set('data.default_og_image', [$newOgImageUpload])
            ->call('save')
            ->assertHasNoFormErrors();

        $siteSetting->refresh();

        $this->assertNotSame(
            $oldOgImagePath,
            $siteSetting->default_og_image,
        );

        $this->assertStringStartsWith(
            'logos/og/',
            $siteSetting->default_og_image,
        );

        $this->assertStringEndsWith(
            '.webp',
            $siteSetting->default_og_image,
        );

        $this->assertFalse(
            Storage::disk('public')->exists($oldOgImagePath)
        );

        $this->assertTrue(
            Storage::disk('public')->exists(
                $siteSetting->default_og_image,
            )
        );

        $this->assertStoredImageIsValidWebp(
            path: $siteSetting->default_og_image,
            maxWidth: 1600,
        );
    }

    public function test_it_prevents_creating_a_second_site_setting(): void
    {
        SiteSetting::query()->create(
            $this->validSiteSettingData()
        );

        $this->assertFalse(
            SiteSettingResource::canCreate()
        );

        $this->assertSame(
            1,
            SiteSetting::query()->count()
        );
    }

    private function validSiteSettingData(
        array $overrides = [],
    ): array {
        return array_merge([
            'site_name' => 'SMA PGRI 1 Tulungagung',
            'site_description' => 'Website resmi SMA PGRI 1 Tulungagung.',
            'default_meta_keywords' => 'sekolah, sma, tulungagung',
            'copyright_text' => '© 2026 SMA PGRI 1 Tulungagung',
            'is_maintenance' => false,
        ], $overrides);
    }

    private function storeExistingImage(
        string $filename,
    ): string {
        $path = app(ImageUploadService::class)->storeAsWebp(
            file: UploadedFile::fake()->image(
                $filename,
                640,
                336,
            ),
            directory: 'logos/og',
            maxWidth: 1600,
            quality: 80,
        );

        $this->assertNotNull($path);

        return $path;
    }

    private function assertStoredImageIsValidWebp(
        string $path,
        int $maxWidth,
    ): void {
        $contents = Storage::disk('public')->get($path);
        $imageInformation = getimagesizefromstring($contents);

        $this->assertIsArray($imageInformation);

        $this->assertSame(
            'image/webp',
            $imageInformation['mime'],
        );

        $this->assertLessThanOrEqual(
            $maxWidth,
            $imageInformation[0],
        );
    }
}