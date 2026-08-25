@extends('layouts.app')

@section('title', 'Sejarah Sekolah')

@section('content')
    <section class="public-page-hero history-page-hero">
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
                    Sejarah
                </span>
            </nav>

            <div class="history-hero-layout">
                <div class="history-hero-copy">
                    <p class="public-page-eyebrow">
                        Jejak Perjalanan
                    </p>

                    <h1>Sejarah Sekolah</h1>

                    <p class="history-hero-description">
                        Menelusuri perjalanan sekolah dari masa awal,
                        bertumbuh bersama masyarakat, hingga terus
                        melangkah menuju masa depan.
                    </p>
                </div>

                <div
                    class="history-hero-visual"
                    aria-hidden="true"
                >
                    <div class="history-hero-track">
                        <span class="history-hero-year">
                            19XX
                        </span>

                        <span class="history-hero-line"></span>

                        <span class="history-hero-dot"></span>

                        <span class="history-hero-line"></span>

                        <span class="history-hero-year history-hero-year--current">
                            Kini
                        </span>
                    </div>

                    <p>Perjalanan dari masa ke masa</p>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section history-page-section">
        <div class="container">
            @if ($schoolProfile !== null)
                @php
                    $historyMilestones = [
                        [
                            'id' => 'awal-perjalanan',
                            'year' => '19XX',
                            'title' => 'Awal Perjalanan',
                            'description' => 'Perjalanan sekolah dimulai dari semangat menghadirkan ruang belajar yang dekat dengan masyarakat dan memberi kesempatan bagi generasi muda untuk terus berkembang.',
                            'media_label' => 'Foto arsip masa awal sekolah',
                        ],
                        [
                            'id' => 'masa-perkembangan',
                            'year' => '20XX',
                            'title' => 'Masa Perkembangan',
                            'description' => 'Seiring waktu, sekolah terus bertumbuh melalui penguatan kegiatan pembelajaran, pengembangan lingkungan sekolah, serta keterlibatan guru dan peserta didik.',
                            'media_label' => 'Foto perkembangan sekolah',
                        ],
                        [
                            'id' => 'transformasi-pendidikan',
                            'year' => '20XX',
                            'title' => 'Transformasi Pendidikan',
                            'description' => 'Perubahan kebutuhan pendidikan mendorong sekolah untuk terus beradaptasi, memperkuat proses belajar, dan menghadirkan pengalaman pendidikan yang semakin relevan.',
                            'media_label' => 'Dokumentasi kegiatan sekolah',
                        ],
                        [
                            'id' => 'masa-kini',
                            'year' => 'Kini',
                            'title' => 'Melangkah ke Masa Depan',
                            'description' => 'Perjalanan belum berhenti. Nilai, pengalaman, dan semangat yang tumbuh dari masa ke masa menjadi bekal sekolah untuk terus berkembang dan memberi manfaat bagi generasi berikutnya.',
                            'media_label' => 'Dokumentasi sekolah masa kini',
                        ],
                    ];
                @endphp

                <div class="history-intro">
                    <div>
                        <p class="latest-news-eyebrow">
                            Dari Masa ke Masa
                        </p>

                        <h2>
                            Perjalanan {{ $schoolProfile->school_name }}
                        </h2>
                    </div>

                    @if (filled($schoolProfile->history))
    <p>
        {{ $schoolProfile->history }}
    </p>
@else
    <p>
        Setiap masa meninggalkan cerita. Perjalanan sekolah
        akan terus berkembang bersama masyarakat dan generasi
        penerus.
    </p>
@endif
                </div>

                <nav
                    class="history-year-nav"
                    aria-label="Navigasi periode sejarah"
                >
                    @foreach ($historyMilestones as $milestone)
                        <a href="#{{ $milestone['id'] }}">
                            <span>{{ $milestone['year'] }}</span>
                            <small>{{ $milestone['title'] }}</small>
                        </a>
                    @endforeach
                </nav>

                <div class="history-timeline">
                    @foreach ($historyMilestones as $milestone)
                        <article
                            id="{{ $milestone['id'] }}"
                            class="history-timeline-item {{ $loop->even ? 'history-timeline-item--reverse' : '' }}"
                        >
                            <div class="history-timeline-media">
                                <div class="history-archive-placeholder">
                                    <i
                                        data-lucide="image"
                                        aria-hidden="true"
                                    ></i>

                                    <span>
                                        {{ $milestone['media_label'] }}
                                    </span>

                                    <small>
                                        Dokumentasi akan ditambahkan
                                    </small>
                                </div>
                            </div>

                            <div
                                class="history-timeline-marker"
                                aria-hidden="true"
                            >
                                <span></span>
                            </div>

                            <div class="history-timeline-content">
                                <span class="history-timeline-year">
                                    {{ $milestone['year'] }}
                                </span>

                                <h3>
                                    {{ $milestone['title'] }}
                                </h3>

                                <p>
                                    {{ $milestone['description'] }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="history-closing">
                    <p class="latest-news-eyebrow">
                        Perjalanan Berlanjut
                    </p>

                    <h2>
                        Menjaga Jejak, Menatap Masa Depan
                    </h2>

                    <p>
                        Sejarah bukan hanya tentang apa yang telah
                        dilewati, tetapi juga menjadi pijakan untuk
                        menentukan langkah berikutnya.
                    </p>

                    <a
                        class="home-section-action"
                        href="{{ route('profile.index') }}"
                    >
                        Lihat Profil Sekolah

                        <i
                            data-lucide="arrow-right"
                            aria-hidden="true"
                        ></i>
                    </a>
                </div>
            @else
                <div class="news-empty-state">
                    <h2>Sejarah Sekolah Belum Tersedia</h2>

                    <p>
                        Informasi sejarah sekolah akan ditampilkan setelah
                        dikonfigurasi melalui panel admin.
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