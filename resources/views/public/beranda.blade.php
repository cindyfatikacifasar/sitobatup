@extends('layouts.app')
@section('title', 'Beranda')

@section('content')
<style>
    .carousel-item-custom {
        height: 600px !important;
        background-color: #1a5c2a !important;
        background-position: center !important;
        background-size: cover !important;
        background-repeat: no-repeat !important;
        position: relative;
    }

    .carousel-caption-custom {
        position: absolute;
        z-index: 10 !important;
        text-align: left !important;
        left: 10% !important;
        bottom: 15% !important;
        right: auto !important;
        max-width: 680px !important;
        text-shadow: 2px 2px 12px rgba(0,0,0,0.8);
    }

    .btn-baca-baru {
        background-color: #ffc107 !important;
        color: #000 !important;
        font-weight: 700;
        padding: 12px 32px;
        border-radius: 50px;
        text-decoration: none;
        display: inline-block;
        transition: 0.3s ease-in-out;
    }

    .btn-baca-baru:hover {
        background-color: #e0a800;
        color: #000 !important;
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
    }

    @media (max-width: 768px) {
        .carousel-item-custom { height: 420px !important; }
        .carousel-caption-custom { left: 5% !important; bottom: 10% !important; max-width: 90% !important; }
        .carousel-caption-custom h1 { font-size: 1.8rem !important; }
        .carousel-caption-custom p { font-size: 0.85rem !important; }
    }

    /* ── Peta Lokasi ── */
    .peta-info-box {
        background: #fff;
        border-radius: 0 0 20px 20px;
        padding: 12px 20px;
        border: 1px solid #e8f5ec;
        border-top: none;
    }
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 10px;
    }
    .info-item:last-child { margin-bottom: 0; }
    .info-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #e8f5ec;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #1a5c2a;
        font-size: 15px;
    }
    .btn-gmaps {
        background: linear-gradient(135deg, #1a5c2a, #2d8a4e);
        color: #fff !important;
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 50px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
        font-size: 15px;
        border: none;
        justify-content: center;
    }
    .btn-gmaps:hover {
        background: linear-gradient(135deg, #2d8a4e, #1a5c2a);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(26,92,42,0.35);
        color: #fff !important;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .iframe-wrapper {
        border-radius: 20px 20px 0 0;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(26,92,42,0.12);
    }
</style>

<div id="beritaCarousel" class="carousel slide shadow" data-bs-ride="carousel" data-bs-interval="3000" data-bs-pause="false">
    <div class="carousel-indicators">
        @foreach($beritaCarousel as $key => $b)
            <button type="button" data-bs-target="#beritaCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></button>
        @endforeach
    </div>

    <div class="carousel-inner" style="overflow: hidden; border-radius: 0 0 25px 25px;">
        @forelse($beritaCarousel as $key => $b)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
            <div class="carousel-item-custom d-flex align-items-center"
                 style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.65)), url('{{ Storage::url($b->foto) }}');">
                <div class="container">
                    <div class="carousel-caption-custom text-white">
                        <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold shadow-sm">
                            ⭐ Berita Taman Koleksi Tanaman Obat
                        </span>
                        <h1 class="display-5 fw-bold mb-3" style="line-height: 1.2;">{{ $b->judul }}</h1>
                        <p class="lead mb-4 opacity-90" style="font-size: 1.05rem; line-height: 1.6;">{{ Str::limit(strip_tags($b->isi), 160) }}</p>
                        <div>
                            <a href="{{ route('berita.detail', $b->slug) }}" class="btn-baca-baru shadow">Baca Selengkapnya</a>
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
    <button class="carousel-control-prev" type="button" data-bs-target="#beritaCarousel" data-bs-slide="prev" style="z-index: 12;">
        <span class="carousel-control-prev-icon p-3 bg-dark bg-opacity-25 rounded-circle"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#beritaCarousel" data-bs-slide="next" style="z-index: 12;">
        <span class="carousel-control-next-icon p-3 bg-dark bg-opacity-25 rounded-circle"></span>
    </button>
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

<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-0" style="color: #1a5c2a;">Tanaman Terpopuler</h2>
                <p class="text-muted mb-0">Koleksi yang paling sering dilihat</p>
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
                            <div class="text-muted italic" style="font-size: .7rem; font-style: italic;">{{ $tanaman_ilmiah ?? $tanaman->nama_ilmiah }}</div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ✅ SECTION PETA LOKASI --}}
<section class="py-5 bg-light border-top border-bottom">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-success fw-bold text-uppercase mb-2">
                <i class="bi bi-geo-alt-fill me-1"></i>Lokasi Kami
            </h6>
            <h2 class="fw-bold" style="color: #1a5c2a;">Temukan Taman Koleksi Tanaman Obat</h2>
            <p class="text-muted">Kebun Raya Universitas Pahlawan Tuanku Tambusai, Bangkinang, Riau</p>
        </div>

        <div class="row g-4 align-items-stretch">

            {{-- Kolom Kiri: Iframe Google Maps --}}
            <div class="col-lg-7">
                <div class="iframe-wrapper">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.5!2d101.00499!3d0.33360!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5150010bccb33%3A0xa8fef12ef08d1df0!2sTaman%20Koleksi%20Tanaman%20Obat%2C%20Balai%20Bumi%20Perkemahan%20UP!5e0!3m2!1sid!2sid!4v1718500000000"
                        width="100%"
                        height="320"
                        style="border:0; display:block;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Peta Lokasi Taman Koleksi Tanaman Obat Kebun Raya UP">
                    </iframe>
                </div>
                <div class="peta-info-box">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-hand-index-thumb text-success"></i>
                        <span class="text-muted small">Klik peta untuk membuka dan menjelajahi lokasi di Google Maps</span>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Info Alamat + Tombol --}}
            <div class="col-lg-5">
                <div class="h-100 d-flex flex-column justify-content-between bg-white rounded-4 shadow-sm p-4 border" style="border-color: #e8f5ec !important;">

                    <div>
                        <h5 class="fw-bold mb-4" style="color: #1a5c2a;">
                            <i class="bi bi-building-fill me-2"></i>Informasi Lokasi
                        </h5>

                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                            <div>
                                <div class="fw-bold small text-dark">Alamat</div>
                                <div class="text-muted small">Jl. Tuanku Tambusai No.23, Bangkinang, Kab. Kampar, Riau 28412</div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-building"></i></div>
                            <div>
                                <div class="fw-bold small text-dark">Institusi</div>
                                <div class="text-muted small">Universitas Pahlawan Tuanku Tambusai</div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-tree-fill"></i></div>
                            <div>
                                <div class="fw-bold small text-dark">Area</div>
                                <div class="text-muted small">Taman Koleksi Tanaman Obat — Kebun Raya UP</div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-clock-fill"></i></div>
                            <div>
                                <div class="fw-bold small text-dark">Jam Operasional</div>
                                <div class="text-muted small">Senin – Jumat: 08.00 – 16.00 WIB</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="https://maps.app.goo.gl/H35sxm1UYg9pKtHc7"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn-gmaps w-100">
                            <i class="bi bi-map-fill"></i> Buka di Google Maps
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
{{-- ✅ AKHIR SECTION PETA LOKASI --}}

<section class="py-5 bg-light border-top">
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
                        <span class="badge bg-light text-dark border py-2 px-3 fw-normal" style="font-size: 0.85rem;">
                            📍 {{ $sn->asal_negara }}: <span class="fw-bold text-success">{{ $sn->total }}</span>
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection