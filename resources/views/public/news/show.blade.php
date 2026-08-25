@extends('layouts.app')

@section('title', $news->meta_title ?: $news->title)

@section('content')
    <div
        class="news-reading-progress"
        aria-hidden="true"
    >
        <span data-news-reading-progress></span>
    </div>

    <section class="site-section news-detail-section">
        <div class="container">
            <article
                class="news-detail-article"
                data-news-article
            >
                <nav
                    class="news-breadcrumb"
                    aria-label="Breadcrumb"
                >
                    <a href="{{ route('home') }}">
                        Beranda
                    </a>

                    <span aria-hidden="true">/</span>

                    <a href="{{ route('news.index') }}">
                        Berita
                    </a>

                    <span aria-hidden="true">/</span>

                    <span aria-current="page">
                        Detail
                    </span>
                </nav>

                <header class="news-detail-heading">
                    @if ($news->category !== null)
                        <span class="news-detail-category">
                            {{ $news->category->name }}
                        </span>
                    @endif

                    <h1>{{ $news->title }}</h1>

                    <div class="news-detail-meta">
                        <span class="news-detail-meta-item">
                            <i
                                data-lucide="calendar-days"
                                aria-hidden="true"
                            ></i>

                            <time
                                datetime="{{ $news->published_at->toDateString() }}"
                            >
                                {{ $news->published_at
                                    ->locale('id')
                                    ->translatedFormat('d F Y') }}
                            </time>
                        </span>

                        <span
                            class="news-detail-meta-separator"
                            aria-hidden="true"
                        ></span>

                        <span class="news-detail-meta-item">
                            <i
                                data-lucide="clock-3"
                                aria-hidden="true"
                            ></i>

                            {{ $readingTime }} menit baca
                        </span>
                    </div>
                </header>

                <figure class="news-detail-featured">
                    <img
                        class="news-detail-image"
                        src="{{ asset('storage/' . $news->thumbnail) }}"
                        alt="Gambar utama {{ $news->title }}"
                        width="1280"
                        height="720"
                    >
                </figure>

                <div class="news-detail-layout">
                    <main class="news-detail-main">
                        @if (filled($news->excerpt))
                            <p class="news-detail-excerpt">
                                {{ $news->excerpt }}
                            </p>
                        @endif

                        <div class="news-detail-content">
                            {!! $news->content !!}
                        </div>

                       <div class="news-detail-closing">
    <div class="news-detail-end">
        <span
            class="news-detail-end-icon"
            aria-hidden="true"
        >
            <i data-lucide="newspaper"></i>
        </span>

        <div>
            <p>Publikasi Sekolah</p>

            <span>
                Informasi resmi SMA PGRI 1 Tulungagung.
            </span>
        </div>
    </div>

    <a
        class="btn btn-site-secondary news-detail-back"
        href="{{ route('news.index') }}"
    >
        <i
            data-lucide="arrow-left"
            aria-hidden="true"
        ></i>

        Kembali ke Berita
    </a>
</div>
                    </main>

                    <aside
                        class="news-detail-sidebar"
                        aria-label="Informasi pendukung berita"
                    >
                        <section class="news-share-panel">
                            <div class="news-sidebar-heading">
                                <span
                                    class="news-sidebar-heading-icon"
                                    aria-hidden="true"
                                >
                                    <i data-lucide="share-2"></i>
                                </span>

                                <div>
                                    <p>Bagikan</p>
                                    <h2>Bagikan Berita</h2>
                                </div>
                            </div>

                            <p class="news-share-description">
                                Bagikan informasi ini melalui kanal yang
                                tersedia.
                            </p>

                            <div class="news-share-actions">
                                <a
                                    class="news-share-button"
                                    href="https://wa.me/?text={{ urlencode($news->title . ' ' . request()->fullUrl()) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    WhatsApp
                                </a>

                                <a
                                    class="news-share-button"
                                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    Facebook
                                </a>

                                <button
                                    class="news-share-button news-share-button--copy"
                                    type="button"
                                    data-news-copy-link
                                    data-news-url="{{ request()->fullUrl() }}"
                                >
                                    <i
                                        data-lucide="link"
                                        aria-hidden="true"
                                    ></i>

                                    <span data-news-copy-label>
                                        Salin Tautan
                                    </span>
                                </button>
                            </div>

                            <p
                                class="news-copy-feedback"
                                data-news-copy-feedback
                                role="status"
                                aria-live="polite"
                            ></p>
                        </section>

                        @if ($relatedNews->isNotEmpty())
                            <section class="news-related-panel">
                                <div class="news-sidebar-heading">
                                    <span
                                        class="news-sidebar-heading-icon"
                                        aria-hidden="true"
                                    >
                                        <i data-lucide="newspaper"></i>
                                    </span>

                                    <div>
                                        <p>Berita Lainnya</p>
                                        <h2>Berita Terkait</h2>
                                    </div>
                                </div>

                                <div class="news-related-list">
                                    @foreach ($relatedNews as $relatedItem)
                                        <article class="news-related-item">
                                            <a
                                                class="news-related-link"
                                                href="{{ route('news.show', [
                                                    'slug' => $relatedItem->slug,
                                                ]) }}"
                                            >
                                                <img
                                                    class="news-related-image"
                                                    src="{{ asset(
                                                        'storage/'
                                                        . $relatedItem->thumbnail
                                                    ) }}"
                                                    alt=""
                                                    width="180"
                                                    height="120"
                                                    loading="lazy"
                                                >

                                                <div class="news-related-copy">
                                                    @if (
                                                        $relatedItem->category
                                                        !== null
                                                    )
                                                        <span>
                                                            {{ $relatedItem
                                                                ->category
                                                                ->name }}
                                                        </span>
                                                    @endif

                                                    <h3>
                                                        {{ $relatedItem->title }}
                                                    </h3>

                                                    <time
                                                        datetime="{{ $relatedItem
                                                            ->published_at
                                                            ->toDateString() }}"
                                                    >
                                                        {{ $relatedItem
                                                            ->published_at
                                                            ->locale('id')
                                                            ->translatedFormat(
                                                                'd M Y',
                                                            ) }}
                                                    </time>
                                                </div>
                                            </a>
                                        </article>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    </aside>
                </div>

            </article>
        </div>
    </section>
@endsection