@props([
    'facility',
])

<article
    class="facility-card"
    aria-labelledby="facility-title-{{ $facility->id }}"
>
    <a
        class="facility-card-link"
        href="{{ route('facilities.show', [
            'slug' => $facility->slug,
        ]) }}"
    >
        <div class="facility-card-media">
            <img
                class="facility-card-image"
                src="{{ asset('storage/' . $facility->image) }}"
                alt="{{ $facility->name }}"
                width="640"
                height="420"
                loading="lazy"
            >

            <span class="facility-card-label">
                Fasilitas Sekolah
            </span>
        </div>

        <div class="facility-card-body">
            <h3
                id="facility-title-{{ $facility->id }}"
                class="facility-card-title"
            >
                {{ $facility->name }}
            </h3>

            <p class="facility-card-description">
                {{ $facility->description }}
            </p>

            <span class="facility-card-action">
                Lihat Detail

                <i
                    data-lucide="arrow-up-right"
                    aria-hidden="true"
                ></i>
            </span>
        </div>
    </a>
</article>