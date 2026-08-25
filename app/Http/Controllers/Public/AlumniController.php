<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AlumniHighlight;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class AlumniController extends Controller
{
    public function index(): View
    {
        $alumniHighlights = AlumniHighlight::query()
            ->active()
            ->ordered()
            ->limit(AlumniHighlight::MAX_ACTIVE)
            ->get([
                'id',
                'name',
                'graduation_year',
                'photo',
                'current_activity',
                'institution',
                'quote',
            ]);

        $alumniFormUrl = SiteSetting::query()
            ->value('alumni_form_url');

        return view(
            'public.alumni.index',
            compact(
                'alumniHighlights',
                'alumniFormUrl',
            ),
        );
    }
}