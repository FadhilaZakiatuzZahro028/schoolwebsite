@extends('layouts.app')

@section('title', $extracurricular->name)

@section('content')
    <section class="public-page-hero extracurricular-detail-hero">
        <div class="container">
            <nav
                class="public-page-breadcrumb"
                aria-label="Breadcrumb"
            >
                <a href="{{ route('home') }}">
                    Beranda
                </a>

                <span aria-hidden="true">/</span>

                <a href="{{ route('extracurriculars.index') }}">
                    Ekstrakurikuler
                </a>

                <span aria-hidden="true">/</span>

                <span aria-current="page">
                    {{ $extracurricular->name }}
                </span>
            </nav>

            <div class="extracurricular-profile-hero">
                <div class="extracurricular-profile-copy">
                    <p class="public-page-eyebrow">
                        Kegiatan Siswa
                    </p>

                    <h1>
                        {{ $extracurricular->name }}
                    </h1>

                    <p class="extracurricular-profile-intro">
                        Ruang bagi peserta didik untuk mengembangkan
                        minat, keterampilan, karakter, dan pengalaman
                        melalui kegiatan bersama di luar kelas.
                    </p>

                    <div class="extracurricular-profile-facts">
                        <div class="extracurricular-profile-fact">
                            <span
                                class="extracurricular-profile-fact-icon"
                                aria-hidden="true"
                            >
                                <i data-lucide="user-round"></i>
                            </span>

                            <div>
                                <span>Pembina</span>

                                <strong>
                                    {{ $extracurricular->coach_name }}
                                </strong>
                            </div>
                        </div>

                        <div class="extracurricular-profile-fact">
                            <span
                                class="extracurricular-profile-fact-icon"
                                aria-hidden="true"
                            >
                                <i data-lucide="calendar-clock"></i>
                            </span>

                            <div>
                                <span>Jadwal Kegiatan</span>

                                <strong>
                                    {{ $extracurricular->schedule }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <figure class="extracurricular-profile-media">
                    <img
                        src="{{ asset(
                            'storage/' . $extracurricular->image
                        ) }}"
                        alt="Kegiatan {{ $extracurricular->name }}"
                        loading="eager"
                        fetchpriority="high"
                    >

                    <figcaption>
                        Dokumentasi utama
                        {{ $extracurricular->name }}
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    <section class="extracurricular-about-section">
        <div class="container">
            <article class="extracurricular-about">
                <header class="extracurricular-about-header">
                    <p class="extracurricular-detail-eyebrow">
                        Tentang Kegiatan
                    </p>

                    <h2>
                        Mengenal {{ $extracurricular->name }}
                    </h2>
                </header>

                <div class="extracurricular-about-content">
                    {!! nl2br(e($extracurricular->description)) !!}
                </div>
            </article>
        </div>
    </section>

    @if ($extracurricular->images->isNotEmpty())
        <section class="extracurricular-documentation-section">
            <div class="container">
                <header class="extracurricular-documentation-header">
                    <div>
                        <p class="extracurricular-detail-eyebrow">
                            Dokumentasi Kegiatan
                        </p>

                        <h2>
                            Melihat kegiatan lebih dekat
                        </h2>
                    </div>

                    <p>
                        Beberapa momen dari aktivitas
                        {{ $extracurricular->name }}.
                    </p>
                </header>

                <div
                    class="extracurricular-documentation-grid
                        {{ $extracurricular->images->count() === 1
                            ? 'extracurricular-documentation-grid--single'
                            : '' }}"
                >
                    @foreach ($extracurricular->images as $image)
                        <figure class="extracurricular-documentation-item">
                            <img
                                src="{{ asset(
                                    'storage/' . $image->image
                                ) }}"
                                alt="{{ filled($image->alt_text)
                                    ? $image->alt_text
                                    : 'Dokumentasi ' .
                                        $extracurricular->name }}"
                                loading="lazy"
                            >
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="extracurricular-closing-section">
        <div class="container">
            <div class="extracurricular-closing">
                <div>
                    <p class="extracurricular-detail-eyebrow">
                        Jelajahi Kegiatan Lain
                    </p>

                    <h2>
                        Temukan ruang yang sesuai dengan minatmu.
                    </h2>

                    <p>
                        Lihat kegiatan ekstrakurikuler lain yang
                        tersedia di SMA PGRI 1 Tulungagung.
                    </p>
                </div>

                <a
                    class="extracurricular-closing-link"
                    href="{{ route('extracurriculars.index') }}"
                >
                    Lihat Semua Ekstrakurikuler

                    <i
                        data-lucide="arrow-right"
                        aria-hidden="true"
                    ></i>
                </a>
            </div>
        </div>
    </section>
@endsection