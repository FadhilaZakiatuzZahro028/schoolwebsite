@extends('layouts.app')

@section('title', 'Data Guru')

@section('content')
    <section class="public-page-hero staff-page-hero">
        <div class="container">
            <nav
                class="public-page-breadcrumb"
                aria-label="Breadcrumb"
            >
                <a href="{{ route('home') }}">
                    Beranda
                </a>

                <span aria-hidden="true">/</span>

                <a href="{{ route('profile.index') }}">
                    Profil
                </a>

                <span aria-hidden="true">/</span>

                <span aria-current="page">
                    Data Guru
                </span>
            </nav>

            <p class="public-page-eyebrow">
                Tenaga Pendidik
            </p>

            <h1>Data Guru</h1>

            <p>
                Tenaga pendidik yang mendukung kegiatan pembelajaran
                dan perkembangan peserta didik.
            </p>
        </div>
    </section>

    <section class="site-section staff-index-section">
        <div class="container">
            @if ($teachers->isNotEmpty())
                <div class="staff-index-heading">
                    <div>
                        <p class="latest-news-eyebrow">
                            Tenaga Pendidik
                        </p>

                        <h2>Daftar Guru</h2>
                    </div>

                    <span>
                        {{ $teachers->count() }} guru
                    </span>
                </div>

    <x-staff-carousel
    :staff-members="$teachers"
    :initial-index="0"
/>

            @else
                <div class="news-empty-state">
                    <h2>Data Guru Belum Tersedia</h2>

                    <p>
                        Informasi tenaga pendidik akan ditampilkan setelah
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