<?php

namespace Tests\Feature\Filament\News;

use App\Filament\Resources\News\Pages\CreateNews;
use App\Filament\Resources\News\Pages\EditNews;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use App\Services\ImageUploadService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class NewsWebpIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private NewsCategory $category;

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

        $this->category = NewsCategory::query()->create([
            'name' => 'Berita Sekolah',
            'slug' => 'berita-sekolah',
        ]);
    }

    public function test_it_creates_news_thumbnail_as_webp(): void
    {
        $upload = UploadedFile::fake()
            ->image('news-source.jpg', 480, 270)
            ->size(1024);

        Livewire::test(CreateNews::class)
            ->fillForm([
                'title' => 'Berita Baru Sekolah',
                'slug' => null,
                'category_id' => $this->category->getKey(),
                'status' => 'published',
                'published_at' => null,
                'thumbnail' => $upload,
                'excerpt' => 'Ringkasan berita baru sekolah.',
                'content' => '<p>Isi lengkap berita baru sekolah.</p>',
                'meta_title' => null,
                'meta_description' => null,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $news = News::query()->firstOrFail();

        $this->assertStringStartsWith('news/', $news->thumbnail);
        $this->assertStringEndsWith('.webp', $news->thumbnail);
        $this->assertNotNull($news->published_at);
        $this->assertSame('berita-baru-sekolah', $news->slug);

        $this->assertTrue(
            Storage::disk('public')->exists($news->thumbnail)
        );

        $this->assertStoredImageIsValidWebp($news->thumbnail);
    }

    public function test_it_replaces_thumbnail_and_deletes_old_file_after_save(): void
    {
        $oldPath = $this->storeExistingNewsImage('old-news.jpg');

        $news = News::query()->create([
            'category_id' => $this->category->getKey(),
            'author_id' => auth()->id(),
            'title' => 'Berita Lama',
            'slug' => 'berita-lama',
            'excerpt' => 'Ringkasan berita lama.',
            'content' => '<p>Isi berita lama.</p>',
            'thumbnail' => $oldPath,
            'status' => 'draft',
            'meta_title' => 'Berita Lama',
            'meta_description' => 'Deskripsi berita lama.',
            'view_count' => 0,
            'published_at' => null,
        ]);

        $newUpload = UploadedFile::fake()
            ->image('replacement.png', 480, 270)
            ->size(1024);

        Livewire::test(EditNews::class, [
            'record' => $news->getRouteKey(),
        ])
            ->fillForm([
                'title' => 'Berita Diperbarui',
                'slug' => 'berita-diperbarui',
                'category_id' => $this->category->getKey(),
                'status' => 'draft',
                'published_at' => null,
                'excerpt' => 'Ringkasan berita diperbarui.',
                'content' => '<p>Isi berita diperbarui.</p>',
                'meta_title' => 'Berita Diperbarui',
                'meta_description' => 'Deskripsi berita diperbarui.',
            ])
            ->set('data.thumbnail', [])
            ->set('data.thumbnail', [$newUpload])
            ->call('save')
            ->assertHasNoFormErrors();

        $news->refresh();

        $this->assertNotSame($oldPath, $news->thumbnail);
        $this->assertStringStartsWith('news/', $news->thumbnail);
        $this->assertStringEndsWith('.webp', $news->thumbnail);

        $this->assertFalse(
            Storage::disk('public')->exists($oldPath)
        );

        $this->assertTrue(
            Storage::disk('public')->exists($news->thumbnail)
        );

        $this->assertStoredImageIsValidWebp($news->thumbnail);
    }

    public function test_it_keeps_existing_thumbnail_when_no_new_thumbnail_is_uploaded(): void
    {
        $existingPath = $this->storeExistingNewsImage('existing-news.jpg');

        $news = News::query()->create([
            'category_id' => $this->category->getKey(),
            'author_id' => auth()->id(),
            'title' => 'Berita Sebelum Edit',
            'slug' => 'berita-sebelum-edit',
            'excerpt' => 'Ringkasan sebelum edit.',
            'content' => '<p>Isi berita sebelum edit.</p>',
            'thumbnail' => $existingPath,
            'status' => 'draft',
            'meta_title' => 'Berita Sebelum Edit',
            'meta_description' => 'Deskripsi sebelum edit.',
            'view_count' => 0,
            'published_at' => null,
        ]);

        Livewire::test(EditNews::class, [
            'record' => $news->getRouteKey(),
        ])
            ->fillForm([
                'title' => 'Berita Setelah Edit',
                'slug' => 'berita-setelah-edit',
                'category_id' => $this->category->getKey(),
                'status' => 'draft',
                'excerpt' => 'Ringkasan setelah edit.',
                'content' => '<p>Isi berita setelah edit.</p>',
                'meta_title' => 'Berita Setelah Edit',
                'meta_description' => 'Deskripsi setelah edit.',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $news->refresh();

        $this->assertSame($existingPath, $news->thumbnail);

        $this->assertTrue(
            Storage::disk('public')->exists($existingPath)
        );
    }

    public function test_it_keeps_thumbnail_when_news_is_soft_deleted(): void
    {
        $thumbnailPath = 'news/soft-delete-news.webp';

        Storage::disk('public')->put(
            $thumbnailPath,
            'fake image contents',
        );

        $news = News::query()->create([
            'category_id' => $this->category->getKey(),
            'author_id' => auth()->id(),
            'title' => 'Berita untuk Soft Delete',
            'slug' => 'berita-untuk-soft-delete',
            'excerpt' => 'Ringkasan berita.',
            'content' => '<p>Isi berita.</p>',
            'thumbnail' => $thumbnailPath,
            'status' => 'draft',
            'meta_title' => 'Berita untuk Soft Delete',
            'meta_description' => 'Deskripsi berita.',
            'view_count' => 0,
            'published_at' => null,
        ]);

        $news->delete();

        $this->assertSoftDeleted('news', [
            'id' => $news->getKey(),
        ]);

        Storage::disk('public')->assertExists(
            $thumbnailPath,
        );
    }

    public function test_it_deletes_thumbnail_when_news_is_force_deleted(): void
    {
        $thumbnailPath = 'news/force-delete-news.webp';

        Storage::disk('public')->put(
            $thumbnailPath,
            'fake image contents',
        );

        $news = News::query()->create([
            'category_id' => $this->category->getKey(),
            'author_id' => auth()->id(),
            'title' => 'Berita untuk Force Delete',
            'slug' => 'berita-untuk-force-delete',
            'excerpt' => 'Ringkasan berita.',
            'content' => '<p>Isi berita.</p>',
            'thumbnail' => $thumbnailPath,
            'status' => 'draft',
            'meta_title' => 'Berita untuk Force Delete',
            'meta_description' => 'Deskripsi berita.',
            'view_count' => 0,
            'published_at' => null,
        ]);

        $news->forceDelete();

        $this->assertDatabaseMissing('news', [
            'id' => $news->getKey(),
        ]);

        Storage::disk('public')->assertMissing(
            $thumbnailPath,
        );
    }

    private function storeExistingNewsImage(string $filename): string
    {
        $path = app(ImageUploadService::class)->storeAsWebp(
            file: UploadedFile::fake()->image($filename, 480, 270),
            directory: 'news',
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
