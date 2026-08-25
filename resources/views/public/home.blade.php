@extends('layouts.app')

@section(
    'title',
    $siteSetting?->site_name
        ?? $schoolProfile?->school_name
        ?? config('app.name')
)

@section(
    'meta_description',
    $siteSetting?->site_description
        ?? $schoolProfile?->tagline
        ?? ''
)

@section('content')
   <section
    class="site-hero"
    aria-label="Sorotan utama sekolah"
>
    @if ($heroBanners->isNotEmpty())
        <div
            id="homeHeroCarousel"
            class="carousel slide carousel-fade site-hero-carousel"
            @if ($heroBanners->count() > 1)
                data-bs-ride="carousel"
                data-bs-interval="6500"
                data-bs-pause="hover"
            @endif
        >
            @if ($heroBanners->count() > 1)
                <div class="carousel-indicators">
                    @foreach ($heroBanners as $heroBanner)
                        <button
                            type="button"
                            data-bs-target="#homeHeroCarousel"
                            data-bs-slide-to="{{ $loop->index }}"
                            class="{{ $loop->first ? 'active' : '' }}"
                            @if ($loop->first) aria-current="true" @endif
                            aria-label="Tampilkan banner {{ $loop->iteration }}"
                        ></button>
                    @endforeach
                </div>
            @endif

            <div class="carousel-inner">
                @foreach ($heroBanners as $heroBanner)
                    @php
                        $heroImageUrl = \Illuminate\Support\Facades\Storage::url(
                            $heroBanner->image,
                        );
                    @endphp

                    <article
                        class="carousel-item site-hero-slide {{ $loop->first ? 'active' : '' }}"
                    >
                        <img
    class="site-hero-image"
    src="{{ $heroImageUrl }}"
    alt=""
    aria-hidden="true"
    loading="{{ $loop->first ? 'eager' : 'lazy' }}"
    decoding="async"
    @if ($loop->first)
        fetchpriority="high"
    @endif
>

                        <div class="container site-hero-container">
                            <div class="site-hero-content">
                                <p class="site-hero-eyebrow">
                                    Selamat Datang
                                </p>

                                @if ($loop->first)
                                    <h1 class="site-hero-title">
                                        {{ $heroBanner->title }}
                                    </h1>
                                @else
                                    <h2 class="site-hero-title">
                                        {{ $heroBanner->title }}
                                    </h2>
                                @endif

                                @if (filled($heroBanner->subtitle))
                                    <p class="site-hero-description">
                                        {{ $heroBanner->subtitle }}
                                    </p>
                                @endif

                                <div class="hero-actions">
                                    @if (
                                        filled($heroBanner->button_text)
                                        && filled($heroBanner->button_url)
                                    )
                                        <a
                                            class="btn btn-site-primary"
                                            href="{{ $heroBanner->button_url }}"
                                        >
                                            {{ $heroBanner->button_text }}
                                        </a>
                                    @endif

                                    <a
                                        class="btn btn-site-secondary"
                                        href="{{ url('/kontak') }}"
                                    >
                                        Hubungi Kami
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($heroBanners->count() > 1)
                <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#homeHeroCarousel"
                    data-bs-slide="prev"
                    aria-label="Banner sebelumnya"
                >
                    <span
                        class="carousel-control-prev-icon"
                        aria-hidden="true"
                    ></span>
                </button>

                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#homeHeroCarousel"
                    data-bs-slide="next"
                    aria-label="Banner berikutnya"
                >
                    <span
                        class="carousel-control-next-icon"
                        aria-hidden="true"
                    ></span>
                </button>
            @endif
        </div>
    @else
        <div class="site-hero-fallback">
    <div class="container site-hero-container">
        <div class="site-hero-content">
            <p class="site-hero-eyebrow">
                Selamat Datang di Website
            </p>

            <h1 class="site-hero-title">
                {{ $schoolProfile?->school_name ?? config('app.name') }}
            </h1>

            <p class="site-hero-description">
                {{ $schoolProfile?->tagline
                    ?? $siteSetting?->site_description
                    ?? 'Informasi sekolah akan segera tersedia.' }}
            </p>

            <div class="hero-actions">
                <a
                    class="btn btn-site-primary"
                    href="{{ url('/kontak') }}"
                >
                    Hubungi Kami
                </a>

                <a
                    class="btn btn-site-secondary"
                    href="{{ url('/profil') }}"
                >
                    Lihat Profil
                </a>
            </div>
        </div>
    </div>
