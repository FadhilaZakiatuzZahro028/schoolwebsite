<?php

namespace Tests\Feature\Public;

use App\Models\Curriculum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurriculumPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_curriculum_page_only_displays_published_data(): void
    {
        $published = $this->createCurriculum([
            'title' => 'Kurikulum Merdeka',
            'is_published' => true,
        ]);

        $unpublished = $this->createCurriculum([
            'title' => 'Kurikulum Belum Terbit',
            'is_published' => false,
        ]);

        $this->get(route('curriculums.index'))
            ->assertSuccessful()
            ->assertSee('Kurikulum')
            ->assertSee($published->title)
            ->assertDontSee($unpublished->title);
    }

    public function test_curriculum_page_orders_data_by_sort_order_and_title_within_active_year(): void
{
    $first = $this->createCurriculum([
        'title' => 'Kurikulum A',
        'academic_year' => '2026/2027',
        'sort_order' => 1,
    ]);

    $second = $this->createCurriculum([
        'title' => 'Kurikulum B',
        'academic_year' => '2026/2027',
        'sort_order' => 1,
    ]);

    $hidden = $this->createCurriculum([
        'title' => 'Kurikulum C',
        'academic_year' => '2025/2026',
        'sort_order' => 2,
    ]);

    $this->get(route('curriculums.index'))
        ->assertSuccessful()
        ->assertSeeInOrder([
            $first->title,
            $second->title,
        ])
        ->assertDontSee($hidden->title);
}

    public function test_curriculum_page_displays_available_information(): void
    {
        $curriculum = $this->createCurriculum([
            'title' => 'Kurikulum Sekolah',
            'academic_year' => '2026/2027',
            'description' => 'Deskripsi kurikulum sekolah.',
        ]);

        $this->get(route('curriculums.index'))
            ->assertSuccessful()
            ->assertSee($curriculum->title)
            ->assertSee($curriculum->academic_year)
            ->assertSee($curriculum->description);
    }

    public function test_curriculum_page_displays_pdf_download_when_available(): void
    {
        $curriculum = $this->createCurriculum([
            'pdf_file' => 'curriculums/kurikulum.pdf',
        ]);

        $this->get(route('curriculums.index'))
            ->assertSuccessful()
            ->assertSee('Unduh PDF')
            ->assertSee(
                '/storage/' . $curriculum->pdf_file,
                false,
            )
            ->assertDontSee('Unduh Gambar');
    }

    public function test_curriculum_page_displays_image_download_when_available(): void
    {
        $curriculum = $this->createCurriculum([
            'image_file' => 'curriculums/materi.png',
            'preview_image' => 'curriculums/materi.webp',
        ]);

        $this->get(route('curriculums.index'))
            ->assertSuccessful()
            ->assertSee('Unduh Gambar')
            ->assertSee(
                '/storage/' . $curriculum->image_file,
                false,
            )
            ->assertSee(
                '/storage/' . $curriculum->preview_image,
                false,
            )
            ->assertDontSee('Unduh PDF');
    }

    public function test_curriculum_page_hides_download_actions_when_files_are_unavailable(): void
    {
        $this->createCurriculum([
            'pdf_file' => null,
            'image_file' => null,
            'preview_image' => null,
        ]);

        $this->get(route('curriculums.index'))
            ->assertSuccessful()
            ->assertDontSee('Unduh PDF')
            ->assertDontSee('Unduh Gambar');
    }

    public function test_curriculum_page_displays_empty_state(): void
    {
        $this->get(route('curriculums.index'))
            ->assertSuccessful()
            ->assertSee('Kurikulum Belum Tersedia')
            ->assertSee(
                'Informasi kurikulum akan ditampilkan setelah',
            )
            ->assertSee(
                'dipublikasikan melalui panel admin.',
            );
    }

    private function createCurriculum(array $attributes = []): Curriculum
    {
        return Curriculum::query()->create(array_merge([
            'title' => 'Kurikulum Pengujian',
            'academic_year' => '2026/2027',
            'description' => null,
            'pdf_file' => null,
            'image_file' => null,
            'preview_image' => null,
            'is_published' => true,
            'sort_order' => 0,
        ], $attributes));
    }
}
