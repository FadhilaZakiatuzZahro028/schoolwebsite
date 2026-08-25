<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FeaturedProgram;
use App\Models\FeaturedProgramSetting;
use Illuminate\Contracts\View\View;

class FeaturedProgramController extends Controller
{
    public function index(): View
    {
        $setting = FeaturedProgramSetting::query()
            ->first([
                'id',
                'introduction',
                'collaboration_text',
            ]);

        $featuredPrograms = FeaturedProgram::query()
    ->active()
    ->ordered()
    ->with([
        'images:id,featured_program_id,image,alt_text,sort_order',
    ])
    ->get([
    'id',
    'name',
    'slug',
    'summary',
    'description',
    'image',
    'is_active',
    'sort_order',
]);

$heroImages = $featuredPrograms
    ->flatMap(function ($program) {
        return $program->images
            ->pluck('image');
    })
    ->take(3);
    
        return view(
    'public.featured-programs.index',
    compact(
        'setting',
        'featuredPrograms',
        'heroImages',
    ),
);
    }

    public function show(FeaturedProgram $featuredProgram): View
{
    abort_unless(
        $featuredProgram->is_active,
        404,
    );

    $featuredProgram->load([
        'images:id,featured_program_id,image,alt_text,sort_order',
    ]);

    return view(
        'public.featured-programs.show',
        compact('featuredProgram'),
    );
}
}