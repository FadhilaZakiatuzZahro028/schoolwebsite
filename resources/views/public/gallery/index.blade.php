@extends('layouts.app')

@section('title', 'Galeri Sekolah')

@section('content')
    <section class="public-page-hero gallery-page-hero">
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
                    Galeri
                </span>
            </nav>

            <p class="public-page-eyebrow">
                Dokumentasi Sekolah
            </p>

            <h1>Galeri Sekolah</h1>

            <p>
                Dokumentasi kegiatan, pembelajaran, prestasi, dan berbagai
                momen di lingkungan sekolah.
            </p>
        </div>
    </section>

    <section class="site-section gallery-index-section">
        <div class="container">
            @if ($galleryItems->isNotEmpty())
                <div class="gallery-index-heading">
                    <div>
                        <p class="latest-news-eyebrow">
                            Momen Sekolah
                        </p>

                        <h2>Dokumentasi Terbaru</h2>
                    </div>

                    <span>
                        {{ $galleryItems->total() }} foto
                    </span>
                </div>

                <div class="gallery-grid">
                    @foreach ($galleryItems as $galleryItem)
                        <x-gallery-item
                            :gallery-item="$galleryItem"
                        />
                    @endforeach
                </div>

                @if ($galleryItems->hasPages())
                    <div class="gallery-pagination">
                        {{ $galleryItems->links(
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
                        <i data-lucide="image"></i>
                    </span>

                    <h2>Belum Ada Foto</h2>

                    <p>
                        Dokumentasi sekolah akan ditampilkan setelah
                        ditambahkan melalui panel admin.
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