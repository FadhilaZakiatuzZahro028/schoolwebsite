@extends('layouts.app')

@section('title', $facility->name)

@section('content')
<section
    class="
        public-page-hero
        facility-page-hero
        facility-detail-hero
    "
>        <div class="container">
            <nav
                class="public-page-breadcrumb"
                aria-label="Breadcrumb"
            >
                <a href="{{ route('home') }}">
                    Beranda
                </a>

                <span aria-hidden="true">/</span>

                <a href="{{ route('facilities.index') }}">
                    Fasilitas
                </a>

                <span aria-hidden="true">/</span>

                <span aria-current="page">
                    {{ $facility->name }}
                </span>
            </nav>

            <p class="public-page-eyebrow">
                Fasilitas Sekolah
            </p>

            <h1>{{ $facility->name }}</h1>

            <p>
                Mengenal sarana sekolah yang mendukung kegiatan
                belajar, berkarya, dan pengembangan siswa.
            </p>
        </div>
    </section>

    <section class="facility-detail-section">
        <div class="container">
            <article class="facility-detail-shell">
                <div class="facility-detail-showcase">
                    <div class="facility-detail-gallery">
                        <div
                            id="facilityGalleryCarousel"
                            class="carousel slide facility-gallery-carousel"
                            data-bs-interval="false"
                        >
                            <div class="carousel-inner">
                                @foreach ($galleryImages as $galleryImage)
                                    <div
                                        class="
                                            carousel-item
                                            {{ $loop->first ? 'active' : '' }}
                                        "
                                    >
                                        <button
                                            class="facility-detail-main-media"
                                            type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#facilityImageModal{{ $loop->index }}"
                                            aria-label="Perbesar foto {{ $galleryImage['alt'] }}"
                                        >
                                            <img
                                                class="facility-detail-main-image"
                                                src="{{ asset('storage/' . $galleryImage['image']) }}"
                                                alt="{{ $galleryImage['alt'] }}"
                                                width="960"
                                                height="600"
                                                {{ $loop->first ? '' : 'loading=lazy' }}
                                            >

                                            <span class="facility-detail-zoom">
                                                <i
                                                    data-lucide="maximize-2"
                                                    aria-hidden="true"
                                                ></i>

                                                <span>Perbesar</span>
                                            </span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            @if ($galleryImages->count() > 1)
                                <div
                                    class="carousel-indicators facility-detail-thumbnails"
                                    aria-label="Pilih foto fasilitas"
                                >
                                    @foreach ($galleryImages as $galleryImage)
                                        <button
                                            type="button"
                                            data-bs-target="#facilityGalleryCarousel"
                                            data-bs-slide-to="{{ $loop->index }}"
                                            class="{{ $loop->first ? 'active' : '' }}"
                                            {{ $loop->first ? 'aria-current=true' : '' }}
                                            aria-label="Tampilkan foto {{ $loop->iteration }}"
                                        >
                                            <img
                                                src="{{ asset('storage/' . $galleryImage['image']) }}"
                                                alt=""
                                                width="180"
                                                height="110"
                                                loading="lazy"
                                            >
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="facility-detail-copy">
                        <div class="facility-detail-copy-heading">
                            <span
                                class="facility-detail-copy-icon"
                                aria-hidden="true"
                            >
                                <i data-lucide="building-2"></i>
                            </span>

                            <div>
                                <p class="facility-detail-kicker">
                                    Tentang Fasilitas
                                </p>

                                <h2>
                                    Mengenal {{ $facility->name }}
                                </h2>
                            </div>
                        </div>

                        <div class="facility-detail-description">
                            {!! nl2br(e($facility->description)) !!}
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="facility-detail-closing">
        <div class="container">
            <div class="facility-detail-closing-inner">
                <span
                    class="facility-detail-closing-icon"
                    aria-hidden="true"
                >
                    <i data-lucide="school"></i>
                </span>

                <div class="facility-detail-closing-copy">
                    <p class="facility-detail-closing-eyebrow">
                        Sarana & Prasarana
                    </p>

                    <h2>Temukan Fasilitas Lainnya</h2>

                    <p>
                        Jelajahi berbagai fasilitas yang mendukung
                        aktivitas siswa di lingkungan sekolah.
                    </p>
                </div>

                <a
                    class="btn btn-site-primary"
                    href="{{ route('facilities.index') }}"
                >
                    Lihat Semua Fasilitas

                    <i
                        data-lucide="arrow-right"
                        aria-hidden="true"
                    ></i>
                </a>
            </div>
        </div>
    </section>

    @foreach ($galleryImages as $galleryImage)
        <div
            class="modal fade facility-image-modal"
            id="facilityImageModal{{ $loop->index }}"
            tabindex="-1"
            aria-hidden="true"
        >
            <div
                class="
                    modal-dialog
                    modal-dialog-centered
                    modal-xl
                "
            >
                <div class="modal-content">
                    <div class="modal-body">
                        <button
                            type="button"
                            class="btn-close facility-image-modal-close"
                            data-bs-dismiss="modal"
                            aria-label="Tutup"
                        ></button>

                        <img
                            src="{{ asset('storage/' . $galleryImage['image']) }}"
                            alt="{{ $galleryImage['alt'] }}"
                            width="1440"
                            height="900"
                        >
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection