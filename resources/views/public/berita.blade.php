{{-- resources/views/public/berita.blade.php --}}
@extends('layouts.app')
@section('title','Berita')
@section('content')
<div style="background:linear-gradient(135deg,#1a5c2a,#2d8a4e);padding:40px 0 30px;color:white;">
    <div class="container">
        <h1 class="h3 fw-bold mb-1">📰 Berita & Informasi</h1>
        <p class="mb-0" style="opacity:.85;font-size:.9rem;">Kabar terbaru dari Taman Koleksi Tanaman Obat Kebun Raya UP</p>
    </div>
</div>

<div class="container py-4">
    <!-- Filter -->
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Cari berita..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">

        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-hijau flex-fill"><i class="bi bi-search me-1"></i>Cari</button>
            <a href="{{ route('berita') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <div class="row g-3">
        @forelse($beritas as $b)
        <div class="col-md-4">
            <div class="card-tanaman h-100 shadow-sm" style="border-radius: 12px; overflow: hidden; background: white;">
                <div style="height:180px;overflow:hidden;background:#e3f2fd;display:flex;align-items:center;justify-content:center;">
                    @if($b->foto)
                        <img src="{{ Storage::url($b->foto) }}" alt="{{ $b->judul }}" style="width:100%;height:180px;object-fit:cover;">
                    @else
                        <span style="font-size:3.5rem;">📰</span>
                    @endif
                </div>
                <div class="p-3">
                    <div class="d-flex gap-2 mb-2">
                        <span class="text-muted" style="font-size:.74rem;"><i class="bi bi-eye me-1"></i>{{ $b->views }}</span>
                    </div>
                    
                    {{-- Judul dengan pemutus kata otomatis --}}
                    <h6 class="fw-bold" style="font-size:.88rem; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word;">
                        {{ Str::limit($b->judul, 65) }}
                    </h6>

                    {{-- Isi berita dengan pemutus kata otomatis agar tidak keluar kotak --}}
                    <p class="text-muted" style="font-size:.8rem; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word;">
                        {{ Str::limit(strip_tags($b->isi), 90) }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <small class="text-muted">{{ $b->created_at->format('d M Y') }}</small>
                        <a href="{{ route('berita.detail',$b->slug) }}" class="btn btn-sm btn-hijau px-3" style="border-radius: 8px;">Baca</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div style="font-size:4rem;">📰</div>
            <h5 class="text-muted">Belum ada berita ditemukan</h5>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $beritas->links() }}
    </div>
</div>

<style>
    .card-tanaman {
        transition: transform 0.3s ease;
    }
    .card-tanaman:hover {
        transform: translateY(-5px);
    }
    /* Tambahan pengaman global untuk teks panjang */
    .card-tanaman h6, .card-tanaman p {
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
    }
</style>
@endsection