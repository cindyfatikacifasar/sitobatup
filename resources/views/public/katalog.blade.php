@extends('layouts.app')
@section('title', 'Katalog Tanaman Obat')

@section('content')
<div style="background:linear-gradient(135deg,#1a5c2a,#2d8a4e);padding:40px 0 30px;color:white;">
    <div class="container">
        <h1 class="h3 fw-bold mb-1">🌿 Katalog Tanaman Obat</h1>
        <p class="mb-0" style="opacity:.85;font-size:.9rem;">Taman Koleksi Kebun Raya Universitas Pahlawan &mdash; {{ $tanaman->total() }} tanaman ditemukan</p>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <!-- Sidebar Filter -->
        <div class="col-lg-3">
            <!-- PERBAIKAN: Menambahkan top: 100px agar tidak menutupi navbar/logo saat di-scroll -->
            <div class="card sticky-top shadow-sm" style="top:100px; z-index: 10; border: none; border-radius: 12px;">
                <div class="card-header fw-bold" style="background:#e8f5e9;color:#1a5c2a; border-radius: 12px 12px 0 0; border: none;">
                    <i class="bi bi-funnel me-2"></i>Filter Pencarian
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('katalog') }}">
                        <div class="mb-3">
                            <label class="form-label fw-600" style="font-size:.85rem;">🔍 Cari Tanaman</label>
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Nama tanaman..." value="{{ request('search') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-600" style="font-size:.85rem;">🏷️ Kategori Khasiat</label>
                            <select name="kategori" class="form-select form-select-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $k)
                                <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-600" style="font-size:.85rem;">🌱 Bagian Digunakan</label>
                            <select name="bagian" class="form-select form-select-sm">
                                <option value="">Semua Bagian</option>
                                @foreach($bagians as $b)
                                <option value="{{ $b }}" {{ request('bagian') == $b ? 'selected' : '' }}>{{ ucfirst($b) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-600" style="font-size:.85rem;">📦 Ketersediaan</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Semua Status</option>
                                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="tidak_tersedia" {{ request('status') == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-sm fw-bold">
                                <i class="bi bi-search me-1"></i>Cari
                            </button>
                            <a href="{{ route('katalog') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Grid Tanaman -->
        <div class="col-lg-9">
            @if($tanaman->count() === 0)
            <div class="text-center py-5">
                <div style="font-size:4rem;">🔍</div>
                <h5 class="text-muted mt-2">Tanaman tidak ditemukan</h5>
                <p class="text-muted">Coba ubah kata kunci atau filter pencarian</p>
                <a href="{{ route('katalog') }}" class="btn btn-success">Reset Pencarian</a>
            </div>
            @else
            <div class="row g-3">
                @foreach($tanaman as $item)
                <div class="col-6 col-md-4">
                    <a href="{{ route('tanaman.detail', $item->slug) }}" class="text-decoration-none">
                        <div class="card-tanaman h-100 shadow-sm border-0" style="border-radius: 12px; transition: 0.3s; background: white; overflow: hidden;">
                            <div style="height:160px;overflow:hidden;background:linear-gradient(135deg,#e8f5e9,#c8e6c9);display:flex;align-items:center;justify-content:center;position:relative;">
                                @if($item->foto)
                                    <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama }}" style="width:100%;height:160px;object-fit:cover;">
                                @else
                                    <span style="font-size:3.5rem;">🌿</span>
                                @endif
                                
                                @if($item->status_ketersediaan === 'tidak_tersedia')
                                <div style="position:absolute;top:8px;right:8px;background:rgba(220,53,69,.85);color:white;border-radius:6px;padding:2px 8px;font-size:.7rem;font-weight:600;">Tidak Tersedia</div>
                                @endif
                            </div>
                            <div class="p-3">
                                <span class="badge mb-1" style="background:#e8f5e9; color:#1a5c2a; font-size: .7rem;">{{ ucfirst($item->bagian_digunakan ?? '-') }}</span>
                                <h6 class="fw-bold text-dark mb-0" style="font-size:.9rem;">{{ $item->nama }}</h6>
                                <div class="text-muted" style="font-size:.78rem;font-style:italic;margin-bottom:6px;">{{ $item->nama_ilmiah }}</div>
                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <span style="font-size:.72rem;color:#2d8a4e;"><i class="bi bi-eye"></i> {{ number_format($item->views) }} views</span>
                                    <!-- Menampilkan kategori jika ada (Many-to-Many atau Many-to-One) -->
                                    @if($item->kategoris->isNotEmpty())
                                        <span class="badge" style="background:#f3e5f5;color:#7b1fa2;font-size:.65rem;">{{ $item->kategoris->first()->nama }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $tanaman->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .card-tanaman:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .fw-600 { font-weight: 600; }
</style>
@endsection