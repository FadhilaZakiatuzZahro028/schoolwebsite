<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Contracts\View\View;

class AchievementController extends Controller
{
    public function index(): View
    {
        $achievements = Achievement::query()
            ->orderByDesc('year')
            ->orderByDesc('id')
            ->paginate(9, [
                'id',
                'title',
                'slug',
                'description',
                'level',
                'year',
                'image',
            ]);

        return view(
            'public.achievements.index',
            compact('achievements'),
        );
    }

    public function show(string $slug): View
{
    $achievement = Achievement::query()
        ->where('slug', $slug)
        ->firstOrFail([
            'id',
            'title',
            'slug',
            'description',
            'level',
            'year',
            'image',
        ]);

    return view(
        'public.achievements.show',
        compact('achievement'),
    );
}
}