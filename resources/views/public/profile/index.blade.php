@extends('layouts.app')

@section('title', 'Profil Sekolah')

@section('content')
    <section class="public-page-hero profile-page-hero">
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
                Profil Sekolah
            </span>
        </nav>

        <div class="profile-hero-layout">
            <div class="profile-hero-copy">
                <p class="public-page-eyebrow">
                    Tentang Sekolah
                </p>

                <h1>Profil Sekolah</h1>

                <p class="profile-hero-description">
                    Mengenal lebih dekat identitas, arah pendidikan,
                    dan lingkungan SMA PGRI 1 Tulungagung.
                </p>

                <span
                    class="profile-hero-accent"
                    aria-hidden="true"
                ></span>
            </div>

            @if ($schoolProfile !== null)
                <div class="profile-hero-identity">
                    <div
                        class="profile-hero-orbit"
                        aria-hidden="true"
                    ></div>

                    @if (filled($schoolProfile->logo))
                        <img
                            class="profile-hero-logo"
                            src="{{ \Illuminate\Support\Facades\Storage::url(
                                $schoolProfile->logo
                            ) }}"
                            alt="Logo {{ $schoolProfile->school_name }}"
                            width="180"
                            height="180"
                        >
                    @else
                        <span
                            class="profile-hero-logo-placeholder"
                            aria-hidden="true"
                        >
                            <i data-lucide="school"></i>
                        </span>
                    @endif

                    @if (filled($schoolProfile->school_name))
                        <p class="profile-hero-school-name">
                            {{ $schoolProfile->school_name }}
                        </p>
                    @endif

                    @if (filled($schoolProfile->tagline))
                        <p class="profile-hero-tagline">
                            {{ $schoolProfile->tagline }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>

    <section class="site-section profile-page-section">
        <div class="container">
            @if ($schoolProfile !== null)
                <div class="profile-identity">
                    @if (filled($schoolProfile->logo))
                        <img
                            class="profile-identity-logo"
                            src="{{ \Illuminate\Support\Facades\Storage::url(
                                $schoolProfile->logo
                            ) }}"
                            alt="Logo {{ $schoolProfile->school_name }}"
                            width="180"
                            height="180"
                        >
                    @endif

                    <div>
                        <p class="latest-news-eyebrow">
                            Identitas Sekolah
                        </p>

                        <h2>
                            {{ $schoolProfile->school_name }}
                        </h2>

                        <p class="profile-tagline">
                            {{ $schoolProfile->tagline }}
                        </p>

                        <dl class="profile-contact-list">
                            <div>
                                <dt>Alamat</dt>
                                <dd>{{ $schoolProfile->address }}</dd>
                            </div>

                            <div>
                                <dt>Telepon</dt>
                                <dd>{{ $schoolProfile->phone }}</dd>
                            </div>

                            <div>
                                <dt>Email</dt>
                                <dd>{{ $schoolProfile->email }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="profile-values-grid">
                    <article class="profile-content-card">
                        <p class="latest-news-eyebrow">
                            Arah Sekolah
                        </p>

                        <h2>Visi</h2>

                        <div class="profile-rich-text">
                            {!! nl2br(e($schoolProfile->vision)) !!}
                        </div>
                    </article>

                    <article class="profile-content-card">
                        <p class="latest-news-eyebrow">
                            Langkah Strategis
                        </p>

                        <h2>Misi</h2>

                        <div class="profile-rich-text">
                            {!! nl2br(e($schoolProfile->mission)) !!}
                        </div>
                    </article>
                </div>

                <article class="profile-principal-section">
                    <div class="profile-principal-photo-wrap">
                        @if (filled($principalPhoto))
                            <img
                                class="profile-principal-photo"
                                src="{{ \Illuminate\Support\Facades\Storage::url(
                                    $principalPhoto
                                ) }}"
                                alt="Kepala sekolah {{ $schoolProfile->principal_name }}"
                                width="520"
                                height="640"
                                loading="lazy"
                            >
                        @else
                            <div
                                class="profile-principal-placeholder"
                                aria-hidden="true"
                            >
                                {{ mb_substr(
                                    $schoolProfile->principal_name,
                                    0,
                                    1,
                                ) }}
                            </div>
                        @endif
                    </div>

                    <div class="profile-principal-content">
                        <p class="latest-news-eyebrow">
                            Sambutan Kepala Sekolah
                        </p>

                        <h2>
                            {{ $schoolProfile->principal_name }}
                        </h2>

                        <div class="profile-rich-text">
                            {!! nl2br(e(
                                $schoolProfile->principal_message
                            )) !!}
                        </div>
                    </div>
                </article>
            @else
                <div class="news-empty-state">
                    <h2>Profil Sekolah Belum Tersedia</h2>

                    <p>
                        Informasi profil sekolah akan ditampilkan setelah
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