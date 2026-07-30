<?php

namespace App\Providers;

use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewInstance;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(
            'public.*',
            function (ViewInstance $view): void {
                $view->with([
                    'schoolProfile' => SchoolProfile::query()->first(),
                    'siteSetting' => SiteSetting::query()->first(),
                ]);
            },
        );
    }
}
