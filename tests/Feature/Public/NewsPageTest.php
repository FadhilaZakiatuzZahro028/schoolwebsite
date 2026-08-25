<?php

namespace Tests\Feature\Public;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_index_displays_only_published_news(): void
    {
        $category = $this->createCategory();

        $publishedNews = $this->createNews(
            categoryId: $category->id,
            title: 'Berita Sudah Terbit',
            slug: 'berita-sudah-terbit',
            status: 'published',
            publishedAt: now()->subDay(),
        );

        $this->createNews(
            categoryId: $category->id,
            title: 'Berita Draft',
            slug: 'berita-draft',
            status: 'draft',
            publishedAt: now()->subDay(),
        );

        $this->createNews(
            categoryId: $category->id,
            title: 'Berita Masa Depan',
            slug: 'berita-masa-depan',
            status: 'published',
            publishedAt: now()->addDay(),
        );

        $this->get(route('news.index'))
            ->assertSuccessful()
            ->assertSee('Berita Sekolah')
            ->assertSee($publishedNews->title)
            ->assertSee(route('news.show', [
                'slug' => $publishedNews->slug,
            ]), false)
            ->assertDontSee('Berita Draft')
            ->assertDontSee('Berita Masa Depan');
    }

    public function test_news_detail_displays_published_news(): void
    {
        $category = $this->createCategory();

        $news = $this->createNews(
            categoryId: $category->id,
            title: 'Kegiatan Sekolah Terbaru',
            slug: 'kegiatan-sekolah-terbaru',
            status: 'published',
            publishedAt: now()->subHour(),
        );

        $this->get(route('news.show', [
            'slug' => $news->slug,
        ]))
            ->assertSuccessful()
            ->assertSee($news->title)
            ->assertSee($news->excerpt)
            ->assertSee('Isi Kegiatan Sekolah Terbaru.', false)
            ->assertSee($category->name);
    }

    public function test_draft_news_is_not_publicly_accessible(): void
    {
        $category = $this->createCategory();

        $news = $this->createNews(
            categoryId: $category->id,
            title: 'Berita Belum Siap',
            slug: 'berita-belum-siap',
            status: 'draft',
            publishedAt: now(),
        );

        $this->get(route('news.show', [
            'slug' => $news->slug,
        ]))
            ->assertNotFound();
    }

    public function test_future_news_is_not_publicly_accessible(): void
    {
        $category = $this->createCategory();

        $news = $this->createNews(
            categoryId: $category->id,
            title: 'Berita Terjadwal',
            slug: 'berita-terjadwal',
            status: 'published',
            publishedAt: now()->addDay(),
        );

        $this->get(route('news.show', [
            'slug' => $news->slug,
        ]))
            ->assertNotFound();
    }

    public function test_unknown_or_deleted_news_returns_not_found(): void
    {
        $category = $this->createCategory();

        $news = $this->createNews(
            categoryId: $category->id,
            title: 'Berita Dihapus',
            slug: 'berita-dihapus',
            status: 'published',
            publishedAt: now()->subDay(),
        );

        $news->delete();

        $this->get(route('news.show', [
            'slug' => $news->slug,
        ]))
            ->assertNotFound();

        $this->get(route('news.show', [
            'slug' => 'berita-tidak-tersedia',
        ]))
            ->assertNotFound();
    }

    private function createCategory(): NewsCategory
    {
        $category = new NewsCategory();

        $category->forceFill([
            'name' => 'Kegiatan Sekolah',
            'slug' => 'kegiatan-sekolah',
        ])->save();

        return $category;
    }

    private function createNews(
        int $categoryId,
        string $title,
        string $slug,
        string $status,
        mixed $publishedAt,
    ): News {
        return News::query()->create([
            'category_id' => $categoryId,
            'author_id' => null,
            'title' => $title,
            'slug' => $slug,
            'excerpt' => "Ringkasan {$title}.",
            'content' => "<p>Isi {$title}.</p>",
            'thumbnail' => "news/{$slug}.webp",
            'status' => $status,
            'view_count' => 0,
            'published_at' => $publishedAt,
        ]);
    }
}