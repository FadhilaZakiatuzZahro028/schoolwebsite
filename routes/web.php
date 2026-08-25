<?php

use App\Http\Controllers\Public\ChatbotController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\AlumniController;
use App\Http\Controllers\Public\CurriculumController;
use App\Http\Controllers\Public\SpmbController;
use App\Http\Controllers\Public\StaffController;
use App\Http\Controllers\Public\SchoolProfileController;
use App\Http\Controllers\Public\GalleryController;
use App\Http\Controllers\Public\FacilityController;
use App\Http\Controllers\Public\ExtracurricularController;
use App\Http\Controllers\Public\FeaturedProgramController;
use App\Http\Controllers\Public\AchievementController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

    Route::get('/profil', [
    SchoolProfileController::class,
    'profile',
])->name('profile.index');

Route::get('/sejarah', [
    SchoolProfileController::class,
    'history',
])->name('history.index');

Route::get('/guru', [
    StaffController::class,
    'teachers',
])->name('teachers.index');

Route::get('/karyawan', [
    StaffController::class,
    'employees',
])->name('employees.index');

Route::get('/kurikulum', [
    CurriculumController::class,
    'index',
])->name('curriculums.index');

Route::get(
    '/program-unggulan',
    [
        FeaturedProgramController::class,
        'index',
    ],
)->name('featured-programs.index');

Route::get(
    '/program-unggulan/{featuredProgram}',
    [
        FeaturedProgramController::class,
        'show',
    ],
)->name('featured-programs.show');

Route::get('/spmb', [
    SpmbController::class,
    'index',
])->name('spmb.index');

Route::prefix('berita')
    ->name('news.')
    ->group(function (): void {
        Route::get('/', [NewsController::class, 'index'])
            ->name('index');

        Route::get('/{slug}', [NewsController::class, 'show'])
            ->name('show');
    });

Route::prefix('prestasi')
    ->name('achievements.')
    ->group(function (): void {
        Route::get('/', [
            AchievementController::class,
            'index',
        ])->name('index');

        Route::get('/{slug}', [
            AchievementController::class,
            'show',
        ])->name('show');
    });

    Route::prefix('ekstrakurikuler')
    ->name('extracurriculars.')
    ->group(function (): void {
        Route::get('/', [
            ExtracurricularController::class,
            'index',
        ])->name('index');

        Route::get('/{slug}', [
            ExtracurricularController::class,
            'show',
        ])->name('show');
    });

    Route::prefix('fasilitas')
    ->name('facilities.')
    ->group(function (): void {
        Route::get('/', [
            FacilityController::class,
            'index',
        ])->name('index');

        Route::get('/{slug}', [
            FacilityController::class,
            'show',
        ])->name('show');
    });

    Route::get('/alumni', [
    AlumniController::class,
    'index',
])->name('alumni.index');

Route::prefix('kontak')
    ->name('contact.')
    ->group(function (): void {
        Route::get('/', [
            ContactController::class,
            'index',
        ])->name('index');

        Route::post('/', [
            ContactController::class,
            'store',
        ])
            ->middleware('throttle:3,1')
            ->name('store');
    });

    Route::get('/galeri', [
    GalleryController::class,
    'index',
])->name('gallery.index');

Route::post('/chatbot', [
    ChatbotController::class,
    'reply',
])
    ->middleware('throttle:10,1')
    ->name('chatbot.reply');