<?php

namespace Tests\Feature\Filament\NewsCategories;

use App\Filament\Resources\NewsCategories\NewsCategoryResource;
use App\Filament\Resources\NewsCategories\Pages\CreateNewsCategory;
use App\Filament\Resources\NewsCategories\Pages\EditNewsCategory;
use App\Filament\Resources\NewsCategories\Pages\ListNewsCategories;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NewsCategoryIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('admin');

        $this->actingAs(
            User::factory()->create([
                'role' => 'super_admin',
            ])
        );
    }

    public function test_admin_can_create_news_category(): void
    {
        $this->actingAs(
            User::factory()->create([
                'role' => 'admin',
            ])
        );

        Livewire::test(CreateNewsCategory::class)
            ->fillForm([
                'name' => 'Berita Sekolah',
                'slug' => null,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('news_categories', [
            'name' => 'Berita Sekolah',
            'slug' => 'berita-sekolah',
        ]);
    }

    public function test_super_admin_can_create_news_category(): void
    {
        Livewire::test(CreateNewsCategory::class)
            ->fillForm([
                'name' => 'Pengumuman',
                'slug' => null,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('news_categories', [
            'name' => 'Pengumuman',
            'slug' => 'pengumuman',
        ]);
    }

    public function test_slug_is_generated_automatically_from_name(): void
    {
        Livewire::test(CreateNewsCategory::class)
            ->fillForm([
                'name' => 'Kegiatan Akademik Sekolah',
                'slug' => null,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('news_categories', [
            'name' => 'Kegiatan Akademik Sekolah',
            'slug' => 'kegiatan-akademik-sekolah',
        ]);
    }

    public function test_duplicate_automatic_slug_gets_numeric_suffix(): void
    {
        $this->createCategory([
            'name' => 'Berita Sekolah',
            'slug' => 'berita-sekolah',
        ]);

        Livewire::test(CreateNewsCategory::class)
            ->fillForm([
                'name' => 'Berita Sekolah',
                'slug' => null,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('news_categories', [
            'name' => 'Berita Sekolah',
            'slug' => 'berita-sekolah-2',
        ]);
    }

    public function test_custom_slug_is_normalized(): void
    {
        Livewire::test(CreateNewsCategory::class)
            ->fillForm([
                'name' => 'Informasi Sekolah',
                'slug' => 'Info Sekolah Tahun 2026',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('news_categories', [
            'name' => 'Informasi Sekolah',
            'slug' => 'info-sekolah-tahun-2026',
        ]);
    }

    public function test_duplicate_manual_slug_is_rejected(): void
    {
        $this->createCategory([
            'name' => 'Berita Sekolah',
            'slug' => 'berita-sekolah',
        ]);

        Livewire::test(CreateNewsCategory::class)
            ->fillForm([
                'name' => 'Kategori Lain',
                'slug' => 'berita-sekolah',
            ])
            ->call('create')
            ->assertHasFormErrors([
                'slug' => 'unique',
            ]);

        $this->assertDatabaseCount('news_categories', 1);
    }

    public function test_category_name_is_required(): void
    {
        Livewire::test(CreateNewsCategory::class)
            ->fillForm([
                'name' => null,
                'slug' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'name' => 'required',
            ]);

        $this->assertDatabaseCount('news_categories', 0);
    }

    public function test_category_slug_can_be_edited(): void
    {
        $category = $this->createCategory([
            'name' => 'Berita Lama',
            'slug' => 'berita-lama',
        ]);

        Livewire::test(EditNewsCategory::class, [
            'record' => $category->getRouteKey(),
        ])
            ->fillForm([
                'name' => 'Berita Terbaru',
                'slug' => 'Informasi Terbaru Sekolah',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $category->refresh();

        $this->assertSame('Berita Terbaru', $category->name);
        $this->assertSame(
            'informasi-terbaru-sekolah',
            $category->slug,
        );
    }

    public function test_edit_with_empty_slug_regenerates_slug_from_name(): void
    {
        $category = $this->createCategory([
            'name' => 'Kategori Lama',
            'slug' => 'kategori-lama',
        ]);

        Livewire::test(EditNewsCategory::class, [
            'record' => $category->getRouteKey(),
        ])
            ->fillForm([
                'name' => 'Kategori Baru',
                'slug' => null,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame(
            'kategori-baru',
            $category->fresh()->slug,
        );
    }

    public function test_category_used_by_news_cannot_be_deleted(): void
    {
        $category = $this->createCategory();

        $news = $this->createNews($category);

        $this->assertTrue(
            $category->news()->whereKey($news->getKey())->exists(),
        );

        $this->assertFalse(
            NewsCategoryResource::canDelete($category),
        );

        $this->assertDatabaseHas('news_categories', [
            'id' => $category->getKey(),
        ]);
    }

    public function test_empty_category_can_be_deleted_from_edit_page(): void
    {
        $category = $this->createCategory();

        $this->assertTrue(
            NewsCategoryResource::canDelete($category),
        );

        Livewire::test(EditNewsCategory::class, [
            'record' => $category->getRouteKey(),
        ])
            ->callAction('delete');

        $this->assertDatabaseMissing('news_categories', [
            'id' => $category->getKey(),
        ]);
    }

    public function test_empty_category_can_be_deleted_from_list_page(): void
    {
        $category = $this->createCategory();

        Livewire::test(ListNewsCategories::class)
            ->callTableAction(
                'delete',
                $category,
            );

        $this->assertDatabaseMissing('news_categories', [
            'id' => $category->getKey(),
        ]);
    }

    public function test_admin_and_super_admin_can_manage_news_categories(): void
    {
        $category = $this->createCategory();

        foreach (['admin', 'super_admin'] as $role) {
            $this->actingAs(
                User::factory()->create([
                    'role' => $role,
                ])
            );

            $this->assertTrue(
                NewsCategoryResource::canViewAny(),
            );

            $this->assertTrue(
                NewsCategoryResource::canCreate(),
            );

            $this->assertTrue(
                NewsCategoryResource::canEdit($category),
            );

            $this->assertTrue(
                NewsCategoryResource::canDelete($category),
            );

            $this->assertFalse(
                NewsCategoryResource::canDeleteAny(),
            );
        }
    }

    private function createCategory(
        array $attributes = [],
    ): NewsCategory {
        return NewsCategory::query()->create(
            array_merge([
                'name' => fake()->unique()->words(2, true),
                'slug' => fake()->unique()->slug(),
            ], $attributes)
        );
    }

    private function createNews(
        NewsCategory $category,
    ): News {
        return News::query()->create([
            'category_id' => $category->getKey(),
            'author_id' => auth()->id(),
            'title' => 'Berita Pengujian Kategori',
            'slug' => 'berita-pengujian-kategori',
            'excerpt' => 'Ringkasan berita untuk pengujian kategori.',
            'content' => '<p>Isi berita untuk pengujian kategori.</p>',
            'thumbnail' => 'news/test-category.webp',
            'status' => 'draft',
            'meta_title' => null,
            'meta_description' => null,
            'view_count' => 0,
            'published_at' => null,
        ]);
    }
}
