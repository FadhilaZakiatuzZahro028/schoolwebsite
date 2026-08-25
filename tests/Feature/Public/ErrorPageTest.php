<?php

namespace Tests\Feature\Public;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ErrorPageTest extends TestCase
{
    public function test_unknown_public_page_displays_custom_404_page(): void
    {
        config([
            'app.debug' => false,
        ]);

        $this->get('/halaman-yang-tidak-tersedia')
            ->assertNotFound()
            ->assertSee('Halaman Tidak Ditemukan')
            ->assertSee(
                'Halaman yang Anda cari tidak ditemukan atau telah dipindahkan.',
            )
            ->assertSee('Kembali ke Beranda')
            ->assertDontSee('Stack trace');
    }

    public function test_server_error_displays_custom_500_page(): void
    {
        config([
            'app.debug' => false,
        ]);

        Route::get(
            '/__pengujian-error-500',
            fn () => abort(500),
        );

        $this->get('/__pengujian-error-500')
            ->assertStatus(500)
            ->assertSee('Terjadi Kesalahan Sistem')
            ->assertSee(
                'Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.',
            )
            ->assertSee('Coba Lagi')
            ->assertSee('Kembali ke Beranda')
            ->assertDontSee('Stack trace');
    }
}