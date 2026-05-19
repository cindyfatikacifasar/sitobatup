@extends('layouts.app')
@section('title', 'Katalog Tanaman Obat')

@section('content')
{{-- HEADER HIJAU MELENGKUNG IDENTIK DENGAN HALAMAN BERITA --}}
<div class="py-5 text-center text-white" style="background-color: #1a5c2a; border-radius: 0 0 50px 50px; margin-top: -24px;">
    <div class="container">
        <h2 class="fw-bold mb-2">🌿 Katalog Tanaman Obat</h2>
        <p class="lead small opacity-75 mb-0">Taman Koleksi Kebun Raya Universitas Pahlawan &mdash; {{ $tanaman->total() }} tanaman ditemukan</p>
    </div>
</div>

{{-- BOX PENCARIAN DI TENGAH (MELAYANG IDENTIK 100% DENGAN BERITA) --}}
<div class="container" style="margin-top: -32px; margin-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <form method="GET" action="{{ route('katalog') }}" class="d-flex gap-2 align-items-center bg-white p-3 shadow-sm" style="border-radius: 15px;">
                {{-- Input dengan Ikon Kaca Pembesar di Dalam --}}
                <div class="position-relative flex-grow-1">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" name="search" class="form-control py-2 ps-5 text-dark" placeholder="Cari tanaman obat..." value="{{ request('search') }}" style="border-radius: 10px; border: 1px solid #ced4da; box-shadow: none; font-size: 0.95rem;">
                </div>
                {{-- Tombol Cari Hijau Tua Melengkung Terpisah --}}
                <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #1a5c2a; border-color: #1a5c2a; border-radius: 10px; min-width: 110px;">
                    Cari
                </button>
            </form>
        </div>
    </div>
</div>

{{-- GRID TANAMAN UTAMA (MEMENUHI HALAMAN TANPA SIDEBAR) --}}
<div class="container py-2">
    @if($tanaman->count() === 0)
        <div class="text-center py-5">
            <div style="font-size:4rem;">🔍</div>
            <h5 class="text-muted mt-2">Tanaman tidak ditemukan</h5>
            <p class="text-muted">Coba ubah kata kunci pencarian Anda</p>
            <a href="{{ route('katalog') }}" class="btn btn-success" style="background-color: #1a5c2a; border-color: #1a5c2a; border-radius: 8px;">Reset Pencarian</a>
        </div>
    @else
        {{-- Menggunakan row-cols agar otomatis responsif dan seimbang --}}
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($tanaman as $item)
            <div class="col">
                <a href="{{ route('tanaman.detail', $item->slug) }}" class="text-decoration-none">
                    <div class="card-tanaman h-100 shadow-sm border-0" style="border-radius: 12px; transition: 0.3s; background: white; overflow: hidden;">
                        {{-- Bagian Foto Tanaman --}}
                        <div style="height:180px; overflow:hidden; background:linear-gradient(135deg,#e8f5e9,#c8e6c9); display:flex; align-items:center; justify-content:center; position:relative;">
                            @if($item->foto)
                                <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama }}" style="width:100%; height:180px; object-fit:cover;">
                            @else
                                <span style="font-size:3.5rem;">🌿</span>
                            @endif
                            
                            @if($item->status_ketersediaan === 'tidak_tersedia')
                                <div style="position:absolute; top:8px; right:8px; background:rgba(220,53,69,.85); color:white; border-radius:6px; padding:2px 8px; font-size:.7rem; font-weight:600;">Tidak Tersedia</div>
                            @endif
                        </div>
                        
                        {{-- Detail Teks --}}
                        <div class="p-3">
                            <h6 class="fw-bold text-dark mb-1" style="font-size:.95rem;">{{ $item->nama }}</h6>
                            <div class="text-muted small" style="font-style:italic; margin-bottom:8px;">{{ $item->nama_ilmiah }}</div>
                            <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top border-light">
                                <span class="text-muted" style="font-size:.75rem;"><i class="bi bi-eye-fill text-success"></i> {{ number_format($item->views) }} views</span>
                                
                                @if($item->kategoris && $item->kategoris->isNotEmpty())
                                    <span class="badge" style="background:#e8f5e9; color:#1a5c2a; font-size:.65rem;">{{ $item->kategoris->first()->nama }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $tanaman->links() }}
        </div>
    @endif
</div>

<style>
    .card-tanaman:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection