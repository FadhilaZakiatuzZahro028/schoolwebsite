@extends('layouts.app')

@section('title', 'Data Karyawan')

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
                    Data Karyawan
                </span>
            </nav>

            <p class="public-page-eyebrow">
                Tenaga Kependidikan
            </p>

            <h1>Data Karyawan</h1>

            <p>
                Tenaga kependidikan yang mendukung pelayanan,
                administrasi, dan operasional sekolah.
            </p>
        </div>
    </section>

    <section class="site-section staff-index-section">
        <div class="container">
            @if ($employees->isNotEmpty())
                <div class="staff-index-heading">
                    <div>
                        <p class="latest-news-eyebrow">
                            Tenaga Kependidikan
                        </p>

                        <h2>Daftar Karyawan</h2>
                    </div>

                    <span>
                        {{ $employees->count() }} karyawan
                    </span>
                </div>

                <x-staff-carousel
    :staff-members="$employees"
    :initial-index="0"
/>

            @else
                <div class="news-empty-state">
                    <h2>Data Karyawan Belum Tersedia</h2>

                    <p>
                        Informasi tenaga kependidikan akan ditampilkan
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