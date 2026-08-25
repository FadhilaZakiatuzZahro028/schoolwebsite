@props([
    'news',
])

<article class="news-card">
    <a
        class="news-card-link"
        href="{{ route('news.show', ['slug' => $news->slug]) }}"
    >
        <div class="news-card-media">
            <img
                class="news-card-image"
                src="{{ asset('storage/' . $news->thumbnail) }}"
                alt="Gambar berita {{ $news->title }}"
                width="640"
                height="360"
                loading="lazy"
            >

            @if ($news->category !== null)
                <span class="news-card-category">
                    {{ $news->category->name }}
                </span>
            @endif
        </div>

        <div class="news-card-body">
            <time
                class="news-card-date"
                datetime="{{ $news->published_at->toDateString() }}"
            >
                {{ $news->published_at
                    ->locale('id')
                    ->translatedFormat('d F Y') }}
            </time>

            <h3 class="news-card-title">
                {{ $news->title }}
            </h3>

            <p class="news-card-excerpt">
                {{ $news->excerpt }}
            </p>

            <span class="news-card-action">
                Baca Selengkapnya

                <i
                    data-lucide="arrow-up-right"
                    aria-hidden="true"
                ></i>
            </span>
        </div>
    </a>
</article>