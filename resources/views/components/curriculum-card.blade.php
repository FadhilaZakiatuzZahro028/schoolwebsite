@props([
    'curriculum',
])

@php
    $previewUrl = filled($curriculum->preview_image)
        ? \Illuminate\Support\Facades\Storage::url(
            $curriculum->preview_image
        )
        : null;

    $pdfUrl = filled($curriculum->pdf_file)
        ? \Illuminate\Support\Facades\Storage::url(
            $curriculum->pdf_file
        )
        : null;

    $imageDownloadUrl = filled($curriculum->image_file)
        ? \Illuminate\Support\Facades\Storage::url(
            $curriculum->image_file
        )
        : null;
@endphp

<article
    class="curriculum-card"
    aria-labelledby="curriculum-title-{{ $curriculum->id }}"
>
    <div class="curriculum-card-media">
        @if ($previewUrl)
            <img
                class="curriculum-card-image"
                src="{{ $previewUrl }}"
                alt="Preview materi {{ $curriculum->title }}"
                width="640"
                height="400"
                loading="lazy"
            >
        @else
            <div
                class="curriculum-card-placeholder"
                aria-hidden="true"
            >
                <i data-lucide="book-open"></i>
            </div>
        @endif
    </div>

    <div class="curriculum-card-body">
        <p class="curriculum-card-year">
            Tahun Ajaran {{ $curriculum->academic_year }}
        </p>

        <h3
            id="curriculum-title-{{ $curriculum->id }}"
            class="curriculum-card-title"
        >
            {{ $curriculum->title }}
        </h3>

        @if (filled($curriculum->description))
            <p class="curriculum-card-description">
                {{ $curriculum->description }}
            </p>
        @endif

        @if ($pdfUrl || $imageDownloadUrl)
            <div class="curriculum-card-actions">
                @if ($pdfUrl)
                    <a
                        class="btn btn-site-primary"
                        href="{{ $pdfUrl }}"
                        download
                    >
                        <i
                            data-lucide="file-down"
                            aria-hidden="true"
                        ></i>

                        Unduh PDF
                    </a>
                @endif

                @if ($imageDownloadUrl)
                    <a
                        class="btn btn-outline-primary"
                        href="{{ $imageDownloadUrl }}"
                        download
                    >
                        <i
                            data-lucide="image-down"
                            aria-hidden="true"
                        ></i>

                        Unduh Gambar
                    </a>
                @endif
            </div>
        @endif
    </div>
</article>
