<?php

namespace Tests\Feature\Services;

use App\Services\ImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploadServiceTest extends TestCase
{
    public function test_it_converts_uploaded_image_to_webp(): void
    {
        Storage::fake('public');

        $upload = UploadedFile::fake()
            ->image('prestasi.jpg', 1700, 900)
            ->size(1024);

        $path = app(ImageUploadService::class)->storeAsWebp(
            file: $upload,
            directory: 'achievements',
            maxWidth: 1600,
            quality: 80,
        );

        $this->assertNotNull($path);
        $this->assertStringStartsWith('achievements/', $path);
        $this->assertStringEndsWith('.webp', $path);

        Storage::disk('public')->assertExists($path);

        $imageContents = Storage::disk('public')->get($path);
        $imageInformation = getimagesizefromstring($imageContents);

        $this->assertIsArray($imageInformation);
        $this->assertSame('image/webp', $imageInformation['mime']);
        $this->assertLessThanOrEqual(1600, $imageInformation[0]);
    }

    public function test_it_keeps_an_existing_stored_path_unchanged(): void
    {
        Storage::fake('public');

        $existingPath = 'achievements/existing-image.webp';

        $path = app(ImageUploadService::class)->storeAsWebp(
            file: $existingPath,
            directory: 'achievements',
        );

        $this->assertSame($existingPath, $path);
    }

    public function test_it_can_delete_an_existing_image(): void
    {
        Storage::fake('public');

        $path = 'achievements/old-image.webp';

        Storage::disk('public')->put($path, 'temporary-content');
        Storage::disk('public')->assertExists($path);

        app(ImageUploadService::class)->delete($path);

        Storage::disk('public')->assertMissing($path);
    }

    public function test_it_stores_original_image_and_creates_webp_preview(): void
    {
        Storage::fake('public');

        $upload = UploadedFile::fake()
            ->image('materi-kurikulum.png', 1800, 1200)
            ->size(1024);

        $paths = app(ImageUploadService::class)->storeOriginalWithWebpPreview(
            file: $upload,
            directory: 'curriculums',
            maxWidth: 1600,
            quality: 80,
        );

        $this->assertNotNull($paths['original']);
        $this->assertNotNull($paths['preview']);

        $this->assertStringStartsWith('curriculums/', $paths['original']);
        $this->assertStringEndsWith('.png', $paths['original']);

        $this->assertStringStartsWith('curriculums/', $paths['preview']);
        $this->assertStringEndsWith('.webp', $paths['preview']);

        Storage::disk('public')->assertExists($paths['original']);
        Storage::disk('public')->assertExists($paths['preview']);

        $previewContents = Storage::disk('public')->get($paths['preview']);
        $previewInformation = getimagesizefromstring($previewContents);

        $this->assertIsArray($previewInformation);
        $this->assertSame('image/webp', $previewInformation['mime']);
        $this->assertLessThanOrEqual(1600, $previewInformation[0]);
    }
}
