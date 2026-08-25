@extends('errors.layout')

@section('title', 'Terjadi Kesalahan Sistem')
@section('code', '500')
@section('heading', 'Terjadi Kesalahan Sistem')

@section('icon')
    <svg
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1.8"
        stroke-linecap="round"
        stroke-linejoin="round"
    >
        <path d="M12 9v4"></path>
        <path d="M12 17h.01"></path>
        <path d="M10.3 3.7 2.6 17a2 2 0 0 0 1.7 3h15.4a2 2 0 0 0 1.7-3L13.7 3.7a2 2 0 0 0-3.4 0Z"></path>
    </svg>
@endsection

@section(
    'description',
    'Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.'
)

@section('actions')
    <button
        class="error-button error-button-primary"
        type="button"
        onclick="window.location.reload()"
    >
        Coba Lagi
    </button>

    <a
        class="error-button error-button-secondary"
        href="{{ url('/') }}"
    >
        Kembali ke Beranda
    </a>
@endsection