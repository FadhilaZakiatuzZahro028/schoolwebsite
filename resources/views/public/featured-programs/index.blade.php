@extends('layouts.app')

@section('title', 'Program Unggulan')

@section('content')

    <section class="public-page-hero featured-program-page-hero">
    <div class="container">

        <nav
            class="public-page-breadcrumb"
            aria-label="Breadcrumb"
        >
            <a href="{{ route('home') }}">
                Beranda
            </a>

            <span aria-hidden="true">/</span>

            <span>Akademik</span>

            <span aria-hidden="true">/</span>

            <span aria-current="page">
                Program Unggulan
            </span>
        </nav>


        <div class="featured-program-hero-layout">

            <div class="featured-program-hero-copy">

                <p class="public-page-eyebrow">
                    Akademik
                </p>

                <h1>
                    Program Unggulan
                </h1>


                @if (filled($setting?->introduction))
                    <p class="featured-program-hero-description">
                        {{ $setting->introduction }}
                    </p>
                @endif


                @if ($featuredPrograms->isNotEmpty())
                    <a
                        class="btn btn-site-primary"
                        href="#featured-program-list"
                    >
                        Jelajahi Program
                    </a>
                @endif

            </div>


            @if ($heroImages->isNotEmpty())

                <div class="featured-program-hero-visual">

                    <div class="featured-program-hero-collage">

                        @foreach ($heroImages as $image)

                            <figure>
                                <img
                                    src="{{ asset('storage/' . $image) }}"
                                    alt="Kegiatan Program Unggulan siswa"
                                    loading="eager"
                                >
                            </figure>

                        @endforeach

                    </div>

                </div>

            @endif

        </div>

    </div>
</section>

    @if (filled($setting?->collaboration_text))
<section class="site-section featured-program-collaboration-section">
    <div class="container">

        <div class="featured-program-collaboration">

            <div class="featured-program-collaboration-heading">

                <span></span>

                <div>
                    <p class="latest-news-eyebrow">
                        Pengembangan Keterampilan
                    </p>

                    <h2>
                        Kolaborasi LPK & BLK
                    </h2>
                </div>

            </div>


            <p class="featured-program-collaboration-text">
                {{ $setting->collaboration_text }}
            </p>

        </div>

    </div>
</section>
@endif


    <section
        id="featured-program-list"
        class="site-section featured-program-showcase-section"
    >
        <div class="container">
            @if ($featuredPrograms->isNotEmpty())
                <header class="featured-program-showcase-heading">
                    <p class="latest-news-eyebrow">
                        Pilihan Keterampilan
                    </p>

                    <h2>
                        Kenali Program yang Tersedia
                    </h2>
                </header>

                <div class="featured-program-grid">
    @foreach ($featuredPrograms as $program)
        <x-featured-program-card :program="$program" />
    @endforeach
</div>
            @else
                <div class="news-empty-state">
                    <span
                        class="news-empty-icon"
                        aria-hidden="true"
                    >
                        <i data-lucide="briefcase-business"></i>
                    </span>

                    <h2>Program Unggulan Belum Tersedia</h2>

                    <p>
                        Informasi Program Unggulan akan ditampilkan
                        setelah tersedia melalui panel admin.
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

    @if ($featuredPrograms->isNotEmpty())
        <section class="site-section featured-program-cta-section">
            <div class="container">
                <div class="featured-program-cta">
                    <p class="latest-news-eyebrow">
                        Langkah Berikutnya
                    </p>

                    <h2>
                        Temukan Informasi Pendaftaran
                    </h2>

                    <div class="d-flex flex-wrap gap-3">
                        <a
                            class="btn btn-site-primary"
                            href="{{ route('spmb.index') }}"
                        >
                            Lihat Informasi SPMB
                        </a>

                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection