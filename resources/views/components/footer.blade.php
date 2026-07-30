@props([
    'schoolProfile' => null,
    'siteSetting' => null,
])

@php
    $brandName = $schoolProfile?->school_name
        ?? $siteSetting?->site_name
        ?? config('app.name');

    $brandInitials = collect(preg_split('/\s+/', $brandName))
        ->filter()
        ->take(2)
        ->map(fn (string $word): string => mb_substr($word, 0, 1))
        ->implode('');

    $logoUrl = $schoolProfile?->logo
        ? \Illuminate\Support\Facades\Storage::url($schoolProfile->logo)
        : null;

    $phoneHref = filled($schoolProfile?->phone)
        ? preg_replace('/[^0-9+]/', '', $schoolProfile->phone)
        : null;

    $mapsSrc = null;

    if (filled($schoolProfile?->maps_embed)) {
        preg_match(
            '/src=["\']([^"\']+)["\']/i',
            $schoolProfile->maps_embed,
            $matches
        );

        $mapsSrc = $matches[1] ?? null;
    }

    $footerQuoteSource = $schoolProfile?->vision
        ?? $schoolProfile?->tagline
        ?? $siteSetting?->site_description;

    $footerQuote = filled($footerQuoteSource)
        ? \Illuminate\Support\Str::limit(
            trim(strip_tags($footerQuoteSource)),
            180
        )
        : null;

    $copyright = $siteSetting?->copyright_text;
@endphp

<footer class="site-footer">
    <div class="container">
        <div class="site-footer-main">
            <div class="row g-4 g-xl-5">
                <div class="col-12 col-lg-4">
                    <div class="footer-brand">
                        @if ($logoUrl)
                            <img
                                class="footer-brand-logo"
                                src="{{ $logoUrl }}"
                                alt="Logo {{ $brandName }}"
                                width="72"
                                height="72"
                            >
                        @else
                            <span
                                class="footer-brand-placeholder"
                                aria-hidden="true"
                            >
                                {{ $brandInitials }}
                            </span>
                        @endif

                        <div>
                            <h2 class="footer-brand-name">
                                {{ $brandName }}
                            </h2>

                            @if (filled($schoolProfile?->tagline))
                                <p class="footer-brand-tagline">
                                    {{ $schoolProfile->tagline }}
                                </p>
                            @endif
                        </div>
                    </div>

                    @if (filled($siteSetting?->site_description))
                        <p class="footer-description">
                            {{ $siteSetting->site_description }}
                        </p>
                    @endif

                    <ul class="footer-contact-list">
                        @if (filled($schoolProfile?->address))
                            <li>
                                <span class="footer-contact-icon">
                                    <i
                                        data-lucide="map-pin"
                                        aria-hidden="true"
                                    ></i>
                                </span>

                                <div>
                                    <strong>Alamat</strong>
                                    <span>{{ $schoolProfile->address }}</span>
                                </div>
                            </li>
                        @endif

                        @if ($phoneHref)
                            <li>
                                <span class="footer-contact-icon">
                                    <i
                                        data-lucide="phone"
                                        aria-hidden="true"
                                    ></i>
                                </span>

                                <div>
                                    <strong>Telepon</strong>
                                    <a href="tel:{{ $phoneHref }}">
                                        {{ $schoolProfile->phone }}
                                    </a>
                                </div>
                            </li>
                        @endif

                        @if (filled($schoolProfile?->email))
                            <li>
                                <span class="footer-contact-icon">
                                    <i
                                        data-lucide="mail"
                                        aria-hidden="true"
                                    ></i>
                                </span>

                                <div>
                                    <strong>Email</strong>
                                    <a href="mailto:{{ $schoolProfile->email }}">
                                        {{ $schoolProfile->email }}
                                    </a>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="col-6 col-md-4 col-lg-2">
                    <h3 class="footer-heading">
                        Tautan Cepat
                    </h3>

                    <ul class="footer-link-list">
                        <li>
                            <a href="{{ url('/profil') }}">
                                <span aria-hidden="true">›</span>
                                Profil
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/kurikulum') }}">
                                <span aria-hidden="true">›</span>
                                Kurikulum
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/berita') }}">
                                <span aria-hidden="true">›</span>
                                Berita
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/spmb') }}">
                                <span aria-hidden="true">›</span>
                                SPMB
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/alumni') }}">
                                <span aria-hidden="true">›</span>
                                Alumni
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/kontak') }}">
                                <span aria-hidden="true">›</span>
                                Kontak
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-12 col-md-8 col-lg-3">
                    <h3 class="footer-heading">
                        Media Sosial
                    </h3>

                    <div class="footer-social-list">
                        @if (filled($schoolProfile?->instagram))
                            <a
                                class="footer-social-link"
                                href="{{ $schoolProfile->instagram }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Buka Instagram {{ $brandName }}"
                            >
                                <span class="footer-social-icon footer-social-icon-instagram">
                                    <svg
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <rect
                                            x="3"
                                            y="3"
                                            width="18"
                                            height="18"
                                            rx="5"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        />
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="4"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        />
                                        <circle
                                            cx="17.5"
                                            cy="6.5"
                                            r="1"
                                            fill="currentColor"
                                        />
                                    </svg>
                                </span>

                                <span class="footer-social-copy">
                                    <strong>Instagram</strong>
                                    <small>Ikuti informasi terbaru sekolah</small>
                                </span>

                                <span
                                    class="footer-social-arrow"
                                    aria-hidden="true"
                                >
                                    ↗
                                </span>
                            </a>
                        @endif

                        @if (filled($schoolProfile?->facebook))
                            <a
                                class="footer-social-link"
                                href="{{ $schoolProfile->facebook }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Buka Facebook {{ $brandName }}"
                            >
                                <span class="footer-social-icon footer-social-icon-facebook">
                                    <svg
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill="currentColor"
                                            d="M13.7 22v-8h2.7l.4-3.1h-3.1V8.9c0-.9.3-1.5 1.6-1.5H17V4.6c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.1H7.5V14h2.8v8h3.4Z"
                                        />
                                    </svg>
                                </span>

                                <span class="footer-social-copy">
                                    <strong>Facebook</strong>
                                    <small>Terhubung dengan komunitas sekolah</small>
                                </span>

                                <span
                                    class="footer-social-arrow"
                                    aria-hidden="true"
                                >
                                    ↗
                                </span>
                            </a>
                        @endif

                        @if (filled($schoolProfile?->youtube))
                            <a
                                class="footer-social-link"
                                href="{{ $schoolProfile->youtube }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Buka YouTube {{ $brandName }}"
                            >
                                <span class="footer-social-icon footer-social-icon-youtube">
                                    <svg
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill="currentColor"
                                            d="M21.6 7.2a2.8 2.8 0 0 0-2-2C17.8 4.7 12 4.7 12 4.7s-5.8 0-7.6.5a2.8 2.8 0 0 0-2 2A29 29 0 0 0 2 12a29 29 0 0 0 .4 4.8 2.8 2.8 0 0 0 2 2c1.8.5 7.6.5 7.6.5s5.8 0 7.6-.5a2.8 2.8 0 0 0 2-2A29 29 0 0 0 22 12a29 29 0 0 0-.4-4.8ZM10 15.2V8.8l5.5 3.2-5.5 3.2Z"
                                        />
                                    </svg>
                                </span>

                                <span class="footer-social-copy">
                                    <strong>YouTube</strong>
                                    <small>Tonton dokumentasi kegiatan sekolah</small>
                                </span>

                                <span
                                    class="footer-social-arrow"
                                    aria-hidden="true"
                                >
                                    ↗
                                </span>
                            </a>
                        @endif

                        @if (
                            blank($schoolProfile?->instagram)
                            && blank($schoolProfile?->facebook)
                            && blank($schoolProfile?->youtube)
                        )
                            <p class="footer-empty-text">
                                Media sosial belum tersedia.
                            </p>
                        @endif
                    </div>

                    @if ($footerQuote)
                        <blockquote class="footer-quote-card">
                            <span
                                class="footer-quote-mark"
                                aria-hidden="true"
                            >
                                “
                            </span>

                            <p>{{ $footerQuote }}</p>

                            <footer>{{ $brandName }}</footer>
                        </blockquote>
                    @endif
                </div>

                <div class="col-12 col-lg-3">
                    <h3 class="footer-heading">
                        Lokasi Sekolah
                    </h3>

                    @if ($mapsSrc)
                        <div class="footer-map">
                            <iframe
                                src="{{ $mapsSrc }}"
                                title="Lokasi {{ $brandName }}"
                                loading="lazy"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen
                            ></iframe>
                        </div>
                    @else
                        <p class="footer-empty-text">
                            Peta lokasi belum tersedia.
                        </p>
                    @endif

                    @if (filled($schoolProfile?->address))
                        <div class="footer-map-address">
                            <span class="footer-map-address-icon">
                                <i
                                    data-lucide="map-pin"
                                    aria-hidden="true"
                                ></i>
                            </span>

                            <span>{{ $schoolProfile->address }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>
                @if (filled($copyright))
                    {{ $copyright }}
                @else
                    &copy; {{ now()->year }} {{ $brandName }}.
                    All Rights Reserved.
                @endif
            </p>

            <a
                class="footer-back-to-top"
                href="#top"
                aria-label="Kembali ke bagian atas halaman"
            >
                ↑
            </a>
        </div>
    </div>
</footer>