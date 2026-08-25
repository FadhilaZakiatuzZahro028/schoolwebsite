@extends('layouts.app')

@section('title', 'Prestasi Sekolah')

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

                <span aria-current="page">
                    Prestasi
                </span>
            </nav>

            <p class="public-page-eyebrow">
                Jejak & Karya
            </p>

            <h1>Prestasi Sekolah</h1>

            <p>
                Dokumentasi pencapaian dan penghargaan yang diraih oleh
                warga sekolah pada berbagai tingkatan.
            </p>
        </div>
    </section>

    <section class="site-section achievement-index-section">
        <div class="container">
            @if ($achievements->isNotEmpty())
                <div class="achievement-index-heading">
                    <div>
                        <p class="latest-news-eyebrow">
                            Pencapaian Sekolah
                        </p>

                        <h2>Daftar Prestasi</h2>
                    </div>

                    <span>
                        {{ $achievements->total() }} prestasi
                    </span>
                </div>

                <div class="achievement-grid achievement-index-grid">
                    @foreach ($achievements as $achievement)
                        <x-achievement-card
                            :achievement="$achievement"
                        />
                    @endforeach
                </div>

                @if ($achievements->hasPages())
                    <div class="achievement-pagination">
                        {{ $achievements->links(
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
                        <i data-lucide="trophy"></i>
                    </span>

                    <h2>Belum Ada Prestasi</h2>

                    <p>
                        Data prestasi sekolah akan ditampilkan setelah
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