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
        class="quick-access-section"
        aria-labelledby="quick-access-title"
    >
        <div class="container">
            <h2 id="quick-access-title" class="visually-hidden">
                Akses Cepat
            </h2>

            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-3">
                    <a class="quick-access-card" href="{{ url('/profil') }}">
                        <strong>Profil Sekolah</strong>
                        <span>Kenali identitas dan arah pendidikan sekolah.</span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <a class="quick-access-card" href="{{ url('/spmb') }}">
                        <strong>Informasi SPMB</strong>
                        <span>Akses informasi penerimaan murid baru.</span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <a class="quick-access-card" href="{{ url('/berita') }}">
                        <strong>Berita Sekolah</strong>
                        <span>Ikuti informasi dan kegiatan terbaru.</span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <a class="quick-access-card" href="{{ url('/kontak') }}">
                        <strong>Kontak</strong>
                        <span>Temukan saluran komunikasi resmi sekolah.</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="container">
            <div class="mx-auto text-center" style="max-width: 44rem;">
                <h2 class="mb-3">Informasi Sekolah dalam Satu Akses</h2>

                <p class="mb-0">
                    Konten utama beranda akan ditambahkan secara bertahap
                    menggunakan data yang dikelola melalui panel admin.
                </p>
            </div>
        </div>
    </section>
@endsection