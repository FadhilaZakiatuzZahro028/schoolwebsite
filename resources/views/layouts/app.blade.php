@php
    $pageTitle = trim($__env->yieldContent(
        'title',
        $siteSetting?->site_name ?? config('app.name'),
    ));

    $pageDescription = trim($__env->yieldContent(
        'meta_description',
        $siteSetting?->site_description ?? '',
    ));

    $faviconUrl = $schoolProfile?->favicon
        ? \Illuminate\Support\Facades\Storage::url($schoolProfile->favicon)
        : null;

    $ogImageUrl = $siteSetting?->default_og_image
        ? \Illuminate\Support\Facades\Storage::url($siteSetting->default_og_image)
        : null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $pageTitle }}</title>

    @if ($pageDescription !== '')
        <meta name="description" content="{{ $pageDescription }}">
    @endif

    @if (filled($siteSetting?->default_meta_keywords))
        <meta
            name="keywords"
            content="{{ $siteSetting->default_meta_keywords }}"
        >
    @endif

    <meta name="theme-color" content="#123C9B">

    <meta property="og:title" content="{{ $pageTitle }}">

    @if ($pageDescription !== '')
        <meta property="og:description" content="{{ $pageDescription }}">
    @endif

    @if ($ogImageUrl)
        <meta property="og:image" content="{{ $ogImageUrl }}">
    @endif

    @if ($faviconUrl)
        <link rel="icon" href="{{ $faviconUrl }}">
    @endif

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

    @stack('head')
</head>
<body class="d-flex flex-column">
    <a class="skip-link" href="#main-content">
        Lewati ke konten utama
    </a>

    <x-navbar :school-profile="$schoolProfile" />

    <main id="main-content">
        @yield('content')
    </main>

    <x-footer
        :school-profile="$schoolProfile"
        :site-setting="$siteSetting"
    />

    @stack('scripts')
</body>
</html>