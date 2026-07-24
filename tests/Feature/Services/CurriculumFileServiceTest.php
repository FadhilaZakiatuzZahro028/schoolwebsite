<?php

namespace Tests\Feature\Services;

use App\Models\Curriculum;
use App\Services\CurriculumFileService;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CurriculumFileServiceTest extends TestCase
{
    public function test_it_deletes_all_curriculum_files(): void
    {
        Storage::fake('public');

        $curriculum = new Curriculum([
            'pdf_file' => 'curriculums/document.pdf',
            'image_file' => 'curriculums/material.png',
            'preview_image' => 'curriculums/material.webp',
        ]);

        Storage::disk('public')->put(
            $curriculum->pdf_file,
            'pdf-content',
        );

        Storage::disk('public')->put(
            $curriculum->image_file,
            'image-content',
        );

        Storage::disk('public')->put(
            $curriculum->preview_image,
            'preview-content',
        );

        Storage::disk('public')->assertExists($curriculum->pdf_file);
        Storage::disk('public')->assertExists($curriculum->image_file);
        Storage::disk('public')->assertExists($curriculum->preview_image);

        app(CurriculumFileService::class)->deleteFiles($curriculum);

        Storage::disk('public')->assertMissing($curriculum->pdf_file);
        Storage::disk('public')->assertMissing($curriculum->image_file);
        Storage::disk('public')->assertMissing($curriculum->preview_image);
    }
}
