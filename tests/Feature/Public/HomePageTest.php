<?php

namespace Tests\Feature\Public;

use App\Models\Gallery;
use App\Models\Facility;
use App\Models\Extracurricular;
use App\Models\Achievement;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\HeroBanner;
use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_without_configured_school_data(): void
    {
        $this->get(route('home'))
            ->assertSuccessful()
            ->assertSee(config('app.name'))
            ->assertSee('Beranda')
            ->assertSee('Kontak');
    }

    public function test_home_page_displays_dynamic_school_data(): void
    {
        SchoolProfile::query()->create([
            'school_name' => 'Sekolah Pengujian',
            'tagline' => 'Tagline sekolah dari database.',
            'history' => 'Sejarah sekolah.',
            'vision' => 'Visi sekolah.',
            'mission' => 'Misi sekolah.',
            'principal_name' => 'Kepala Sekolah',
            'principal_message' => 'Sambutan kepala sekolah.',
            'address' => 'Jalan Pengujian Nomor 1',
            'phone' => '0355 123456',
            'email' => 'sekolah@example.com',
            'instagram' => 'https://instagram.com/sekolah',
            'facebook' => null,
            'youtube' => null,
        ]);

        SiteSetting::query()->create([
            'site_name' => 'Website Sekolah Pengujian',
            'site_description' => 'Deskripsi website dari database.',
            'default_meta_keywords' => 'sekolah, pendidikan',
            'copyright_text' => 'Hak cipta sekolah pengujian.',
            'is_maintenance' => false,
        ]);

        $this->get(route('home'))
            ->assertSuccessful()
            ->assertSee('Sekolah Pengujian')
            ->assertSee('Tagline sekolah dari database.')
            ->assertSee('Jalan Pengujian Nomor 1')
            ->assertSee('0355 123456')
            ->assertSee('sekolah@example.com')
            ->assertSee('Hak cipta sekolah pengujian.')
            ->assertSee('Deskripsi website dari database.', false);
    }

    public function test_home_page_displays_only_active_hero_banners(): void
    {
        HeroBanner::query()->create([
            'title' => 'Banner Tidak Aktif',
            'subtitle' => 'Banner ini tidak boleh tampil.',
            'image' => 'heroes/inactive-banner.webp',
            'button_text' => 'Jangan Tampilkan',
            'button_url' => '/tidak-aktif',
            'sort_order' => 1,
            'is_active' => false,
        ]);

        HeroBanner::query()->create([
            'title' => 'Banner Aktif Sekolah',
            'subtitle' => 'Informasi hero berasal dari database.',
            'image' => 'heroes/active-banner.webp',
            'button_text' => 'Lihat Profil',
            'button_url' => '/profil',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        $this->get(route('home'))
            ->assertSuccessful()
            ->assertSee('Banner Aktif Sekolah')
            ->assertSee('Informasi hero berasal dari database.')
            ->assertSee('Lihat Profil')
            ->assertDontSee('Banner Tidak Aktif')
            ->assertDontSee('Jangan Tampilkan');
    }

    public function test_home_page_displays_three_latest_published_news(): void
{
    $category = new NewsCategory();

    $category->forceFill([
        'name' => 'Kegiatan Sekolah',
        'slug' => 'kegiatan-sekolah',
    ])->save();

    foreach ([
        ['Berita Pertama', 'berita-pertama', now()->subDays(4)],
        ['Berita Kedua', 'berita-kedua', now()->subDays(3)],
        ['Berita Ketiga', 'berita-ketiga', now()->subDays(2)],
        ['Berita Keempat', 'berita-keempat', now()->subDay()],
    ] as [$title, $slug, $publishedAt]) {
        News::query()->create([
            'category_id' => $category->id,
            'author_id' => null,
            'title' => $title,
            'slug' => $slug,
            'excerpt' => "Ringkasan {$title}.",
            'content' => "<p>Isi {$title}.</p>",
            'thumbnail' => "news/{$slug}.webp",
            'status' => 'published',
            'view_count' => 0,
            'published_at' => $publishedAt,
        ]);
    }

    News::query()->create([
        'category_id' => $category->id,
        'author_id' => null,
        'title' => 'Berita Draft',
        'slug' => 'berita-draft',
        'excerpt' => 'Berita ini belum diterbitkan.',
        'content' => '<p>Isi berita draft.</p>',
        'thumbnail' => 'news/berita-draft.webp',
        'status' => 'draft',
        'view_count' => 0,
        'published_at' => now()->subDay(),
    ]);

    News::query()->create([
        'category_id' => $category->id,
        'author_id' => null,
        'title' => 'Berita Masa Depan',
        'slug' => 'berita-masa-depan',
        'excerpt' => 'Berita ini belum waktunya tampil.',
        'content' => '<p>Isi berita masa depan.</p>',
        'thumbnail' => 'news/berita-masa-depan.webp',
        'status' => 'published',
        'view_count' => 0,
        'published_at' => now()->addDay(),
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Berita Terbaru')
        ->assertSeeInOrder([
            'Berita Keempat',
            'Berita Ketiga',
            'Berita Kedua',
        ])
        ->assertDontSee('Berita Pertama')
        ->assertDontSee('Berita Draft')
        ->assertDontSee('Berita Masa Depan');
}

public function test_home_page_displays_three_latest_achievements(): void
{
    foreach ([
        ['Prestasi Lama', 'prestasi-lama', 2022],
        ['Prestasi Kabupaten', 'prestasi-kabupaten', 2024],
        ['Prestasi Provinsi', 'prestasi-provinsi', 2025],
        ['Prestasi Nasional', 'prestasi-nasional', 2026],
    ] as [$title, $slug, $year]) {
        Achievement::query()->create([
            'title' => $title,
            'slug' => $slug,
            'description' => "Deskripsi {$title}.",
            'level' => 'Nasional',
            'year' => $year,
            'image' => "achievements/{$slug}.webp",
        ]);
    }

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Prestasi Terkini')
        ->assertSeeInOrder([
            'Prestasi Nasional',
            'Prestasi Provinsi',
            'Prestasi Kabupaten',
        ])
        ->assertDontSee('Prestasi Lama');
}

public function test_home_page_displays_three_featured_extracurriculars(): void
{
    foreach ([
        ['Basket', 'basket'],
        ['Futsal', 'futsal'],
        ['Paskibra', 'paskibra'],
        ['Pramuka', 'pramuka'],
    ] as [$name, $slug]) {
        Extracurricular::query()->create([
            'name' => $name,
            'slug' => $slug,
            'description' => "Deskripsi kegiatan {$name}.",
            'coach_name' => "Pembina {$name}",
            'schedule' => 'Jumat, 15.00 WIB',
            'image' => "extracurriculars/{$slug}.webp",
        ]);
    }

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Ekstrakurikuler Pilihan')
        ->assertSeeInOrder([
            'Basket',
            'Futsal',
            'Paskibra',
        ])
        ->assertDontSee('Pramuka');
}

public function test_home_page_displays_three_featured_facilities(): void
{
    foreach ([
        ['Aula Sekolah', 'aula-sekolah'],
        ['Laboratorium Komputer', 'laboratorium-komputer'],
        ['Perpustakaan', 'perpustakaan'],
        ['Ruang Kelas', 'ruang-kelas'],
    ] as [$name, $slug]) {
        Facility::query()->create([
            'name' => $name,
            'slug' => $slug,
            'description' => "Deskripsi fasilitas {$name}.",
            'image' => "facilities/{$slug}.webp",
        ]);
    }

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Fasilitas Sekolah')
        ->assertSeeInOrder([
            'Aula Sekolah',
            'Laboratorium Komputer',
            'Perpustakaan',
        ])
        ->assertDontSee('Ruang Kelas');
}

public function test_home_page_displays_four_latest_gallery_items(): void
{
    $items = [
        ['Galeri Lama', 'galeri-lama', 10],
        ['Kegiatan Senin', 'kegiatan-senin', 4],
        ['Kegiatan Selasa', 'kegiatan-selasa', 3],
        ['Kegiatan Rabu', 'kegiatan-rabu', 2],
        ['Kegiatan Kamis', 'kegiatan-kamis', 1],
    ];

    foreach ($items as [$title, $imageName, $daysAgo]) {
        $galleryItem = Gallery::query()->create([
            'title' => $title,
            'description' => "Dokumentasi {$title}.",
            'image' => "galleries/{$imageName}.webp",
        ]);

        $timestamp = now()->subDays($daysAgo);

        $galleryItem->forceFill([
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ])->saveQuietly();
    }

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Galeri Terbaru')
        ->assertSeeInOrder([
            'Kegiatan Kamis',
            'Kegiatan Rabu',
            'Kegiatan Selasa',
            'Kegiatan Senin',
        ])
        ->assertDontSee('Galeri Lama')
        ->assertSee(route('gallery.index'), false);
}
}
