@extends('errors.layout')

@section('title', 'Halaman Tidak Ditemukan')
@section('code', '404')
@section('heading', 'Halaman Tidak Ditemukan')

@section('icon')
    <svg
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1.8"
        stroke-linecap="round"
        stroke-linejoin="round"
    >
        <circle cx="12" cy="12" r="9"></circle>
        <path d="m15.5 8.5-2.1 4.9-4.9 2.1 2.1-4.9 4.9-2.1Z"></path>
    </svg>
@endsection

@section(
    'description',
    'Halaman yang Anda cari tidak ditemukan atau telah dipindahkan.'
)

@section('actions')
    <a
        class="error-button error-button-primary"
        href="{{ url('/') }}"
    >
        Kembali ke Beranda
    </a>
@endsection