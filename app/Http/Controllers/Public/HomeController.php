<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $heroBanners = HeroBanner::query()
            ->active()
            ->ordered()
            ->get([
                'id',
                'title',
                'subtitle',
                'image',
                'button_text',
                'button_url',
                'sort_order',
            ]);

        return view('public.home', compact('heroBanners'));
    }
}
