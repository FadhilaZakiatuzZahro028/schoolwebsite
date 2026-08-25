@props([
    'extracurricular',
])

<article
    class="extracurricular-card"
    aria-labelledby="extracurricular-title-{{ $extracurricular->id }}"
>
    <a
        class="extracurricular-card-link"
        href="{{ route('extracurriculars.show', [
            'slug' => $extracurricular->slug,
        ]) }}"
    >
        <div class="extracurricular-card-media">
            <img
                class="extracurricular-card-image"
                src="{{ asset('storage/' . $extracurricular->image) }}"
                alt="Kegiatan {{ $extracurricular->name }}"
                width="640"
                height="420"
                loading="lazy"
            >

            <span class="extracurricular-card-badge">
                Ekstrakurikuler
            </span>
        </div>

        <div class="extracurricular-card-body">
            <h3
                id="extracurricular-title-{{ $extracurricular->id }}"
                class="extracurricular-card-title"
            >
                {{ $extracurricular->name }}
            </h3>

            <p class="extracurricular-card-description">
                {{ $extracurricular->description }}
            </p>

            <dl class="extracurricular-card-meta">
                <div>
                    <dt>Pembina</dt>
                    <dd>{{ $extracurricular->coach_name }}</dd>
                </div>

                <div>
                    <dt>Jadwal</dt>
                    <dd>{{ $extracurricular->schedule }}</dd>
                </div>
            </dl>

            <span class="extracurricular-card-action">
                Lihat Detail

                <i
                    data-lucide="arrow-up-right"
                    aria-hidden="true"
                ></i>
            </span>
        </div>
    </a>
</article>