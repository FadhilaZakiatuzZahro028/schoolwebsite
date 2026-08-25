@extends('layouts.app')

@section('title', 'Berita Sekolah')

@section('content')
    <section class="public-page-hero news-page-hero">
        <div class="container">
            <nav
                class="news-page-breadcrumb"
                aria-label="Breadcrumb"
            >
                <a href="{{ route('home') }}">
                    Beranda
                </a>

                <span aria-hidden="true">/</span>

                <span aria-current="page">
                    Berita
                </span>
            </nav>

            <div class="news-page-heading">
                <div>
                    <p class="public-page-eyebrow">
                        Informasi Sekolah
                    </p>

                    <h1>Berita Sekolah</h1>

                    <p class="news-page-description">
                        Temukan kegiatan, pengumuman, dan informasi terbaru
                        dari lingkungan sekolah.
                    </p>
                </div>

                <div class="news-count-pill">
                    <i
                        data-lucide="newspaper"
                        aria-hidden="true"
                    ></i>

                    <strong>{{ $newsItems->total() }}</strong>

                    <span>Berita diterbitkan</span>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section news-index-section">
        <div class="container">
            @if ($newsItems->isNotEmpty())
                <div class="news-list-heading">
                    <div>
                        <p class="latest-news-eyebrow">
                            Informasi Terkini
                        </p>

                        <h2>Berita Terbaru</h2>
                    </div>

                    <span>
                        {{ $newsItems->total() }} artikel
                    </span>
                </div>

                <div class="news-compact-grid">
                    @foreach ($newsItems as $newsItem)
                        <x-news-card :news="$newsItem" />
                    @endforeach
                </div>

                @if ($newsItems->hasPages())
                    <div class="news-pagination">
                        {{ $newsItems->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="news-empty-state">
                    <span
                        class="news-empty-icon"
                        aria-hidden="true"
                    >
                        <i data-lucide="newspaper"></i>
                    </span>

                    <h2>Belum Ada Berita</h2>

                    <p>
                        Berita sekolah yang telah dipublikasikan akan
                        ditampilkan di halaman ini.
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