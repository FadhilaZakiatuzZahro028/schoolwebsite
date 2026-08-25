@extends('layouts.app')

@section('title', $achievement->title)

@section('content')
    <section class="public-page-hero achievement-page-hero">
        <div class="container">
            <nav
                class="public-page-breadcrumb"
                aria-label="Breadcrumb"
            >
                <a href="{{ route('home') }}">
                    Beranda
                </a>

                <span aria-hidden="true">/</span>

                <a href="{{ route('achievements.index') }}">
                    Prestasi
                </a>

                <span aria-hidden="true">/</span>

                <span aria-current="page">
                    Detail Prestasi
                </span>
            </nav>

            <div class="achievement-showcase">
                <div class="achievement-showcase-copy">
                    <p class="public-page-eyebrow">
                        Prestasi {{ $achievement->year }}
                    </p>

                    <h1>{{ $achievement->title }}</h1>

                    <div
                        class="achievement-showcase-meta"
                        aria-label="Informasi prestasi"
                    >
                        <span class="achievement-showcase-badge">
                            <i
                                data-lucide="trophy"
                                aria-hidden="true"
                            ></i>

                            Tingkat {{ $achievement->level }}
                        </span>

                        <span class="achievement-showcase-badge">
                            <i
                                data-lucide="calendar-days"
                                aria-hidden="true"
                            ></i>

                            Tahun {{ $achievement->year }}
                        </span>
                    </div>

                    <p class="achievement-showcase-description">
                        Pencapaian tingkat {{ $achievement->level }}
                        yang diraih pada tahun {{ $achievement->year }}.
                    </p>

                    <span
                        class="achievement-showcase-accent"
                        aria-hidden="true"
                    ></span>
                </div>

                <figure class="achievement-showcase-media">
                    <div class="achievement-showcase-image-frame">
                        <img
                            class="achievement-showcase-image"
                            src="{{ asset('storage/' . $achievement->image) }}"
                            alt="Dokumentasi {{ $achievement->title }}"
                            loading="eager"
                            fetchpriority="high"
                        >
                    </div>

                    <figcaption>
                        Dokumentasi prestasi SMA PGRI 1 Tulungagung
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    <section class="achievement-story-section">
        <div class="container">
            <article class="achievement-story">
                <header class="achievement-story-header">
                    <p class="achievement-story-eyebrow">
                        Cerita Pencapaian
                    </p>

                    <h2>
                        Sebuah pencapaian yang membanggakan
                    </h2>
                </header>

                <div class="achievement-story-content">
                    {!! nl2br(e($achievement->description)) !!}
                </div>
            </article>
        </div>
    </section>

    <section
        class="achievement-closing-section"
        aria-labelledby="achievement-closing-title"
    >
        <div class="container">
            <div class="achievement-closing">
                <div>
                    <p class="achievement-closing-eyebrow">
                        Jejak Prestasi
                    </p>

                    <h2 id="achievement-closing-title">
                        Lihat pencapaian sekolah lainnya
                    </h2>

                    <p>
                        Jelajahi berbagai prestasi akademik dan non-akademik
                        SMA PGRI 1 Tulungagung.
                    </p>
                </div>

                <a
                    class="achievement-closing-link"
                    href="{{ route('achievements.index') }}"
                >
                    <span>Lihat Semua Prestasi</span>

                    <i
                        data-lucide="arrow-right"
                        aria-hidden="true"
                    ></i>
                </a>
            </div>
        </div>
    </section>
@endsection