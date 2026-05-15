@extends('layouts.app')
@section('title', 'Galeri Taman Koleksi')

@section('content')
{{-- Header Halaman --}}
<div style="background:linear-gradient(135deg,#1a5c2a,#2d8a4e);padding:40px 0 30px;color:white;">
    <div class="container">
        <h1 class="h3 fw-bold mb-1">🖼️ Galeri Taman Koleksi</h1>
        <p class="mb-0" style="opacity:.85;font-size:.9rem;">Dokumentasi kegiatan Taman Koleksi Tanaman Obat Kebun Raya UP</p>
    </div>
</div>

<div class="container py-4">
    {{-- Filter Pencarian Horizontal di Atas --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
        <div class="card-body p-3">
            <form action="{{ route('galeri') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" 
                               placeholder="Cari dokumentasi kegiatan..." value="{{ request('search') }}" 
                               style="border-radius: 0 10px 10px 0; height: 45px;">
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-success fw-bold" style="border-radius: 10px; height: 45px;">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(request('search'))
        <div class="mb-4">
            <p class="text-muted small">Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong> 
            <a href="{{ route('galeri') }}" class="text-danger ms-2 text-decoration-none"><i class="bi bi-x-circle"></i> Reset</a></p>
        </div>
    @endif

    {{-- Grid Galeri --}}
    <div class="row g-3">
        @forelse($galeris as $g)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card-tanaman-galeri shadow-sm shadow-hover" data-bs-toggle="modal" data-bs-target="#galeriModal{{ $g->id }}" style="cursor:pointer; background: white; border-radius: 12px; overflow: hidden; transition: 0.3s;">
                <div style="height:180px; overflow:hidden; background:#e8f5e9; display:flex; align-items:center; justify-content:center;">
                    @if($g->foto)
                        <img src="{{ Storage::url($g->foto) }}" alt="{{ $g->judul }}" style="width:100%; height:180px; object-fit:cover;">
                    @else
                        <span style="font-size:3rem;">🖼️</span>
                    @endif
                </div>
                <div class="p-2">
                    <div class="fw-bold text-dark" style="font-size:.82rem;">{{ Str::limit($g->judul, 40) }}</div>
                    <div class="text-muted" style="font-size:.74rem;"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($g->tanggal)->format('d M Y') }}</div>
                </div>
            </div>
        </div>

        {{-- Modal untuk memperbesar gambar --}}
        <div class="modal fade" id="galeriModal{{ $g->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">{{ $g->judul }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        @if($g->foto)
                            <img src="{{ Storage::url($g->foto) }}" alt="{{ $g->judul }}" class="img-fluid w-100">
                        @endif
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <div class="w-100">
                            <p class="mb-1 text-dark">{{ $g->deskripsi }}</p>
                            <small class="text-muted"><i class="bi bi-calendar-check me-1"></i> {{ \Carbon\Carbon::parse($g->tanggal)->format('d F Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div style="font-size:4rem;">🖼️</div>
            <h5 class="text-muted">Dokumentasi tidak ditemukan</h5>
            @if(request('search'))
                <a href="{{ route('galeri') }}" class="btn btn-sm btn-success mt-2">Lihat Semua Koleksi</a>
            @endif
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $galeris->links() }}
    </div>
</div>

<style>
    .shadow-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.15);
        border-radius: 10px;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }
</style>
@endsection