@extends('layouts.app')
@section('title', 'Beranda')

@section('content')
<div id="beritaCarousel" class="carousel slide shadow" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-indicators">
        @foreach($beritaCarousel as $key => $b)
            <button type="button" data-bs-target="#beritaCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></button>
        @endforeach
    </div>
    
    <div class="carousel-inner">
        @forelse($beritaCarousel as $key => $b)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
            <div style="height: 500px; background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('{{ Storage::url($b->foto) }}'); background-size: cover; background-position: center;" class="d-flex align-items-center">
                <div class="container text-white">
                    <div class="row">
                        <div class="col-lg-8">
                            <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold">⭐ Berita Taman Koleksi Tanaman Obat</span>
                            <h1 class="display-4 fw-bold mb-3">{{ $b->judul }}</h1>
                            <p class="lead mb-4 opacity-75">{{ Str::limit(strip_tags($b->isi), 160) }}</p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('berita.detail', $b->slug) }}" class="btn btn-warning btn-lg px-4 fw-bold shadow">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="carousel-item active">
            <div style="height: 450px; background: #1a5c2a;" class="d-flex align-items-center text-center">
                <div class="container text-white">
                    <h1 class="display-4 fw-bold">Selamat Datang di SITOBAT</h1>
                    <p class="lead">Sistem Informasi Tanaman Obat Kebun Raya Universitas Pahlawan</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#beritaCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
    <button class="carousel-control-next" type="button" data-bs-target="#beritaCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
</div>

<section class="py-5 bg-light border-bottom">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h6 class="text-success fw-bold text-uppercase mb-2">Tentang SITOBAT</h6>
                <h2 class="fw-bold mb-4" style="color: #1a5c2a;">Digitalisasi Informasi Tanaman Obat Kebun Raya Universitas Pahlawan</h2>
                <p class="text-muted mb-4" style="text-align: justify;">
                    SITOBAT merupakan platform digital Kebun Raya Universitas Pahlawan yang dirancang untuk memudahkan masyarakat dalam mengenali berbagai jenis tanaman obat. Kami mengintegrasikan teknologi QR Code untuk akses informasi yang cepat, akurat, dan edukatif.
                </p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 bg-white shadow-sm rounded-3 border-start border-4 border-success">
                            <h5 class="fw-bold mb-1">{{ $totalTanaman }}+</h5>
                            <small class="text-muted">Spesies Tanaman</small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-white shadow-sm rounded-3 border-start border-4 border-warning">
                            <h5 class="fw-bold mb-1">Edukasi</h5>
                            <small class="text-muted">Informasi Tanaman Obat</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 20px;">
                    <div class="card-body p-4 p-md-5" style="background: #f8fff9;">
                        <h4 class="fw-bold mb-4 text-center">Bagaimana Cara Scan QR?</h4>
                        <div class="d-flex mb-4 gap-3">
                            <div class="flex-shrink-0 bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">1</div>
                            <div>
                                <h6 class="fw-bold mb-1">Temukan Kode QR</h6>
                                <p class="text-muted small mb-0">Cari papan informasi tanaman obat di area Taman Koleksi Tanaman Obat Kebun Raya Universitas Pahlawan.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-4 gap-3">
                            <div class="flex-shrink-0 bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">2</div>
                            <div>
                                <h6 class="fw-bold mb-1">Buka Kamera HP</h6>
                                <p class="text-muted small mb-0">Gunakan aplikasi kamera smartphone Anda.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0 bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">3</div>
                            <div>
                                <h6 class="fw-bold mb-1">Lihat Detail</h6>
                                <p class="text-muted small mb-0">Klik tautan yang muncul untuk membuka detail tanaman.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4 bg-white border-bottom">
    <div class="container">
        <div class="p-4 shadow-sm rounded-4 border bg-white">
            <div class="row align-items-center">
                <div class="col-md-3 border-end text-center text-md-start">
                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Akses Online</h6>
                    <h3 class="fw-bold text-success mb-0">SITOBAT-UP</h3>
                </div>
                <div class="col-md-9 ps-md-4 mt-3 mt-md-0">
                    <h6 class="fw-bold mb-2 small"><i class="bi bi-globe2 text-primary me-2"></i>Jangkauan Akses Berdasarkan Negara:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($statsNegara as $sn)
                        <span class="badge bg-light text-dark border py-2 px-3 fw-normal">
                            📍 {{ $sn->asal_negara }}: <span class="fw-bold text-success">{{ $sn->total }}</span>
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-0" style="color: #1a5c2a;">Tanaman Terpopuler</h2>
                <p class="text-muted">Koleksi yang paling sering dilihat</p>
            </div>
            <a href="{{ route('katalog') }}" class="btn btn-outline-success rounded-pill px-4">Lihat Semua</a>
        </div>
        <div class="row g-4">
            @foreach($tanamanPopuler as $tanaman)
            <div class="col-6 col-lg-2">
                <a href="{{ route('tanaman.detail', $tanaman->slug) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-hover">
                        @if($tanaman->foto)
                            <img src="{{ Storage::url($tanaman->foto) }}" class="card-img-top" style="height:150px; object-fit:cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height:150px;">🌿</div>
                        @endif
                        <div class="p-3 text-center">
                            <div class="fw-bold text-dark small mb-1 text-truncate">{{ $tanaman->nama }}</div>
                            <div class="text-muted italic" style="font-size: .7rem; font-style: italic;">{{ $tanaman->nama_ilmiah }}</div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .card-hover:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection