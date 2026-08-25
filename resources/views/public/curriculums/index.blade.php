@extends('layouts.app')

@section('title', 'Kurikulum')

@section('content')
    <section class="public-page-hero curriculum-page-hero">
    <div class="container">
        <nav
            class="public-page-breadcrumb"
            aria-label="Breadcrumb"
        >
            <a href="{{ route('home') }}">
                Beranda
            </a>

            <span aria-hidden="true">/</span>

            <span>
                Akademik
            </span>

            <span aria-hidden="true">/</span>

            <span aria-current="page">
                Kurikulum
            </span>
        </nav>

        <div class="curriculum-hero-layout">
            <div class="curriculum-hero-copy">
                <p class="public-page-eyebrow">
                    Program Akademik
                </p>

                <h1>Kurikulum</h1>

                <p class="curriculum-hero-description">
                    Informasi kurikulum dan perangkat akademik yang
                    menjadi acuan proses pembelajaran sekolah.
                </p>
            </div>

            @if ($activeYear)
                <div class="curriculum-hero-status">
                    <span class="curriculum-hero-status-label">
                        Tahun Ajaran Aktif
                    </span>

                    <strong>
                        {{ $activeYear }}
                    </strong>

                    <div class="curriculum-hero-status-meta">
                        <span>
                            <i
                                data-lucide="book-open"
                                aria-hidden="true"
                            ></i>

                            {{ $curriculums->count() }}
                            dokumen
                        </span>

                        <span>
                            <i
                                data-lucide="circle-check"
                                aria-hidden="true"
                            ></i>

                            Tersedia
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

    <section class="site-section curriculum-index-section">
    <div class="container">
        @if ($curriculums->isNotEmpty())
            <div class="curriculum-documents-header">
                <div>
                    <p class="latest-news-eyebrow">
                        Informasi Akademik
                    </p>

                    <h2>Dokumen Akademik</h2>

                    @if ($activeYear)
                        <p>
                            Tahun Ajaran {{ $activeYear }}
                        </p>
                    @endif
                </div>

                <span>
                    {{ $curriculums->count() }} dokumen
                </span>
            </div>

            @if ($availableYears->count() > 1)
                <nav
                    class="curriculum-year-nav"
                    aria-label="Pilih tahun ajaran"
                >
                    @foreach ($availableYears as $year)
                        <a
                            class="{{ $year === $activeYear ? 'is-active' : '' }}"
                            href="{{ route(
                                'curriculums.index',
                                ['year' => $year]
                            ) }}"
                            @if ($year === $activeYear)
                                aria-current="page"
                            @endif
                        >
                            <span>Tahun Ajaran</span>
                            <strong>{{ $year }}</strong>
                        </a>
                    @endforeach
                </nav>
            @endif

            <div
                class="curriculum-documents-grid curriculum-documents-grid--{{ min($curriculums->count(), 3) }}"
            >
                @foreach ($curriculums as $curriculum)
                    <div
                        class="curriculum-document-item {{ $loop->first ? 'curriculum-document-item--featured' : '' }}"
                    >
                        @if ($loop->first)
                            <span class="curriculum-document-featured-label">
                                Dokumen Utama
                            </span>
                        @endif

                        <x-curriculum-card
                            :curriculum="$curriculum"
                        />
                    </div>
                @endforeach
            </div>

            <div class="curriculum-closing">
                <div>
                    <p class="latest-news-eyebrow">
                        Informasi Akademik
                    </p>

                    <h2>Butuh informasi lebih lanjut?</h2>

                    <p>
                        Hubungi sekolah apabila membutuhkan informasi
                        mengenai kurikulum atau dokumen akademik lainnya.
                    </p>
                </div>

                <a
                    class="home-section-action"
                    href="{{ route('contact.index') }}"
                >
                    Hubungi Sekolah

                    <i
                        data-lucide="arrow-right"
                        aria-hidden="true"
                    ></i>
                </a>
            </div>
        @else
            <div class="news-empty-state">
                <span
                    class="news-empty-icon"
                    aria-hidden="true"
                >
                    <i data-lucide="book-open"></i>
                </span>

                <h2>Kurikulum Belum Tersedia</h2>

                <p>
                    Informasi kurikulum akan ditampilkan setelah
                    dipublikasikan melalui panel admin.
                </p>

                <a
                    class="btn btn-site-primary"
                    href="{{ route('home') }}"
                >
                    Kembali ke Beranda
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