</div>
    @endif
    <a
    class="hero-scroll-indicator"
    href="#quick-access"
    aria-label="Lanjut ke akses cepat"
>
    <span>Jelajahi</span>

    <span
        class="hero-scroll-indicator-icon"
        aria-hidden="true"
    ></span>
</a>
    <div
    class="hero-values-bar"
    role="region"
    aria-label="Nilai utama sekolah"
>
    <div class="hero-values-track">
        <div class="hero-values-marquee">
            <span>
                Berprestasi ✦ Unggul ✦ Berkarakter ✦ Disiplin ✦ Kreatif ✦ Aktif ✦ Inspiratif ✦ Jawara
            </span>

            <span aria-hidden="true">
                Berprestasi ✦ Unggul ✦ Berkarakter ✦ Disiplin ✦ Kreatif ✦ Aktif ✦ Inspiratif ✦ Jawara
            </span>
        </div>
    </div>
</div>
</section>

    <section
    id="quick-access"
    class="quick-access-section"
    aria-labelledby="quick-access-title"
>
    <div class="container">
        <div class="quick-access-heading">
            <p class="quick-access-eyebrow">
                Jelajahi Informasi
            </p>

            <h2 id="quick-access-title" class="quick-access-title">
                Akses Cepat
            </h2>

            <p class="quick-access-description">
                Temukan informasi utama sekolah dengan lebih mudah dan cepat.
            </p>
        </div>

        <div class="row g-3 g-lg-4">
            <div class="col-12 col-sm-6 col-lg-3">
                <a class="quick-access-card" href="{{ url('/profil') }}">
                    <span class="quick-access-icon" aria-hidden="true">
                        <i data-lucide="school"></i>
                    </span>

                    <span class="quick-access-content">
                        <strong>Profil Sekolah</strong>
                        <span>Kenali identitas dan arah pendidikan sekolah.</span>
                    </span>

                    <span class="quick-access-arrow" aria-hidden="true">
                        <i data-lucide="arrow-up-right"></i>
                    </span>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <a class="quick-access-card" href="{{ url('/spmb') }}">
                    <span class="quick-access-icon" aria-hidden="true">
                        <i data-lucide="clipboard-list"></i>
                    </span>

                    <span class="quick-access-content">
                        <strong>Informasi SPMB</strong>
                        <span>Akses informasi penerimaan murid baru.</span>
                    </span>

                    <span class="quick-access-arrow" aria-hidden="true">
                        <i data-lucide="arrow-up-right"></i>
                    </span>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <a class="quick-access-card" href="{{ url('/berita') }}">
                    <span class="quick-access-icon" aria-hidden="true">
                        <i data-lucide="newspaper"></i>
                    </span>

                    <span class="quick-access-content">
                        <strong>Berita Sekolah</strong>
                        <span>Ikuti informasi dan kegiatan terbaru.</span>
                    </span>

                    <span class="quick-access-arrow" aria-hidden="true">
                        <i data-lucide="arrow-up-right"></i>
                    </span>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <a class="quick-access-card" href="{{ url('/kontak') }}">
                    <span class="quick-access-icon" aria-hidden="true">
                        <i data-lucide="messages-square"></i>
                    </span>

                    <span class="quick-access-content">
                        <strong>Kontak</strong>
                        <span>Temukan saluran komunikasi resmi sekolah.</span>
                    </span>

                    <span class="quick-access-arrow" aria-hidden="true">
                        <i data-lucide="arrow-up-right"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

    @if ($hasPrincipalSection)
    <section
        class="site-section school-intro-section"
        aria-labelledby="principal-section-title"
    >
        <div class="container">
            @if ($hasPrincipalSection)
                <div class="principal-panel">
                    <div class="row g-0 align-items-stretch">
                        <div class="col-12 col-lg-4">
                            <div class="principal-visual">
                                @if (filled($principalPhoto))
                                    <img
                                        class="principal-photo"
                                        src="{{ asset('storage/' . $principalPhoto) }}"
                                        alt="Foto {{ $schoolProfile->principal_name }}"
                                        width="640"
                                        height="760"
                                        loading="lazy"
                                    >
                                @else
                                    <div
                                        class="principal-photo-placeholder"
                                        role="img"
                                        aria-label="Foto kepala sekolah belum tersedia"
                                    >
                                        <i
                                            data-lucide="user-round"
                                            aria-hidden="true"
                                        ></i>
                                    </div>
                                @endif

                                <div class="principal-identity">
                                    <span>Kepala Sekolah</span>

                                    <strong>
                                        {{ $schoolProfile->principal_name }}
                                    </strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            <div class="principal-content">
                                <p class="principal-eyebrow">
                                    Profil Sekolah
                                </p>

                                <h2
                                    id="principal-section-title"
                                    class="principal-title"
                                >
                                    Sambutan Kepala Sekolah
                                </h2>

                                @if (filled($schoolProfile->tagline))
                                    <p class="principal-tagline">
                                        {{ $schoolProfile->tagline }}
                                    </p>
                                @endif

                                <blockquote class="principal-message">
                                    {{ $principalMessage }}
                                </blockquote>

                                <a
                                    class="btn btn-site-primary principal-action"
                                    href="{{ url('/profil') }}"
                                >
                                    Lihat Profil Sekolah

                                    <i
                                        data-lucide="arrow-up-right"
                                        aria-hidden="true"
                                    ></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>
    @endif

    @if ($teachers->isNotEmpty())
    <section
        class="site-section home-teachers-section"
        aria-labelledby="home-teachers-title"
    >
        <div class="container">
            <div class="home-teachers-header">
                <div>
                    <p class="principal-eyebrow">
                        Tenaga Pendidik
                    </p>

                    <h2
                        id="home-teachers-title"
                        class="latest-news-title"
                    >
                        Kenali Guru Kami
                    </h2>

                    <p class="latest-news-description">
                        Mengenal tenaga pendidik yang mendampingi
                        proses belajar dan perkembangan peserta didik
                        di SMA PGRI 1 Tulungagung.
                    </p>
                </div>

                <a
    href="{{ url('/guru') }}"
    class="home-section-action"
