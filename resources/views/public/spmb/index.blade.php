@extends('layouts.app')

@section('title', 'SPMB')

@section('content')
    @php
        $availableDocuments = $spmbSetting
            ? collect([
                $spmbSetting->information_file,
                $spmbSetting->brochure_file,
            ])->filter(
                fn ($path) => filled($path)
            )->count()
            : 0;
    @endphp

    <section class="public-page-hero spmb-page-hero">
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
                    Informasi
                </span>

                <span aria-hidden="true">/</span>

                <span aria-current="page">
                    SPMB
                </span>
            </nav>

            <div class="spmb-gateway-hero">
                <div class="spmb-gateway-copy">
                    <p class="public-page-eyebrow">
                        Penerimaan Murid Baru
                    </p>

                    <h1>
                        Mulai langkah menuju
                        <span>SMA PGRI 1 Tulungagung.</span>
                    </h1>

                    <p class="spmb-gateway-description">
                        Temukan informasi penerimaan murid baru,
                        dokumen resmi, dan akses untuk menghubungi
                        sekolah dalam satu halaman.
                    </p>

                    <div class="spmb-gateway-actions">
                        <a
                            class="btn btn-site-primary"
                            href="#informasi-spmb"
                        >
                            Lihat Informasi

                            <i
                                data-lucide="arrow-down"
                                aria-hidden="true"
                            ></i>
                        </a>

                        <a
                            class="btn btn-site-secondary"
                            href="{{ route('contact.index') }}"
                        >
                            Hubungi Sekolah

                            <i
                                data-lucide="message-circle"
                                aria-hidden="true"
                            ></i>
                        </a>
                    </div>

                    @if ($availableDocuments > 0)
                        <div class="spmb-gateway-document-status">
                            <span
                                class="spmb-gateway-document-icon"
                                aria-hidden="true"
                            >
                                <i data-lucide="file-check-2"></i>
                            </span>

                            <p>
                                <strong>
                                    {{ $availableDocuments }}
                                    {{ $availableDocuments === 1
                                        ? 'dokumen'
                                        : 'dokumen' }}
                                </strong>

                                resmi tersedia untuk diunduh
                            </p>
                        </div>
                    @endif
                </div>

                <aside
                    class="spmb-gateway-guide"
                    aria-label="Alur informasi SPMB"
                >
                    <p class="spmb-gateway-guide-eyebrow">
                        Alur Cepat
                    </p>

                    <ol class="spmb-gateway-steps">
                        <li>
                            <span>01</span>

                            <div>
                                <strong>
                                    Baca informasi
                                </strong>

                                <p>
                                    Pahami keterangan penerimaan
                                    yang disampaikan sekolah.
                                </p>
                            </div>
                        </li>

                        <li>
                            <span>02</span>

                            <div>
                                <strong>
                                    Unduh dokumen
                                </strong>

                                <p>
                                    Simpan file informasi atau
                                    brosur resmi jika tersedia.
                                </p>
                            </div>
                        </li>

                        <li>
                            <span>03</span>

                            <div>
                                <strong>
                                    Hubungi sekolah
                                </strong>

                                <p>
                                    Tanyakan informasi yang masih
                                    perlu dikonfirmasi.
                                </p>
                            </div>
                        </li>
                    </ol>
                </aside>
            </div>
        </div>
    </section>

    <main class="spmb-content">
        @if ($spmbSetting)
            <section
                id="informasi-spmb"
                class="spmb-information-section"
            >
                <div class="container">
                    <div class="spmb-information-layout">
                        <header class="spmb-information-heading">
                            <p class="latest-news-eyebrow">
                                Informasi Pendaftaran
                            </p>

                            <h2>
                                Sistem Penerimaan
                                Murid Baru
                            </h2>

                            <p>
                                Informasi utama yang perlu
                                diperhatikan sebelum melanjutkan
                                proses penerimaan.
                            </p>
                        </header>

                        <div class="spmb-information-body">
                            @if (filled($spmbSetting->description))
                                <div class="spmb-description">
                                    {!! nl2br(e(
                                        $spmbSetting->description
                                    )) !!}
                                </div>
                            @else
                                <p class="spmb-description-empty">
                                    Keterangan SPMB belum tersedia.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            @if ($availableDocuments > 0)
                <section
                    id="dokumen-spmb"
                    class="spmb-documents-section"
                >
                    <div class="container">
                        <header class="spmb-download-heading">
                            <div>
                                <p class="latest-news-eyebrow">
                                    Dokumen Resmi
                                </p>

                                <h2>
                                    Informasi yang dapat
                                    kamu simpan.
                                </h2>
                            </div>

                            <p>
                                Unduh dokumen resmi yang tersedia
                                untuk membaca informasi SPMB
                                dengan lebih lengkap.
                            </p>
                        </header>

                        <div class="spmb-download-grid">
                            @if (
                                filled(
                                    $spmbSetting->information_file
                                )
                            )
                                <x-download-card
                                    title="File Informasi SPMB"
                                    description="Dokumen informasi resmi mengenai alur, persyaratan, jadwal, atau ketentuan SPMB."
                                    :file-path="$spmbSetting->information_file"
                                    :preview-path="$spmbSetting->information_preview"
                                    download-label="Unduh File Informasi"
                                />
                            @endif

                            @if (
                                filled(
                                    $spmbSetting->brochure_file
                                )
                            )
                                <x-download-card
                                    title="Brosur SPMB"
                                    description="Brosur resmi yang berisi ringkasan informasi penerimaan murid baru."
                                    :file-path="$spmbSetting->brochure_file"
                                    :preview-path="$spmbSetting->brochure_preview"
                                    download-label="Unduh Brosur"
                                />
                            @endif
                        </div>
                    </div>
                </section>
            @endif

            <section class="spmb-closing-section">
                <div class="container">
                    <div class="spmb-closing">
                        <div>
                            <p class="latest-news-eyebrow">
                                Butuh Informasi Lain?
                            </p>

                            <h2>
                                Kami siap membantu
                                menjawab pertanyaanmu.
                            </h2>

                            <p>
                                Hubungi sekolah jika ada informasi
                                SPMB yang masih perlu dikonfirmasi.
                            </p>
                        </div>

                        <a
                            class="spmb-closing-link"
                            href="{{ route('contact.index') }}"
                        >
                            Hubungi Sekolah

                            <i
                                data-lucide="arrow-right"
                                aria-hidden="true"
                            ></i>
                        </a>
                    </div>
                </div>
            </section>
        @else
            <section class="site-section spmb-index-section">
                <div class="container">
                    <div class="news-empty-state">
                        <span
                            class="news-empty-icon"
                            aria-hidden="true"
                        >
                            <i data-lucide="graduation-cap"></i>
                        </span>

                        <h2>
                            Informasi SPMB Belum Tersedia
                        </h2>

                        <p>
                            Informasi penerimaan murid baru akan
                            ditampilkan setelah dikonfigurasi
                            melalui panel admin.
                        </p>

                        <a
                            class="btn btn-site-primary"
                            href="{{ route('home') }}"
                        >
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection