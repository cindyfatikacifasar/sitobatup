@extends('layouts.app')
@section('title', 'Galeri Dokumentasi')
@section('content')

<style>
    .album-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        background: #fff;
        overflow: hidden;
    }
    .album-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
    }
    .cover-wrapper {
        height: 210px;
        width: 100%;
        background: #e8f5e9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1a5c2a;
        position: relative;
        overflow: hidden;
    }
    .cover-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .album-card:hover .cover-img {
        transform: scale(1.08);
    }
    .cover-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4) 100%);
    }
    .badge-count {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(26, 92, 42, 0.9);
        backdrop-filter: blur(4px);
        color: white;
        font-size: 0.75rem;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>

{{-- HEADER HIJAU MELENGKUNG: IDENTIK 100% DENGAN HALAMAN BERITA --}}
<div class="py-5 text-center text-white" style="background-color: #1a5c2a; border-radius: 0 0 50px 50px; margin-top: -24px; padding-bottom: 60px !important;">
    <div class="container">
        <h2 class="fw-bold mb-2">📸 Galeri Dokumentasi</h2>
        <p class="lead small opacity-75 mb-0">Eksplorasi Kegiatan & Koleksi Tanaman Obat Universitas Pahlawan</p>
    </div>
</div>

<div class="container mb-5">
    {{-- BOX PENCARIAN DI TENGAH: MELAYANG IDENTIK DENGAN BERITA & KATALOG --}}
    <div class="row justify-content-center" style="margin-top: -32px; margin-bottom: 50px; position: relative; z-index: 10;">
        <div class="col-md-8 col-lg-7">
            <div class="bg-white p-3 shadow-sm" style="border-radius: 15px;">
                <form action="{{ route('public.galeri') }}" method="GET" class="d-flex gap-2 align-items-center">
                    {{-- Input dengan Ikon Kaca Pembesar di Sisi Kiri Dalam --}}
                    <div class="position-relative flex-grow-1">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" name="cari" class="form-control py-2 ps-5 text-dark" placeholder="Cari nama atau tema album kegiatan..." value="{{ $cari ?? '' }}" style="border-radius: 10px; border: 1px solid #ced4da; box-shadow: none; font-size: 0.95rem;">
                    </div>
                    {{-- Tombol Cari Hijau Tua Melengkung Terpisah --}}
                    <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #1a5c2a; border-color: #1a5c2a; border-radius: 10px; min-width: 110px;">
                        Cari
                    </button>
                </form>
                
                {{-- Notifikasi Filter Reset Bawaan --}}
                @if($cari)
                    <div class="text-center mt-2 pt-2 border-top border-light">
                        <span class="badge bg-light text-dark p-2" style="font-size: 0.75rem;">Hasil pencarian untuk: "{{ $cari }}"</span>
                        <a href="{{ route('public.galeri') }}" class="d-block small text-success fw-bold text-decoration-none mt-1" style="font-size: 0.8rem;">🔄 Reset Pencarian</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Grid Album --}}
    <div class="row g-4">
        @forelse($albums as $album)
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('galeri.album', $album->id) }}" class="text-decoration-none">
                <div class="card h-100 album-card shadow-sm">
                    <div class="cover-wrapper">
                        <span class="badge-count">
                            <i class="bi bi-images me-1"></i> {{ $album->galeris_count }} Item
                        </span>
                        
                        @if($album->galeris->isNotEmpty())
                            {{-- PERBAIKAN: Menggunakan Storage::url() agar path link file dibaca sempurna oleh Windows symlink --}}
                            <img src="{{ Storage::url($album->galeris->first()->foto) }}" class="cover-img" alt="Cover {{ $album->nama_album }}">
                            <div class="cover-overlay"></div>
                        @else
                            {{-- Jika kosong, beri gambar placeholder hijau estetik --}}
                            <div class="text-center opacity-50">
                                <i class="bi bi-image fs-1 d-block mb-1"></i>
                                <small class="fw-bold">Belum Ada Foto</small>
                            </div>
                        @endif
                    </div>

                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-2 line-clamp-2" style="min-height: 2.8rem; line-height: 1.4; font-size: 1rem;">
                            {{ $album->nama_album }}
                        </h5>
                        <div class="text-muted small d-flex align-items-center gap-1">
                            <i class="bi bi-calendar3"></i> {{ $album->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="bi bi-folder-x" style="font-size: 4rem; color: #1a5c2a;"></i>
            <h5 class="mt-3 fw-bold">Album Tidak Ditemukan</h5>
            <p class="small">Silakan coba cari dengan kata kunci dokumentasi yang lain.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $albums->links() }}
    </div>
</div>

@endsection