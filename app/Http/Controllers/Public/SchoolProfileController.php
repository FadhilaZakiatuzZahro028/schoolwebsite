<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Models\StaffMember;
use Illuminate\Contracts\View\View;

class SchoolProfileController extends Controller
{
    public function profile(): View
    {
        $schoolProfile = SchoolProfile::query()
            ->first([
                'id',
                'school_name',
                'tagline',
                'vision',
                'mission',
                'principal_name',
                'principal_message',
                'logo',
                'address',
                'phone',
                'email',
            ]);

        $principalPhoto = null;

        if (
            $schoolProfile !== null
            && filled($schoolProfile->principal_name)
        ) {
            $principalPhoto = StaffMember::query()
                ->active()
                ->where(
                    'name',
                    $schoolProfile->principal_name,
                )
                ->value('photo');
        }

        return view(
            'public.profile.index',
            compact(
                'principalPhoto',
                'schoolProfile',
            ),
        );
    }

    public function history(): View
    {
        $schoolProfile = SchoolProfile::query()
            ->first([
                'id',
                'school_name',
                'tagline',
                'history',
            ]);

        return view(
            'public.history.index',
            compact('schoolProfile'),
        );
    }
}