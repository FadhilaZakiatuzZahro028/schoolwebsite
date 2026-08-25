<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SpmbSetting;
use Illuminate\Contracts\View\View;

class SpmbController extends Controller
{
    public function index(): View
    {
        $spmbSetting = SpmbSetting::query()->first([
            'id',
            'description',
            'information_file',
            'information_preview',
            'brochure_file',
            'brochure_preview',
        ]);

        return view(
            'public.spmb.index',
            compact('spmbSetting'),
        );
    }
}
