<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StaffMember;
use Illuminate\Contracts\View\View;

class StaffController extends Controller
{
    public function teachers(): View
    {
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

        return view(
            'public.staff.teachers',
            compact('teachers'),
        );
    }

    public function employees(): View
    {
        $employees = StaffMember::query()
            ->with('educations')
            ->active()
            ->employees()
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

        return view(
            'public.staff.employees',
            compact('employees'),
        );
    }
}