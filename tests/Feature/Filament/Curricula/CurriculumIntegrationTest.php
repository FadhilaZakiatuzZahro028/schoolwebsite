<?php

namespace Tests\Feature\Filament\Curricula;

use App\Filament\Resources\Curricula\Pages\CreateCurriculum;
use App\Filament\Resources\Curricula\Pages\EditCurriculum;
use App\Filament\Resources\Curricula\Pages\ListCurricula;
use App\Models\Curriculum;
use App\Models\User;
use App\Services\ImageUploadService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class CurriculumIntegrationTest extends TestCase
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

    public function test_it_creates_curriculum_with_original_files_and_webp_preview(): void
    {
        $pdfUpload = UploadedFile::fake()->create(
            'kurikulum-2026.pdf',
            1024,
            'application/pdf',
        );

        $imageUpload = UploadedFile::fake()
            ->image('materi-kurikulum.png', 480, 320)
            ->size(1024);

        Livewire::test(CreateCurriculum::class)
            ->fillForm([
                'title' => 'Kurikulum Tahun Ajaran 2026/2027',
                'academic_year' => '2026/2027',
                'description' => 'Informasi kurikulum sekolah.',
                'pdf_file' => $pdfUpload,
                'image_file' => $imageUpload,
                'is_published' => true,
                'sort_order' => 1,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $curriculum = Curriculum::query()->firstOrFail();

        $this->assertSame(
            'Kurikulum Tahun Ajaran 2026/2027',
            $curriculum->title,
        );

        $this->assertSame(
            '2026/2027',
            $curriculum->academic_year,
        );

        $this->assertNotNull($curriculum->pdf_file);
        $this->assertNotNull($curriculum->image_file);
        $this->assertNotNull($curriculum->preview_image);

        $this->assertStringStartsWith(
            'curriculums/',
            $curriculum->pdf_file,
        );

        $this->assertStringEndsWith(
            '.pdf',
            $curriculum->pdf_file,
        );

        $this->assertStringStartsWith(
            'curriculums/',
            $curriculum->image_file,
        );

        $this->assertStringEndsWith(
            '.png',
            $curriculum->image_file,
        );

        $this->assertStringStartsWith(
            'curriculums/',
            $curriculum->preview_image,
        );

        $this->assertStringEndsWith(
            '.webp',
            $curriculum->preview_image,
        );

        Storage::disk('public')->assertExists(
            $curriculum->pdf_file,
        );

        Storage::disk('public')->assertExists(
            $curriculum->image_file,
        );

        Storage::disk('public')->assertExists(
            $curriculum->preview_image,
        );

        $previewContents = Storage::disk('public')->get(
            $curriculum->preview_image,
        );

        $previewInformation = getimagesizefromstring(
            $previewContents,
        );

        $this->assertIsArray($previewInformation);

        $this->assertSame(
            'image/webp',
            $previewInformation['mime'],
        );

        $this->assertLessThanOrEqual(
            1600,
            $previewInformation[0],
        );
    }

    public function test_it_replaces_curriculum_image_and_deletes_old_original_and_preview(): void
    {
        $oldPaths = app(ImageUploadService::class)
            ->storeOriginalWithWebpPreview(
                file: UploadedFile::fake()
                    ->image('old-material.png', 480, 320)
                    ->size(1024),
                directory: 'curriculums',
                maxWidth: 1600,
                quality: 80,
            );

        $curriculum = Curriculum::query()->create([
            'title' => 'Kurikulum Lama',
            'academic_year' => '2025/2026',
            'description' => 'Deskripsi lama.',
            'image_file' => $oldPaths['original'],
            'preview_image' => $oldPaths['preview'],
            'is_published' => true,
            'sort_order' => 1,
        ]);

        $newImageUpload = UploadedFile::fake()
            ->image('new-material.jpg', 480, 320)
            ->size(1024);

        Livewire::test(EditCurriculum::class, [
            'record' => $curriculum->getRouteKey(),
        ])
            ->set('data.image_file', [])
            ->set('data.image_file', [$newImageUpload])
            ->call('save')
            ->assertHasNoFormErrors();

        $curriculum->refresh();

        $this->assertNotSame(
            $oldPaths['original'],
            $curriculum->image_file,
        );

        $this->assertNotSame(
            $oldPaths['preview'],
            $curriculum->preview_image,
        );

        Storage::disk('public')->assertMissing(
            $oldPaths['original'],
        );

        Storage::disk('public')->assertMissing(
            $oldPaths['preview'],
        );

        Storage::disk('public')->assertExists(
            $curriculum->image_file,
        );

        Storage::disk('public')->assertExists(
            $curriculum->preview_image,
        );

        $this->assertStringEndsWith(
            '.jpg',
            $curriculum->image_file,
        );

        $this->assertStringEndsWith(
            '.webp',
            $curriculum->preview_image,
        );
    }

    public function test_it_replaces_curriculum_pdf_and_deletes_old_file(): void
    {
        $oldPdfPath = 'curriculums/old-curriculum.pdf';

        Storage::disk('public')->put(
            $oldPdfPath,
            'old pdf content',
        );

        $curriculum = Curriculum::query()->create([
            'title' => 'Kurikulum Lama',
            'academic_year' => '2025/2026',
            'description' => 'Deskripsi lama.',
            'pdf_file' => $oldPdfPath,
            'is_published' => true,
            'sort_order' => 1,
        ]);

        $newPdfUpload = UploadedFile::fake()->create(
            'new-curriculum.pdf',
            1024,
            'application/pdf',
        );

        Livewire::test(EditCurriculum::class, [
            'record' => $curriculum->getRouteKey(),
        ])
            ->set('data.pdf_file', [])
            ->set('data.pdf_file', [$newPdfUpload])
            ->call('save')
            ->assertHasNoFormErrors();

        $curriculum->refresh();

        $this->assertNotNull($curriculum->pdf_file);

        $this->assertNotSame(
            $oldPdfPath,
            $curriculum->pdf_file,
        );

        $this->assertStringStartsWith(
            'curriculums/',
            $curriculum->pdf_file,
        );

        $this->assertStringEndsWith(
            '.pdf',
            $curriculum->pdf_file,
        );

        Storage::disk('public')->assertMissing(
            $oldPdfPath,
        );

        Storage::disk('public')->assertExists(
            $curriculum->pdf_file,
        );
    }

    public function test_it_deletes_curriculum_and_all_related_files_from_edit_page(): void
    {
        $pdfPath = 'curriculums/curriculum-delete-test.pdf';

        Storage::disk('public')->put(
            $pdfPath,
            'pdf content',
        );

        $imagePaths = app(ImageUploadService::class)
            ->storeOriginalWithWebpPreview(
                file: UploadedFile::fake()
                    ->image('material-delete-test.png', 1200, 800)
                    ->size(1024),
                directory: 'curriculums',
                maxWidth: 1600,
                quality: 80,
            );

        $curriculum = Curriculum::query()->create([
            'title' => 'Kurikulum untuk Dihapus',
            'academic_year' => '2025/2026',
            'description' => 'Data untuk pengujian delete.',
            'pdf_file' => $pdfPath,
            'image_file' => $imagePaths['original'],
            'preview_image' => $imagePaths['preview'],
            'is_published' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(EditCurriculum::class, [
            'record' => $curriculum->getRouteKey(),
        ])
            ->callAction('delete');

        $this->assertDatabaseMissing('curriculums', [
            'id' => $curriculum->getKey(),
        ]);

        Storage::disk('public')->assertMissing(
            $pdfPath,
        );

        Storage::disk('public')->assertMissing(
            $imagePaths['original'],
        );

        Storage::disk('public')->assertMissing(
            $imagePaths['preview'],
        );
    }

    public function test_it_deletes_curriculum_and_all_related_files_from_list_page(): void
    {
        $pdfPath = 'curriculums/curriculum-list-delete-test.pdf';

        Storage::disk('public')->put(
            $pdfPath,
            'pdf content',
        );

        $imagePaths = app(ImageUploadService::class)
            ->storeOriginalWithWebpPreview(
                file: UploadedFile::fake()
                    ->image('material-list-delete-test.png', 480, 320)
                    ->size(1024),
                directory: 'curriculums',
                maxWidth: 1600,
                quality: 80,
            );

        $curriculum = Curriculum::query()->create([
            'title' => 'Kurikulum untuk Dihapus dari List',
            'academic_year' => '2025/2026',
            'description' => 'Data untuk pengujian delete dari tabel.',
            'pdf_file' => $pdfPath,
            'image_file' => $imagePaths['original'],
            'preview_image' => $imagePaths['preview'],
            'is_published' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(ListCurricula::class)
            ->callTableAction(
                'delete',
                $curriculum,
            );

        $this->assertDatabaseMissing('curriculums', [
            'id' => $curriculum->getKey(),
        ]);

        Storage::disk('public')->assertMissing(
            $pdfPath,
        );

        Storage::disk('public')->assertMissing(
            $imagePaths['original'],
        );

        Storage::disk('public')->assertMissing(
            $imagePaths['preview'],
        );
    }

    public function test_it_keeps_existing_files_when_no_new_files_are_uploaded(): void
    {
        $pdfPath = 'curriculums/existing-curriculum.pdf';

        Storage::disk('public')->put(
            $pdfPath,
            'existing pdf content',
        );

        $imagePaths = app(ImageUploadService::class)
            ->storeOriginalWithWebpPreview(
                file: UploadedFile::fake()
                    ->image('existing-material.png', 480, 320)
                    ->size(1024),
                directory: 'curriculums',
                maxWidth: 1600,
                quality: 80,
            );

        $curriculum = Curriculum::query()->create([
            'title' => 'Kurikulum Lama',
            'academic_year' => '2025/2026',
            'description' => 'Deskripsi lama.',
            'pdf_file' => $pdfPath,
            'image_file' => $imagePaths['original'],
            'preview_image' => $imagePaths['preview'],
            'is_published' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(EditCurriculum::class, [
            'record' => $curriculum->getRouteKey(),
        ])
            ->fillForm([
                'title' => 'Kurikulum Diperbarui',
                'academic_year' => '2025/2026',
                'description' => 'Deskripsi baru.',
                'is_published' => true,
                'sort_order' => 1,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $curriculum->refresh();

        $this->assertSame(
            $pdfPath,
            $curriculum->pdf_file,
        );

        $this->assertSame(
            $imagePaths['original'],
            $curriculum->image_file,
        );

        $this->assertSame(
            $imagePaths['preview'],
            $curriculum->preview_image,
        );

        Storage::disk('public')->assertExists(
            $pdfPath,
        );

        Storage::disk('public')->assertExists(
            $imagePaths['original'],
        );

        Storage::disk('public')->assertExists(
            $imagePaths['preview'],
        );
    }
}
