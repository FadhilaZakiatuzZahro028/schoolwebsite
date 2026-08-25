<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Contracts\View\View;

class FacilityController extends Controller
{
    public function index(): View
    {
        $facilities = Facility::query()
            ->orderBy('name')
            ->paginate(12, [
                'id',
                'name',
                'slug',
                'description',
                'image',
            ]);

        return view(
            'public.facilities.index',
            compact('facilities'),
        );
    }

    public function show(string $slug): View
{
    $facility = Facility::query()
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
            'image',
        ]);

    $galleryImages = collect([
        [
            'image' => $facility->image,
            'alt' => $facility->name,
        ],
    ])->concat(
        $facility->images->map(
            fn ($image): array => [
                'image' => $image->image,
                'alt' => filled($image->alt_text)
                    ? trim($image->alt_text)
                    : 'Dokumentasi '.$facility->name,
            ],
        ),
    )->values();

    return view(
        'public.facilities.show',
        compact(
            'facility',
            'galleryImages',
        ),
    );
}
}