<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Contracts\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleryItems = Gallery::query()
            ->latest()
            ->paginate(12, [
                'id',
                'title',
                'description',
                'image',
                'created_at',
            ]);

        return view(
            'public.gallery.index',
            compact('galleryItems'),
        );
    }
}