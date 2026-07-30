<?php

namespace Tests\Feature\Public;

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
}
