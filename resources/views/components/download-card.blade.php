@props([
    'title',
    'description',
    'filePath',
    'previewPath' => null,
    'downloadLabel' => 'Unduh File',
])

@php
    $fileUrl = filled($filePath)
        ? \Illuminate\Support\Facades\Storage::url($filePath)
        : null;

    $previewUrl = filled($previewPath)
        ? \Illuminate\Support\Facades\Storage::url($previewPath)
        : null;
@endphp

@if ($fileUrl)
    <article class="download-card">
        @if ($previewUrl)
            <div class="download-card-preview">
                <img
                    src="{{ $previewUrl }}"
                    alt="Preview {{ $title }}"
                    width="720"
                    height="900"
                    loading="lazy"
                >
            </div>
        @else
            <div
                class="download-card-placeholder"
                aria-hidden="true"
            >
                <i data-lucide="file-text"></i>
            </div>
        @endif

        <div class="download-card-body">
            <p class="download-card-eyebrow">
                Dokumen SPMB
            </p>

            <h3>{{ $title }}</h3>

            <p>{{ $description }}</p>

            <a
                class="btn btn-site-primary"
                href="{{ $fileUrl }}"
                download
            >
                <i
                    data-lucide="download"
                    aria-hidden="true"
                ></i>

                {{ $downloadLabel }}
            </a>
        </div>
    </article>
@endif
