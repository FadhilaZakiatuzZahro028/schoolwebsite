<?php

namespace App\Http\Controllers\Public;

use App\Models\Gallery;
use App\Models\Facility;
use App\Models\News;
use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Extracurricular;
use App\Models\HeroBanner;
use App\Models\SchoolProfile;
use App\Models\StaffMember;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

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

        $schoolProfile = SchoolProfile::query()
            ->first([
                'id',
                'school_name',
                'tagline',
                'principal_name',
                'principal_message',
            ]);

        $principalPhoto = null;
        $principalMessage = null;

        if ($schoolProfile !== null) {
            $principalMessage = Str::limit(
                trim(strip_tags(
                    (string) $schoolProfile->principal_message,
                )),
                360,
            );

            if (filled($schoolProfile->principal_name)) {
                $principalPhoto = StaffMember::query()
                    ->active()
                    ->where(
                        'name',
                        $schoolProfile->principal_name,
                    )
                    ->value('photo');
            }
        }

        $hasPrincipalSection = $schoolProfile !== null
            && filled($schoolProfile->principal_name)
            && filled($principalMessage);

            $teachers = StaffMember::query()
    ->with('educations')
    ->active()
    ->teachers()
    ->ordered()
    ->get([
        'id',
        'name',
        'staff_type',
        'photo',
        'position',
        'subject',
        'department',
    ]);

            $latestNews = News::query()
    ->published()
    ->with('category:id,name')
    ->latest('published_at')
    ->limit(3)
    ->get([
        'id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'thumbnail',
        'published_at',
    ]);

    $latestAchievements = Achievement::query()
    ->orderByDesc('year')
    ->orderByDesc('id')
    ->limit(3)
    ->get([
        'id',
        'title',
        'slug',
        'description',
        'level',
        'year',
        'image',
    ]);

    $featuredExtracurriculars = Extracurricular::query()
    ->orderBy('name')
    ->limit(3)
    ->get([
        'id',
        'name',
        'slug',
        'description',
        'coach_name',
        'schedule',
        'image',
    ]);

    $featuredFacilities = Facility::query()
    ->orderBy('name')
    ->limit(3)
    ->get([
        'id',
        'name',
        'slug',
        'description',
        'image',
    ]);

    $latestGalleryItems = Gallery::query()
    ->latest()
    ->limit(4)
    ->get([
        'id',
        'title',
        'description',
        'image',
        'created_at',
    ]);

   return view('public.home', compact(
    'featuredExtracurriculars',
    'featuredFacilities',
    'hasPrincipalSection',
    'heroBanners',
    'latestAchievements',
    'latestGalleryItems',
    'latestNews',
    'principalMessage',
    'principalPhoto',
    'schoolProfile',
    'teachers',
));


    }
}