>
    Lihat Semua Guru

    <i
        data-lucide="arrow-right"
        aria-hidden="true"
    ></i>
</a>
            </div>

            <x-staff-carousel
                :staff-members="$teachers"
                :initial-index="0"
            />
        </div>
    </section>
@endif

    @if ($latestNews->isNotEmpty())
    <section
        class="site-section latest-news-section"
        aria-labelledby="latest-news-title"
    >
        <div class="container">
            <div class="latest-news-header">
                <div>
                    <p class="latest-news-eyebrow">
                        Informasi Terkini
                    </p>

                    <h2
                        id="latest-news-title"
                        class="latest-news-title"
                    >
                        Berita Terbaru
                    </h2>

                    <p class="latest-news-description">
                        Ikuti kegiatan, pengumuman, dan perkembangan terbaru
                        dari sekolah.
                    </p>
                </div>

                <a
                    class="home-section-action"
                    href="{{ route('news.index') }}"
                >
                    Lihat Semua Berita

                    <i
                        data-lucide="arrow-right"
                        aria-hidden="true"
                    ></i>
                </a>
            </div>

            <div class="row g-4">
                @foreach ($latestNews as $newsItem)
                    <div class="col-12 col-md-6 col-lg-4">
                        <x-news-card :news="$newsItem" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@if ($latestAchievements->isNotEmpty())
    <section
        class="site-section achievement-highlight-section"
        aria-labelledby="latest-achievements-title"
    >
        <div class="container">
            <div class="achievement-home-layout">
                <div class="achievement-home-copy">
                    <p class="achievement-section-eyebrow">
                        Jejak Keunggulan
                    </p>

                    <h2
                        id="latest-achievements-title"
                        class="achievement-home-title"
                    >
                        Prestasi Terkini
                    </h2>

                    <p class="achievement-home-description">
                        Apresiasi atas kerja keras, semangat, dan pencapaian
                        terbaik warga sekolah.
                    </p>

                    <a
                        class="home-section-action home-section-action--inverse"
                        href="{{ route('achievements.index') }}"
                    >
                        Lihat Semua Prestasi

                        <i
                            data-lucide="arrow-right"
                            aria-hidden="true"
                        ></i>
                    </a>
                </div>

                <div
                    class="achievement-grid achievement-grid--{{ $latestAchievements->count() }}"
                >
                    @foreach ($latestAchievements as $achievement)
                        <x-achievement-card
                            :achievement="$achievement"
                        />
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

