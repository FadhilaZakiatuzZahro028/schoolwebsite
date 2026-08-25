<?php

namespace Tests\Feature\Public;

use App\Models\SpmbSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpmbPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_spmb_page_displays_available_description(): void
{
    $spmbSetting = $this->createSpmbSetting([
        'description' => "Pendaftaran dibuka mulai Juli 2026.\nSilakan menyiapkan dokumen.",
    ]);

    $this->get(route('spmb.index'))
        ->assertSuccessful()
        ->assertSee('Informasi Pendaftaran')
        ->assertSee('Sistem Penerimaan')
        ->assertSee('Murid Baru')
        ->assertSee('Pendaftaran dibuka mulai Juli 2026.')
        ->assertSee('Silakan menyiapkan dokumen.');
}

    public function test_spmb_page_displays_information_file_when_available(): void
{
    $spmbSetting = $this->createSpmbSetting([
        'information_file' => 'spmb/informasi-spmb.pdf',
        'information_preview' => null,
    ]);

    $this->get(route('spmb.index'))
        ->assertSuccessful()
        ->assertSee('File Informasi SPMB')
        ->assertSee('Unduh File Informasi')
        ->assertSee(
            '/storage/' . $spmbSetting->information_file,
            false,
        )
        ->assertDontSee('Unduh Brosur');
}

    public function test_spmb_page_displays_brochure_preview_and_original_download(): void
    {
        $spmbSetting = $this->createSpmbSetting([
            'brochure_file' => 'spmb/brosur-spmb.png',
            'brochure_preview' => 'spmb/brosur-spmb.webp',
        ]);

        $this->get(route('spmb.index'))
            ->assertSuccessful()
            ->assertSee('Brosur SPMB')
            ->assertSee('Unduh Brosur')
            ->assertSee(
                '/storage/' . $spmbSetting->brochure_file,
                false,
            )
            ->assertSee(
                '/storage/' . $spmbSetting->brochure_preview,
                false,
            )
            ->assertDontSee('Unduh File Informasi');
    }

    public function test_spmb_page_displays_both_available_documents(): void
    {
        $spmbSetting = $this->createSpmbSetting([
            'information_file' => 'spmb/informasi.pdf',
            'information_preview' => null,
            'brochure_file' => 'spmb/brosur.jpg',
            'brochure_preview' => 'spmb/brosur.webp',
        ]);

        $this->get(route('spmb.index'))
            ->assertSuccessful()
            ->assertSee('File Informasi SPMB')
            ->assertSee('Brosur SPMB')
            ->assertSee('Unduh File Informasi')
            ->assertSee('Unduh Brosur')
            ->assertSee(
                '/storage/' . $spmbSetting->information_file,
                false,
            )
            ->assertSee(
                '/storage/' . $spmbSetting->brochure_file,
                false,
            );
    }

    public function test_spmb_page_hides_document_section_when_files_are_unavailable(): void
    {
        $this->createSpmbSetting([
            'description' => 'Informasi pendaftaran tersedia.',
            'information_file' => null,
            'information_preview' => null,
            'brochure_file' => null,
            'brochure_preview' => null,
        ]);

        $this->get(route('spmb.index'))
            ->assertSuccessful()
            ->assertSee('Informasi pendaftaran tersedia.')
            ->assertDontSee('File Informasi SPMB')
            ->assertDontSee('Unduh File Informasi')
            ->assertDontSee('Unduh Brosur');
    }

    public function test_spmb_page_displays_description_fallback_when_empty(): void
    {
        $this->createSpmbSetting([
            'description' => null,
        ]);

        $this->get(route('spmb.index'))
            ->assertSuccessful()
            ->assertSee('Keterangan SPMB belum tersedia.');
    }

    public function test_spmb_page_displays_empty_state_when_setting_is_unavailable(): void
{
    $this->get(route('spmb.index'))
        ->assertSuccessful()
        ->assertSee('Informasi SPMB Belum Tersedia')
        ->assertSee(
            'Informasi penerimaan murid baru akan',
        )
        ->assertSee(
            'ditampilkan setelah dikonfigurasi',
        )
        ->assertSee(
            'melalui panel admin.',
        );
}
    private function createSpmbSetting(
        array $attributes = [],
    ): SpmbSetting {
        return SpmbSetting::query()->create(array_merge([
            'description' => 'Informasi SPMB untuk pengujian.',
            'information_file' => null,
            'information_preview' => null,
            'brochure_file' => null,
            'brochure_preview' => null,
        ], $attributes));
    }
}