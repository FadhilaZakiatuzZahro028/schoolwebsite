@props([
    'staffMembers',
    'initialIndex' => 0,
])

@php
    $staffCount = $staffMembers->count();

    $resolvedInitialIndex = $staffCount > 0
        ? min(
            max((int) $initialIndex, 0),
            $staffCount - 1,
        )
        : 0;

    $firstStaff = $staffMembers->first();

    $carouselLabel = $firstStaff?->staff_type
        === \App\Models\StaffMember::TYPE_TEACHER
            ? 'Daftar Guru'
            : 'Daftar Karyawan';

    $carouselId = 'staff-carousel-'
        . ($firstStaff?->staff_type ?? 'staff');
@endphp

<div
    class="staff-carousel{{ $staffCount === 1 ? ' is-single' : '' }}"
    data-staff-carousel
    data-initial-index="{{ $resolvedInitialIndex }}"
    data-slide-count="{{ $staffCount }}"
    role="region"
    aria-roledescription="carousel"
    aria-label="{{ $carouselLabel }}"
>
    <div
        class="staff-carousel-viewport"
        data-staff-carousel-viewport
    >
        <div
            id="{{ $carouselId }}-track"
            class="staff-carousel-track"
            data-staff-carousel-track
        >
            @foreach ($staffMembers as $staffMember)
                <div
                    class="
                        staff-carousel-slide
                        {{ $loop->index === $resolvedInitialIndex
                            ? 'is-active'
                            : '' }}
                    "
                    data-staff-carousel-slide
                    data-index="{{ $loop->index }}"
                    role="group"
                    aria-roledescription="slide"
                    aria-label="
                        {{ $loop->iteration }}
                        dari
                        {{ $staffCount }}
                    "
                    @if ($loop->index === $resolvedInitialIndex)
                        aria-current="true"
                    @endif
                >
                    <x-staff-card
                        :staff="$staffMember"
                        :type="$staffMember->staff_type"
                    />
                </div>
            @endforeach
        </div>
    </div>

    @if ($staffCount > 1)
        <div class="staff-carousel-controls">
            <button
                class="
                    staff-carousel-control
                    staff-carousel-control-prev
                "
                type="button"
                data-staff-carousel-prev
                aria-controls="{{ $carouselId }}-track"
                aria-label="Tampilkan staf sebelumnya"
            >
                <span aria-hidden="true">
                    &larr;
                </span>
            </button>

            <button
                class="
                    staff-carousel-control
                    staff-carousel-control-next
                "
                type="button"
                data-staff-carousel-next
                aria-controls="{{ $carouselId }}-track"
                aria-label="Tampilkan staf berikutnya"
            >
                <span aria-hidden="true">
                    &rarr;
                </span>
            </button>
        </div>
    @endif
</div>