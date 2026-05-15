@extends('layouts.app')
@section('title', $berita->judul)

@section('content')
{{-- Breadcrumb --}}
<div style="background: #1a5c2a; padding: 15px 0;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/berita') }}" class="text-white-50 text-decoration-none">Berita</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($berita->judul, 30) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        {{-- Kolom Berita Dibuat Tengah dan Lebih Lebar (col-lg-10) --}}
        <div class="col-lg-10">
            
            {{-- Foto Utama --}}
            @if($berita->foto)
            <div class="mb-4 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                <img src="{{ Storage::url($berita->foto) }}" class="img-fluid w-100" alt="{{ $berita->judul }}" style="max-height: 500px; object-fit: cover;">
            </div>
            @endif

            {{-- Meta Data --}}
            <div class="d-flex flex-wrap gap-3 align-items-center mb-3">
                <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i> {{ $berita->created_at->format('d F Y') }}</span>
                <span class="text-muted small"><i class="bi bi-eye me-1"></i> {{ number_format($berita->views) }} dilihat</span>
            </div>

            {{-- Judul --}}
            <h1 class="fw-bold mb-4" style="color: #1a5c2a; line-height: 1.3;">{{ $berita->judul }}</h1>

            {{-- Isi Berita --}}
            <div class="content-berita mb-5" style="font-size: 1.1rem; line-height: 1.8; color: #333; text-align: justify;">
                {!! nl2br(e($berita->isi)) !!}
            </div>

            <hr>

            {{-- Tombol Kembali --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ url('/berita') }}" class="btn btn-outline-success">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Berita
                </a>
                
                {{-- Fitur Share Sederhana --}}
                <div class="d-flex gap-2">
                    <span class="small text-muted me-2 d-none d-sm-inline">Bagikan:</span>
                    <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}" target="_blank" class="btn btn-sm btn-success rounded-circle">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="btn btn-sm btn-primary rounded-circle">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <button onclick="copyLink()" class="btn btn-sm btn-outline-secondary flex-fill">
                        <i class="bi bi-link-45deg"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Link berhasil disalin!');
    });
}
</script>
@endpush

<style>
    .content-berita p {
        margin-bottom: 1.5rem;
    }
    /* Memastikan teks panjang di judul tidak merusak layout */
    h1 {
        overflow-wrap: break-word;
        word-wrap: break-word;
    }
</style>
@endsection