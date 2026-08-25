@extends('layouts.app')

@section('title', 'Kontak')

@php
    $phoneHref = filled($schoolProfile?->phone)
        ? preg_replace('/[^0-9+]/', '', $schoolProfile->phone)
        : null;

    $mapsSrc = null;

    if (filled($schoolProfile?->maps_embed)) {
        preg_match(
            '/src=["\']([^"\']+)["\']/i',
            $schoolProfile->maps_embed,
            $matches,
        );

        $mapsSrc = $matches[1] ?? null;
    }
@endphp

@section('content')
    <section class="public-page-hero contact-page-hero">
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
                    Kontak
                </span>
            </nav>

            <div class="contact-hero-content">
                <p class="public-page-eyebrow">
                    Hubungi Sekolah
                </p>

                <h1>
                    Ada yang ingin
                    <span>ditanyakan?</span>
                </h1>

                <p class="contact-hero-description">
                    Hubungi SMA PGRI 1 Tulungagung melalui saluran
                    resmi, kunjungi lokasi sekolah, atau kirim pesan
                    langsung melalui formulir yang tersedia.
                </p>

                <div class="contact-hero-actions">
                    <a
                        class="contact-hero-primary"
                        href="#form-kontak"
                    >
                        Kirim Pesan

                        <i
                            data-lucide="send"
                            aria-hidden="true"
                        ></i>
                    </a>

                    @if ($mapsSrc)
                        <a
                            class="contact-hero-secondary"
                            href="#lokasi-sekolah"
                        >
                            Lihat Lokasi

                            <i
                                data-lucide="map-pin"
                                aria-hidden="true"
                            ></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="contact-hub-section">
        <div class="container">
            @if (session('success'))
                <div
                    class="alert alert-success contact-alert"
                    role="status"
                >
                    <i
                        data-lucide="circle-check"
                        aria-hidden="true"
                    ></i>

                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="contact-layout">
                <section
                    class="contact-information-panel"
                    aria-labelledby="contact-information-title"
                >
                    <header class="contact-section-heading">
                        <p class="latest-news-eyebrow">
                            Informasi Resmi
                        </p>

                        <h2 id="contact-information-title">
                            Terhubung dengan sekolah
                        </h2>

                        <p>
                            Gunakan informasi resmi berikut jika Anda
                            ingin menghubungi atau mengunjungi sekolah.
                        </p>
                    </header>

                    @if (
                        filled($schoolProfile?->address)
                        || $phoneHref
                        || filled($schoolProfile?->email)
                    )
                        <div class="contact-information-list">
                            @if (filled($schoolProfile?->address))
                                <article class="contact-information-item">
                                    <span
                                        class="contact-information-icon"
                                        aria-hidden="true"
                                    >
                                        <i data-lucide="map-pin"></i>
                                    </span>

                                    <div>
                                        <h3>Alamat Sekolah</h3>

                                        <p>
                                            {{ $schoolProfile->address }}
                                        </p>
                                    </div>
                                </article>
                            @endif

                            @if ($phoneHref)
                                <article class="contact-information-item">
                                    <span
                                        class="contact-information-icon"
                                        aria-hidden="true"
                                    >
                                        <i data-lucide="phone"></i>
                                    </span>

                                    <div>
                                        <h3>Telepon</h3>

                                        <a href="tel:{{ $phoneHref }}">
                                            {{ $schoolProfile->phone }}
                                        </a>
                                    </div>
                                </article>
                            @endif

                            @if (filled($schoolProfile?->email))
                                <article class="contact-information-item">
                                    <span
                                        class="contact-information-icon"
                                        aria-hidden="true"
                                    >
                                        <i data-lucide="mail"></i>
                                    </span>

                                    <div>
                                        <h3>Email</h3>

                                        <a
                                            href="mailto:{{ $schoolProfile->email }}"
                                        >
                                            {{ $schoolProfile->email }}
                                        </a>
                                    </div>
                                </article>
                            @endif
                        </div>
                    @else
                        <div class="contact-information-empty">
                            <h3>
                                Informasi Kontak Belum Tersedia
                            </h3>

                            <p>
                                Informasi kontak sekolah akan
                                ditampilkan setelah dikonfigurasi
                                melalui panel admin.
                            </p>
                        </div>
                    @endif

                    <div
                        id="lokasi-sekolah"
                        class="contact-map-area"
                    >
                        <div class="contact-map-heading">
                            <div>
                                <p class="latest-news-eyebrow">
                                    Lokasi Sekolah
                                </p>

                                <h3>Temukan kami</h3>
                            </div>
                        </div>

                        @if ($mapsSrc)
                            <div class="contact-map">
                                <iframe
                                    src="{{ $mapsSrc }}"
                                    title="Lokasi {{ $schoolProfile?->school_name ?? config('app.name') }}"
                                    loading="lazy"
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        @else
                            <div class="contact-map-empty">
                                <i
                                    data-lucide="map"
                                    aria-hidden="true"
                                ></i>

                                <p>
                                    Peta lokasi belum tersedia.
                                </p>
                            </div>
                        @endif
                    </div>
                </section>

                <section
                    id="form-kontak"
                    class="contact-form-panel"
                    aria-labelledby="contact-form-title"
                >
                    <header class="contact-form-heading">
                        <p class="latest-news-eyebrow">
                            Form Hubungi Kami
                        </p>

                        <h2 id="contact-form-title">
                            Kirim pesan
                        </h2>

                        <p>
                            Lengkapi formulir berikut dan pesan Anda
                            akan diteruskan ke panel admin sekolah.
                        </p>
                    </header>

                    @if ($errors->any())
                        <div
                            class="alert alert-danger contact-alert"
                            role="alert"
                        >
                            <i
                                data-lucide="circle-alert"
                                aria-hidden="true"
                            ></i>

                            <div>
                                <strong>
                                    Pesan belum dapat dikirim.
                                </strong>

                                <span>
                                    Periksa kembali data yang ditandai.
                                </span>
                            </div>
                        </div>
                    @endif

                    <form
                        class="contact-form"
                        action="{{ route('contact.store') }}"
                        method="POST"
                    >
                        @csrf

                        <div class="contact-form-grid">
                            <div class="contact-form-field">
                                <label for="contact-name">
                                    Nama Lengkap
                                    <span aria-hidden="true">*</span>
                                </label>

                                <input
                                    id="contact-name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    maxlength="255"
                                    autocomplete="name"
                                    required
                                >

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="contact-form-field">
                                <label for="contact-email">
                                    Email
                                    <span aria-hidden="true">*</span>
                                </label>

                                <input
                                    id="contact-email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    maxlength="255"
                                    autocomplete="email"
                                    required
                                >

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="contact-form-field">
                                <label for="contact-phone">
                                    Nomor HP

                                    <span class="contact-optional">
                                        Opsional
                                    </span>
                                </label>

                                <input
                                    id="contact-phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    type="tel"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    maxlength="30"
                                    autocomplete="tel"
                                    inputmode="tel"
                                    placeholder="Contoh: 0812 3456 7890"
                                >

                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="contact-form-field">
                                <label for="contact-subject">
                                    Topik Pesan
                                    <span aria-hidden="true">*</span>
                                </label>

                                <input
                                    id="contact-subject"
                                    class="form-control @error('subject') is-invalid @enderror"
                                    type="text"
                                    name="subject"
                                    value="{{ old('subject') }}"
                                    maxlength="255"
                                    placeholder="Contoh: Informasi SPMB"
                                    required
                                >

                                <div class="contact-field-help">
                                    Tuliskan singkat tujuan pesan Anda.
                                </div>

                                @error('subject')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div
                                class="contact-form-field
                                    contact-form-field-full"
                            >
                                <label for="contact-message">
                                    Pesan
                                    <span aria-hidden="true">*</span>
                                </label>

                                <textarea
                                    id="contact-message"
                                    class="form-control @error('message') is-invalid @enderror"
                                    name="message"
                                    rows="5"
                                    minlength="10"
                                    maxlength="5000"
                                    required
                                >{{ old('message') }}</textarea>

                                <div class="contact-field-help">
                                    Minimal 10 dan maksimal
                                    5.000 karakter.
                                </div>

                                @error('message')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <button
                            class="contact-submit-button"
                            type="submit"
                        >
                            Kirim Pesan

                            <i
                                data-lucide="send"
                                aria-hidden="true"
                            ></i>
                        </button>
                    </form>
                </section>
            </div>
        </div>
    </section>

    @if (
        $phoneHref
        || filled($schoolProfile?->email)
    )
        <section class="contact-closing-section">
            <div class="container">
                <div class="contact-closing">
                    <div>
                        <p class="latest-news-eyebrow">
                            Saluran Resmi
                        </p>

                        <h2>
                            Pilih cara yang paling nyaman
                            untuk menghubungi sekolah.
                        </h2>
                    </div>

                    <div class="contact-closing-actions">
                        @if ($phoneHref)
                            <a href="tel:{{ $phoneHref }}">
                                <i
                                    data-lucide="phone"
                                    aria-hidden="true"
                                ></i>

                                Telepon Sekolah
                            </a>
                        @endif

                        @if (filled($schoolProfile?->email))
                            <a
                                href="mailto:{{ $schoolProfile->email }}"
                            >
                                <i
                                    data-lucide="mail"
                                    aria-hidden="true"
                                ></i>

                                Kirim Email
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection