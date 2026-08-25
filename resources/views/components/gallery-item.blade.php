@props([
    'galleryItem',
])

<figure
    class="gallery-card"
    aria-labelledby="gallery-title-{{ $galleryItem->id }}"
>
    <div class="gallery-card-media">
        <img
            class="gallery-card-image"
            src="{{ asset('storage/' . $galleryItem->image) }}"
            alt="{{ $galleryItem->title }}"
            width="640"
            height="480"
            loading="lazy"
        >
    </div>

    <figcaption class="gallery-card-content">
        <h3
            id="gallery-title-{{ $galleryItem->id }}"
            class="gallery-card-title"
        >
            {{ $galleryItem->title }}
        </h3>

        @if (filled($galleryItem->description))
            <p class="gallery-card-description">
                {{ $galleryItem->description }}
            </p>
        @endif
    </figcaption>
</figure>