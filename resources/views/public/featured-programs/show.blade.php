@extends('layouts.app')

@section('title', $featuredProgram->name)

@section('content')

<section class="featured-program-detail-hero">
    <div class="container">

        <nav
            class="public-page-breadcrumb"
            aria-label="Breadcrumb"
        >
            <a href="{{ route('home') }}">
                Beranda
            </a>

            <span aria-hidden="true">/</span>

            <a href="{{ route('featured-programs.index') }}">
                Program Unggulan
            </a>

            <span aria-hidden="true">/</span>

            <span aria-current="page">
                {{ $featuredProgram->name }}
            </span>
        </nav>


        <div class="row align-items-center g-5">

            <div class="col-lg-7">

                <p class="public-page-eyebrow">
                    Program Unggulan
                </p>

                <h1>
                    {{ $featuredProgram->name }}
                </h1>

                <p class="featured-program-detail-summary">
                    {{ $featuredProgram->summary }}
                </p>

                <a
                    class="btn btn-site-primary"
                    href="#program-description"
                >
                    Pelajari Program
                </a>

            </div>


            <div class="col-lg-5">

                <figure class="featured-program-detail-image">
                    <img
                        src="{{ asset('storage/' . $featuredProgram->image) }}"
                        alt="{{ $featuredProgram->name }}"
                        loading="eager"
                    >
                </figure>

            </div>

        </div>

    </div>
</section>



<section
    id="program-description"
    class="site-section featured-program-detail-about"
>
    <div class="container">

        <div class="featured-program-detail-content">

            <p class="latest-news-eyebrow">
                Tentang Program
            </p>

            <h2>
                Mengembangkan Keterampilan Siswa
            </h2>


            <div class="featured-program-detail-text">

                {{ $featuredProgram->description }}

            </div>

        </div>

    </div>
</section>



@if ($featuredProgram->images->isNotEmpty())

<section class="site-section featured-program-detail-gallery">

    <div class="container">


        <header class="mb-4">

            <p class="latest-news-eyebrow">
                Dokumentasi Kegiatan
            </p>

            <h2>
                Aktivitas {{ $featuredProgram->name }}
            </h2>

        </header>



        <div class="featured-program-gallery-grid">

            @foreach ($featuredProgram->images as $image)

                <figure>

                    <img
                        src="{{ asset('storage/' . $image->image) }}"
                        alt="{{ $image->alt_text ?? $featuredProgram->name }}"
                        loading="lazy"
                    >

                </figure>

            @endforeach

        </div>


    </div>

</section>

@endif



<section class="site-section featured-program-detail-cta">

    <div class="container">

        <div class="featured-program-cta">

            <p class="latest-news-eyebrow">
                Bergabung Bersama Kami
            </p>


            <h2>
                Siapkan Masa Depan Melalui Program Unggulan
            </h2>


            <p>
                Dapatkan informasi pendaftaran dan kesempatan
                mengembangkan keterampilan bersama SMA PGRI 1 Tulungagung.
            </p>


            <div class="d-flex flex-wrap gap-3">

                <a
                    class="btn btn-site-primary"
                    href="{{ route('spmb.index') }}"
                >
                    Informasi SPMB
                </a>


                <a
                    class="btn btn-outline-primary"
                    href="{{ route('featured-programs.index') }}"
                >
                    Program Lainnya
                </a>

            </div>

        </div>

    </div>

</section>


@endsection