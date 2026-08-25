@props([
    'program',
])

<article
    class="featured-program-card"
    aria-labelledby="featured-program-title-{{ $program->id }}"
>
    <a
    class="featured-program-card-link"
    href="{{ route('featured-programs.show', [
        'featuredProgram' => $program->slug,
    ]) }}"
>

    <div class="featured-program-card-media">
        <img
            class="featured-program-card-image"
            src="{{ asset('storage/' . $program->image) }}"
            alt="{{ $program->name }}"
            width="640"
            height="420"
            loading="lazy"
        >

        <span class="featured-program-card-label">
            Program Unggulan
        </span>
    </div>

    <div class="featured-program-card-body">
        <h3
            id="featured-program-title-{{ $program->id }}"
            class="featured-program-card-title"
        >
            {{ $program->name }}
        </h3>

        <p class="featured-program-card-description">
            {{ $program->summary }}
        </p>

        <span class="featured-program-card-action">
            Lihat Program

            <i
                data-lucide="arrow-up-right"
                aria-hidden="true"
            ></i>
        </span>
    </div>
    </a>
</article>