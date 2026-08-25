<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use Illuminate\Contracts\View\View;

class ExtracurricularController extends Controller
{
    public function index(): View
    {
        $extracurriculars = Extracurricular::query()
            ->orderBy('name')
            ->paginate(9, [
                'id',
                'name',
                'slug',
                'description',
                'coach_name',
                'schedule',
                'image',
            ]);

        return view(
            'public.extracurriculars.index',
            compact('extracurriculars'),
        );
    }

    public function show(string $slug): View
{
    $extracurricular = Extracurricular::query()
        ->with([
            'images' => fn ($query) => $query
                ->orderBy('sort_order')
                ->limit(2),
        ])
        ->where('slug', $slug)
        ->firstOrFail([
            'id',
            'name',
            'slug',
            'description',
            'coach_name',
            'schedule',
            'image',
        ]);

    return view(
        'public.extracurriculars.show',
        compact('extracurricular'),
    );
}
}