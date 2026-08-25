@extends('layouts.app')

@section('title', 'Alumni')

@section('content')
    @php
        $alumniCount = $alumniHighlights->count();
    @endphp

    <section class="public-page-hero alumni-page-hero">
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
                    Jejak & Karya
                </span>

                <span aria-hidden="true">/</span>

                <span aria-current="page">
                    Alumni
                </span>
            </nav>

            <div class="alumni-hero-layout">
                <div class="alumni-hero-copy">
                    <p class="public-page-eyebrow">
                        Jejak Lulusan
                    </p>

                    <h1>
                        Cerita yang terus berjalan
                        <span>setelah kelulusan.</span>
                    </h1>

                    <p class="alumni-hero-description">
                        Mengenal perjalanan alumni pilihan dan menjaga
                        hubungan antara lulusan dengan almamater.
                    </p>

                    <div class="alumni-hero-actions">
                        @if ($alumniCount > 0)
                            <a
                                class="alumni-hero-primary-link"
                                href="#alumni-pilihan"
                            >
                                Lihat Alumni

                                <i
                                    data-lucide="arrow-down"
                                    aria-hidden="true"
                                ></i>
                            </a>
                        @endif

                        @if (filled($alumniFormUrl))
                            <a
                                class="alumni-hero-secondary-link"
                                href="{{ $alumniFormUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Isi Data Alumni

                                <i
                                    data-lucide="external-link"
                                    aria-hidden="true"
                                ></i>
                            </a>
                        @endif
                    </div>
                </div>

                @if ($alumniCount > 0)
                    <aside
                        class="alumni-hero-highlight"
                        aria-label="Informasi alumni pilihan"
                    >
                        <span
                            class="alumni-hero-highlight-icon"
                            aria-hidden="true"
                        >
                            <i data-lucide="graduation-cap"></i>
                        </span>

                        <div>
                            <strong>
                                {{ $alumniCount }}
                            </strong>

                            <span>Alumni Pilihan</span>

                            <p>
                                Cerita perjalanan lulusan yang
                                dibagikan melalui website sekolah.
                            </p>
                        </div>
                    </aside>
                @endif
            </div>
        </div>
    </section>

    <section
        id="alumni-pilihan"
        class="alumni-highlight-section"
    >
        <div class="container">
            <header class="alumni-section-heading">
                <div>

                    <h2>
                        Jejak Alumni Kami
                    </h2>
                </div>

                <p>
                    Setiap perjalanan memiliki cerita yang berbeda
                    setelah meninggalkan bangku sekolah.
                </p>
            </header>

            @if ($alumniHighlights->isNotEmpty())
                <div class="alumni-grid">
                    @foreach ($alumniHighlights as $alumni)
                        <x-alumni-card :alumni="$alumni" />
                    @endforeach
                </div>
            @else
                <div class="news-empty-state">
                    <span
                        class="news-empty-icon"
                        aria-hidden="true"
                    >
                        <i data-lucide="users"></i>
                    </span>

                    <h2>Alumni Pilihan Belum Tersedia</h2>

                    <p>
                        Profil alumni pilihan akan ditampilkan setelah
                        ditambahkan melalui panel admin.
                    </p>
                </div>
            @endif
        </div>
    </section>

    <section class="alumni-registration-section">
        <div class="container">
            <div class="alumni-registration-card">
                <div class="alumni-registration-content">
                    <p class="alumni-registration-eyebrow">
                        Pendataan Alumni
                    </p>

                    <h2>
                        Mari terhubung kembali
                        dengan almamater.
                    </h2>

                    <p>
                        Bantu sekolah memperbarui data alumni melalui
                        formulir resmi. Informasi yang dikirim dikelola
                        melalui Google Forms milik sekolah.
                    </p>
                </div>

                @if (filled($alumniFormUrl))
                    <a
                        class="alumni-registration-link"
                        href="{{ $alumniFormUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Isi Data Alumni

                        <i
                            data-lucide="external-link"
                            aria-hidden="true"
                        ></i>
                    </a>
                @else
                    <p class="alumni-registration-unavailable">
                        Formulir pendataan alumni belum tersedia.
                    </p>
                @endif
            </div>
        </div>
    </section>
@endsection