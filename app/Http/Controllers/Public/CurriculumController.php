<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Illuminate\Contracts\View\View;

class CurriculumController extends Controller
{
    public function index(): View
{
    $availableYears = Curriculum::query()
        ->where('is_published', true)
        ->select('academic_year')
        ->distinct()
        ->orderByDesc('academic_year')
        ->pluck('academic_year');

    $requestedYear = request()->string('year')->toString();

    $activeYear = $availableYears->contains($requestedYear)
        ? $requestedYear
        : $availableYears->first();

    $curriculums = Curriculum::query()
        ->where('is_published', true)
        ->when(
            $activeYear,
            fn ($query) => $query->where(
                'academic_year',
                $activeYear,
            ),
        )
        ->orderBy('sort_order')
        ->orderBy('title')
        ->get([
            'id',
            'title',
            'academic_year',
            'description',
            'pdf_file',
            'image_file',
            'preview_image',
            'sort_order',
        ]);

    return view(
        'public.curriculums.index',
        compact(
            'curriculums',
            'availableYears',
            'activeYear',
        ),
    );
}
}
