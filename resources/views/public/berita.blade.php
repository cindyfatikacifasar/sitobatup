@extends('layouts.app')
@section('title', 'Berita & Informasi')
@section('content')

<style>
    .news-card {
        border: none;
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        background: #fff;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .news-img {
        height: 220px;
        width: 100%;
        object-fit: cover;
    }
    .search-section {
        background: #f8fdf9;
        border-radius: 16px;
        padding: 18px 20px;
        margin-top: -18px;
        position: relative;
        z-index: 10;
    }
    .btn-search {
        background: #43a047;
        color: white;
        border-radius: 10px;
        padding: 10px 25px;
    }
    .btn-search:hover {
        background: #388e3c;
        color: white;
    }
    .badge-date {
        background: rgba(26, 92, 42, 0.1);
        color: #43a047;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .badge-view {
        background: rgba(0, 123, 255, 0.1);
        color: #007bff;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>

{{-- Header Hijau --}}
<div style="background: #43a047; padding: 40px 0 32px 0; color: white;">
    <div class="container text-center">
        <h2 class="fw-bold mb-2" style="font-size: 1.6rem;">📰 Berita & Informasi</h2>
        <p class="opacity-75 mb-0" style="font-size: 0.95rem;">Kabar terbaru dari Taman Herbal Kebun Raya Universitas Pahlawan</p>
    </div>
</div>

<div class="container mb-5">
    {{-- Search Bar dimunculkan kembali dengan rapi --}}
    <div class="search-section shadow-sm mx-auto" style="max-width: 900px;">
        <form action="{{ route('berita') }}" method="GET">
            <div class="row g-2">
                <div class="col-md-9">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="cari" class="form-control border-start-0 ps-0" placeholder="Cari judul berita..." value="{{ request('cari') }}">
                    </div>
                </div>
                <div class="col-md-3 d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-search flex-grow-1">Cari</button>
                    @if(request('cari'))
                        <a href="{{ route('berita') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Daftar Berita --}}
    <div class="row mt-4 g-4">
        @forelse($beritas as $b)
        <div class="col-md-4">
            <div class="card h-100 news-card shadow-sm">
                <div class="position-relative bg-light">
                    {{-- SINKRONISASI: Mengganti $b->gambar menjadi $b->foto sesuai dengan controller --}}
                    @if(Str::contains($b->foto, 'berita/'))
                        <img src="{{ asset('storage/' . $b->foto) }}" class="card-img-top news-img" alt="{{ $b->judul }}">
                    @else
                        <img src="{{ asset('storage/berita/' . $b->foto) }}" class="card-img-top news-img" alt="{{ $b->judul }}">
                    @endif
                </div>
                <div class="card-body p-4">
                    <div class="d-flex gap-2 mb-3">
                        <span class="badge badge-date">
                            <i class="bi bi-calendar3 me-1"></i> {{ $b->created_at->format('d M Y') }}
                        </span>
                        <span class="badge badge-view">
                            <i class="bi bi-eye me-1"></i> {{ $b->views }} views
                        </span>
                    </div>
                    
                    <h5 class="fw-bold text-dark mb-3 line-clamp-2" style="min-height: 3rem; line-height: 1.4;">{{ $b->judul }}</h5>
                    <p class="text-muted small mb-4">
                        {{ Str::limit(strip_tags($b->isi), 100) }}
                    </p>
                    <a href="{{ route('berita.detail', $b->slug) }}" class="btn btn-link text-success p-0 fw-bold text-decoration-none">
                        Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="https://illustrations.popsy.co/green/falling.svg" style="width: 200px;" alt="Data tidak ditemukan">
            <p class="text-muted mt-3">Maaf, berita yang kamu cari tidak ditemukan.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $beritas->links() }}
    </div>
</div>

@endsection