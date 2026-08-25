@extends('layouts.app')

@section('title', 'Fasilitas Sekolah')

@section('content')
    <section
        class="
            public-page-hero
            facility-page-hero
            facility-index-hero
        "
    >
        <div class="container">
            <div class="facility-index-hero-layout">
                <div class="facility-index-hero-copy">
                    <nav
                        class="public-page-breadcrumb"
                        aria-label="Breadcrumb"
                    >
                        <a href="{{ route('home') }}">
                            Beranda
                        </a>

                        <span aria-hidden="true">/</span>

                        <span aria-current="page">
                            Fasilitas
                        </span>
                    </nav>

                    <p class="public-page-eyebrow">
                        Sarana Sekolah
                    </p>

                    <h1>Fasilitas Sekolah</h1>

                    <p>
                        Berbagai sarana dan prasarana yang mendukung
                        proses pembelajaran, kegiatan siswa, serta
                        pengembangan potensi di lingkungan sekolah.
                    </p>

                    @if ($facilities->isNotEmpty())
                        <a
                            class="facility-index-hero-action"
                            href="#facility-list"
                        >
                            Jelajahi Fasilitas

                            <i
                                data-lucide="arrow-down"
                                aria-hidden="true"
                            ></i>
                        </a>
                    @endif
                </div>

                <div
                    class="facility-index-hero-visual"
                    aria-hidden="true"
                >
                    <div class="facility-index-hero-glow"></div>

                    <div
                        class="
                            facility-index-hero-icon
                            facility-index-hero-icon--main
                        "
                    >
                        <i data-lucide="school"></i>
                    </div>

                    <div
                        class="
                            facility-index-hero-icon
                            facility-index-hero-icon--book
                        "
                    >
                        <i data-lucide="book-open"></i>
                    </div>

                    <div
                        class="
                            facility-index-hero-icon
                            facility-index-hero-icon--activity
                        "
                    >
                        <i data-lucide="dumbbell"></i>
                    </div>

                    <div
                        class="
                            facility-index-hero-icon
                            facility-index-hero-icon--creative
                        "
                    >
                        <i data-lucide="music-2"></i>
                    </div>

                    <div class="facility-index-hero-line"></div>
                </div>
            </div>
        </div>
    </section>

    <section
        id="facility-list"
        class="site-section facility-index-section"
    >
        <div class="container">
            @if ($facilities->isNotEmpty())
                <div class="facility-index-heading">
                    <div class="facility-index-heading-copy">
                        <p class="latest-news-eyebrow">
                            Sarana & Prasarana
                        </p>

                        <h2>Jelajahi Fasilitas</h2>

                        <p>
                            Kenali fasilitas yang tersedia untuk mendukung
                            pengalaman belajar dan aktivitas siswa.
                        </p>
                    </div>

                    <div class="facility-index-count">
                        <strong>{{ $facilities->total() }}</strong>
                        <span>Fasilitas</span>
                    </div>
                </div>

                <div class="facility-grid">
                    @foreach ($facilities as $facility)
                        <x-facility-card :facility="$facility" />
                    @endforeach
                </div>

                @if ($facilities->hasPages())
                    <div class="facility-pagination">
                        {{ $facilities->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="news-empty-state">
                    <span
                        class="news-empty-icon"
                        aria-hidden="true"
                    >
                        <i data-lucide="school"></i>
                    </span>

                    <h2>Belum Ada Fasilitas</h2>

                    <p>
                        Informasi fasilitas sekolah akan ditampilkan
                        setelah ditambahkan melalui panel admin.
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