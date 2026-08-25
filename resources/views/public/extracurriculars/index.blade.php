@extends('layouts.app')

@section('title', 'Ekstrakurikuler')

@section('content')
    @php
        $heroActivities = collect($extracurriculars->items())
            ->take(3);
    @endphp

    <section class="public-page-hero extracurricular-page-hero">
        <div class="container">
            <nav
                class="public-page-breadcrumb"
                aria-label="Breadcrumb"
            >
                <a href="{{ route('home') }}">
                    Beranda
                </a>

                <span aria-hidden="true">/</span>

                <span aria-current="page">
                    Ekstrakurikuler
                </span>
            </nav>

            <div class="extracurricular-explorer-hero">
                <div class="extracurricular-explorer-copy">
                    <p class="public-page-eyebrow">
                        Jejak & Karya
                    </p>

                    <h1>
                        Ruang untuk tumbuh
                        <span>di luar kelas.</span>
                    </h1>

                    <p class="extracurricular-explorer-description">
                        Temukan kegiatan yang membantu peserta didik
                        mengembangkan minat, bakat, karakter, dan
                        keterampilan bersama komunitas sekolah.
                    </p>

                    @if ($extracurriculars->isNotEmpty())
                        <div class="extracurricular-explorer-stat">
                            <span>
                                {{ $extracurriculars->total() }}
                            </span>

                            <p>
                                kegiatan ekstrakurikuler
                                tersedia untuk dijelajahi
                            </p>
                        </div>
                    @endif
                </div>

                @if ($heroActivities->isNotEmpty())
                    <div
                        class="extracurricular-explorer-media"
                        aria-label="Dokumentasi kegiatan ekstrakurikuler"
                    >
                        @foreach ($heroActivities as $activity)
                            <figure
                                class="extracurricular-explorer-photo extracurricular-explorer-photo--{{ $loop->iteration }}"
                            >
                                <img
                                    src="{{ asset('storage/' . $activity->image) }}"
                                    alt="Kegiatan {{ $activity->name }}"
                                    @if ($loop->first)
                                        loading="eager"
                                        fetchpriority="high"
                                    @else
                                        loading="lazy"
                                    @endif
                                >

                                <figcaption>
                                    {{ $activity->name }}
                                </figcaption>
                            </figure>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="extracurricular-index-section">
        <div class="container">
            @if ($extracurriculars->isNotEmpty())
                <header class="extracurricular-index-heading">
                    <div>
                        <p class="latest-news-eyebrow">
                            Jelajahi Kegiatan
                        </p>

                        <h2>
                            Pilih ruang untuk
                            mengembangkan minatmu
                        </h2>

                        <p class="extracurricular-index-intro">
                            Setiap kegiatan menjadi ruang untuk belajar,
                            berlatih, bekerja sama, dan menemukan pengalaman
                            baru di luar pembelajaran kelas.
                        </p>
                    </div>

                    <span class="extracurricular-index-count">
                        <strong>
                            {{ $extracurriculars->total() }}
                        </strong>

                        kegiatan
                    </span>
                </header>

                <div class="extracurricular-grid">
                    @foreach ($extracurriculars as $extracurricular)
                        <x-extracurricular-card
                            :extracurricular="$extracurricular"
                        />
                    @endforeach
                </div>

                @if ($extracurriculars->hasPages())
                    <div class="extracurricular-pagination">
                        {{ $extracurriculars->links(
                            'pagination::bootstrap-5'
                        ) }}
                    </div>
                @endif
            @else
                <div class="news-empty-state">
                    <span
                        class="news-empty-icon"
                        aria-hidden="true"
                    >
                        <i data-lucide="star"></i>
                    </span>

                    <h2>Belum Ada Ekstrakurikuler</h2>

                    <p>
                        Informasi kegiatan ekstrakurikuler akan ditampilkan
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