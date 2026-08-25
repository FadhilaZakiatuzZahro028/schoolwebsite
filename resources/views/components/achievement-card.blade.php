@props([
    'achievement',
])

<article
    class="achievement-card"
    aria-labelledby="achievement-title-{{ $achievement->id }}"
>
    <a
        class="achievement-card-link"
        href="{{ route('achievements.show', [
            'slug' => $achievement->slug,
        ]) }}"
    >
        <div class="achievement-card-media">
            <img
                class="achievement-card-image"
                src="{{ asset('storage/' . $achievement->image) }}"
                alt="Dokumentasi {{ $achievement->title }}"
                width="640"
                height="480"
                loading="lazy"
            >

            <span
                class="achievement-card-icon"
                aria-hidden="true"
            >
                <i data-lucide="trophy"></i>
            </span>

            <span class="achievement-card-level">
                {{ $achievement->level }}
            </span>
        </div>

        <div class="achievement-card-body">
            <span class="achievement-card-year">
                Prestasi {{ $achievement->year }}
            </span>

            <h3
                id="achievement-title-{{ $achievement->id }}"
                class="achievement-card-title"
            >
                {{ $achievement->title }}
            </h3>

            <p class="achievement-card-description">
                {{ $achievement->description }}
            </p>

            <span class="achievement-card-action">
                Lihat Detail

                <i
                    data-lucide="arrow-up-right"
                    aria-hidden="true"
                ></i>
            </span>
        </div>
    </a>
</article>