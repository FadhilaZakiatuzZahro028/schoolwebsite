@props([
    'alumni',
])

@php
    $initials = collect(preg_split('/\s+/', $alumni->name))
        ->filter()
        ->take(2)
        ->map(
            fn (string $word): string => mb_strtoupper(
                mb_substr($word, 0, 1),
            )
        )
        ->implode('');
@endphp

<article
    class="alumni-card"
    aria-labelledby="alumni-name-{{ $alumni->id }}"
>
    <div class="alumni-card-photo-wrap">
        @if (filled($alumni->photo))
            <img
                class="alumni-card-photo"
                src="{{ \Illuminate\Support\Facades\Storage::url(
                    $alumni->photo
                ) }}"
                alt="Foto alumni {{ $alumni->name }}"
                width="480"
                height="480"
                loading="lazy"
            >
        @else
            <div
                class="alumni-card-placeholder"
                aria-hidden="true"
            >
                {{ $initials }}
            </div>
        @endif
    </div>

    <div class="alumni-card-body">
        <p class="alumni-card-year">
            Lulusan {{ $alumni->graduation_year }}
        </p>

        <h3
            id="alumni-name-{{ $alumni->id }}"
            class="alumni-card-name"
        >
            {{ $alumni->name }}
        </h3>

        @if (filled($alumni->current_activity))
            <p class="alumni-card-activity">
                <i
                    data-lucide="briefcase"
                    aria-hidden="true"
                ></i>

                <span>{{ $alumni->current_activity }}</span>
            </p>
        @endif

        @if (filled($alumni->institution))
            <p class="alumni-card-institution">
                <i
                    data-lucide="building"
                    aria-hidden="true"
                ></i>

                <span>{{ $alumni->institution }}</span>
            </p>
        @endif

                @if (filled($alumni->quote))
            <blockquote class="alumni-card-quote">
                {{ $alumni->quote }}
            </blockquote>
        @endif
    </div>
</article>