@if ($featuredExtracurriculars->isNotEmpty())
    <section
        class="site-section extracurricular-home-section"
        aria-labelledby="featured-extracurriculars-title"
    >
        <div class="container">
            <div class="extracurricular-home-header">
                <div>
                    <p class="latest-news-eyebrow">
                        Minat & Bakat
                    </p>

                    <h2 id="featured-extracurriculars-title">
                        Ekstrakurikuler Pilihan
                    </h2>

                    <p>
                        Ruang bagi siswa untuk mengembangkan potensi,
                        keterampilan, dan pengalaman di luar kelas.
                    </p>
                </div>

                <a
    class="home-section-action"
    href="{{ route('extracurriculars.index') }}"
>
    Lihat Semua Ekstrakurikuler

    <i
        data-lucide="arrow-right"
        aria-hidden="true"
    ></i>
</a>
            </div>

            <div class="extracurricular-grid">
                @foreach ($featuredExtracurriculars as $extracurricular)
                    <x-extracurricular-card
                        :extracurricular="$extracurricular"
                    />
                @endforeach
            </div>
        </div>
    </section>
@endif

@if ($featuredFacilities->isNotEmpty())
    <section
        class="site-section facility-home-section"
        aria-labelledby="featured-facilities-title"
    >
        <div class="container">
            <div class="facility-home-header">
                <div>
                    <p class="latest-news-eyebrow">
                        Sarana Pendukung
                    </p>

                    <h2 id="featured-facilities-title">
                        Fasilitas Sekolah
                    </h2>

                    <p>
                        Sarana dan prasarana yang mendukung pembelajaran,
                        kegiatan siswa, dan lingkungan sekolah.
                    </p>
                </div>

                <a
    class="home-section-action"
    href="{{ route('facilities.index') }}"
>
    Lihat Semua Fasilitas

    <i
        data-lucide="arrow-right"
        aria-hidden="true"
    ></i>
</a>
            </div>

            <div
    class="facility-home-showcase
        facility-home-showcase--{{ $featuredFacilities->count() }}"
>
    @foreach ($featuredFacilities as $facility)
        <div
            class="facility-home-item
                {{ $loop->first
                    ? 'facility-home-item--featured'
                    : 'facility-home-item--compact' }}"
        >
            <x-facility-card :facility="$facility" />
        </div>
    @endforeach
</div>
        </div>
    </section>
@endif

@if ($latestGalleryItems->isNotEmpty())
    <section
        class="site-section gallery-home-section"
        aria-labelledby="latest-gallery-title"
    >
        <div class="container">
            <div class="gallery-home-header">
                <div>
                    <p class="latest-news-eyebrow">
                        Dokumentasi Sekolah
                    </p>

                    <h2 id="latest-gallery-title">
                        Galeri Terbaru
                    </h2>

                    <p>
                        Lihat berbagai kegiatan, pembelajaran, dan momen
                        berkesan di lingkungan sekolah.
                    </p>
                </div>

                <a
    class="home-section-action"
    href="{{ route('gallery.index') }}"
>
    Lihat Semua Galeri

    <i
        data-lucide="arrow-right"
        aria-hidden="true"
    ></i>
</a>
            </div>

            <div class="gallery-grid gallery-home-grid">
                @foreach ($latestGalleryItems as $galleryItem)
                    <x-gallery-item
                        :gallery-item="$galleryItem"
                    />
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection