@props([
    'staff',
    'type',
])

@php
    $initials = collect(preg_split('/\s+/', $staff->name))
        ->filter()
        ->take(2)
        ->map(
            fn (string $word): string => mb_strtoupper(
                mb_substr($word, 0, 1),
            )
        )
        ->implode('');

    $detailLabel = $type === 'teacher'
        ? 'Mata Pelajaran'
        : 'Bagian / Unit';

    $detailValue = $type === 'teacher'
        ? $staff->subject
        : $staff->department;
@endphp

<article class="staff-card">
    <div class="staff-card-photo-wrap">
        @if (filled($staff->photo))
            <img
                class="staff-card-photo"
                src="{{ \Illuminate\Support\Facades\Storage::url(
                    $staff->photo
                ) }}"
                alt="Foto {{ $staff->name }}"
                width="400"
                height="400"
                loading="lazy"
            >
        @else
            <div
                class="staff-card-placeholder"
                aria-hidden="true"
            >
                {{ $initials }}
            </div>
        @endif
    </div>

    <div class="staff-card-body">
        <span class="staff-card-type">
            {{ $type === 'teacher' ? 'Guru' : 'Karyawan' }}
        </span>

        <h3 class="staff-card-name">
            {{ $staff->name }}
        </h3>

        <p class="staff-card-position">
            {{ $staff->position }}
        </p>

        @if (filled($detailValue))
            <dl class="staff-card-detail">
                <div>
                    <dt>{{ $detailLabel }}</dt>
                    <dd>{{ $detailValue }}</dd>
                </div>
            </dl>
        @endif

        @if ($staff->educations->isNotEmpty())
    <div class="staff-card-educations">
        <p class="staff-card-educations-label">
            Riwayat Pendidikan
        </p>

        <ul class="staff-card-education-list">
            @foreach ($staff->educations as $education)
                <li class="staff-card-education-item">
                    <p class="staff-card-education-degree">
                        {{ trim(
                            $education->education_level
                            . ' '
                            . ($education->study_program ?? '')
                        ) }}
                    </p>

                    <p class="staff-card-education-institution">
                        {{ $education->institution }}
                    </p>
                </li>
            @endforeach
        </ul>
    </div>
@endif
    </div>
</article>