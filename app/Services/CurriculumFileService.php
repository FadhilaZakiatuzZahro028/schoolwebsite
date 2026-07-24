<?php

namespace App\Services;

use App\Models\Curriculum;
use Illuminate\Support\Facades\Storage;

class CurriculumFileService
{
    public function deleteFiles(Curriculum $curriculum): void
    {
        $paths = array_values(array_filter([
            $curriculum->pdf_file,
            $curriculum->image_file,
            $curriculum->preview_image,
        ], static fn ($path): bool => is_string($path) && $path !== ''));

        if ($paths === []) {
            return;
        }

        Storage::disk('public')->delete($paths);
    }
}
