@props([
    'schoolProfile' => null,
])

@php
    $brandName = $schoolProfile?->school_name ?? config('app.name');

    $brandInitials = collect(preg_split('/\s+/', $brandName))
        ->filter()
        ->take(2)
        ->map(fn (string $word): string => mb_substr($word, 0, 1))
        ->implode('');

    $logoUrl = $schoolProfile?->logo
        ? \Illuminate\Support\Facades\Storage::url($schoolProfile->logo)
        : null;
@endphp

<nav
    class="navbar navbar-expand-lg site-navbar sticky-top"
    data-site-navbar
    aria-label="Navigasi utama"
>
    <div class="container">
        <a class="site-brand navbar-brand" href="{{ url('/') }}">
            @if ($logoUrl)
                <img
                    class="site-brand-logo"
                    src="{{ $logoUrl }}"
                    alt="Logo {{ $brandName }}"
                    width="48"
                    height="48"
                >
            @else
                <span
                    class="site-brand-placeholder"
                    aria-hidden="true"
                >
                    {{ $brandInitials }}
                </span>
            @endif

            <span class="site-brand-name">
                {{ $brandName }}
            </span>
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#siteNavigation"
            aria-controls="siteNavigation"
            aria-expanded="false"
            aria-label="Buka navigasi"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div
            id="siteNavigation"
            class="collapse navbar-collapse"
        >
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                        href="{{ url('/') }}"
                        @if (request()->is('/')) aria-current="page" @endif
                    >
                        Beranda
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <button
                        class="nav-link dropdown-toggle border-0 bg-transparent"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        Profil
                    </button>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ url('/profil') }}">
                                Profil Sekolah
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('/sejarah') }}">
                                Sejarah
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('/guru') }}">
                                Data Guru
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('/karyawan') }}">
                                Data Karyawan
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <button
                        class="nav-link dropdown-toggle border-0 bg-transparent"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        Akademik
                    </button>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ url('/kurikulum') }}">
                                Kurikulum
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('/fasilitas') }}">
                                Fasilitas
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <button
                        class="nav-link dropdown-toggle border-0 bg-transparent"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        Informasi
                    </button>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ url('/berita') }}">
                                Berita
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('/spmb') }}">
                                SPMB
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <button
                        class="nav-link dropdown-toggle border-0 bg-transparent"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        Jejak & Karya
                    </button>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ url('/prestasi') }}">
                                Prestasi
                            </a>
                        </li>
                        <li>
                            <a
                                class="dropdown-item"
                                href="{{ url('/ekstrakurikuler') }}"
                            >
                                Ekstrakurikuler
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('/alumni') }}">
                                Alumni
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->is('kontak') ? 'active' : '' }}"
                        href="{{ url('/kontak') }}"
                    >
                        Kontak
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>