<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SITOBAT-UP') | Sistem Informasi Tanaman Obat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --hijau-tua: #1a5c2a;
            --hijau-mid: #2d8a4e;
            --hijau-muda: #4caf72;
        }
        * { font-family: 'Poppins', sans-serif; }
        body { background: #f8faf8; }

        .navbar-sitobat {
            background: linear-gradient(135deg, var(--hijau-tua) 0%, var(--hijau-mid) 100%);
            box-shadow: 0 2px 15px rgba(26,92,42,0.3);
            padding: 12px 0;
        }
        .navbar-brand-text { color: #fff !important; font-weight: 700; font-size: 1.4rem; line-height: 1.1; }
        .navbar-brand-sub  { font-size: 0.65rem; font-weight: 400; color: #fff !important; opacity: 1; display: block; }
        .navbar-sitobat .nav-link { color: rgba(255,255,255,0.88) !important; font-weight: 500; transition: all .2s; padding: 8px 14px !important; border-radius: 6px; }
        .navbar-sitobat .nav-link:hover, .navbar-sitobat .nav-link.active { color: #fff !important; background: rgba(255,255,255,0.15); }
        
        .footer-main { background: var(--hijau-tua); color: rgba(255,255,255,0.85); padding: 50px 0 20px; }
        .footer-main h5 { color: white; font-weight: 700; margin-bottom: 16px; }
        .footer-main a { color: rgba(255,255,255,0.75); text-decoration: none; }
        .footer-main a:hover { color: white; }
        .footer-bottom { background: rgba(0,0,0,0.2); padding: 14px 0; text-align: center; color: rgba(255,255,255,0.6); font-size: .85rem; }

        /* =====================
        SOLUSI FINAL SLIDER (KHUSUS BACKGROUND)
        ======================== */
        .carousel-item {
            height: 600px !important;
            background-color: #000 !important;
            background-position: center !important;
            background-size: cover !important; /* MENGHILANGKAN KOTAK HITAM */
            background-repeat: no-repeat !important;
            position: relative;
        }

        /* Overlay Gelap agar teks putih terbaca */
        .carousel-item::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); 
            z-index: 1;
        }

        .carousel-caption {
            z-index: 10 !important;
            text-align: left !important;
            left: 10% !important;
            bottom: 15% !important;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.9);
        }

        .carousel-caption h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .btn-baca-baru {
            background-color: #ffc107 !important;
            color: #000 !important;
            font-weight: 700;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-baca-baru:hover {
            background-color: #e0a800;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .carousel-item { height: 400px !important; }
            .carousel-caption h1 { font-size: 2rem; }
        }

        /* CSS Penanda Aktif di Navbar */
        .nav-custom {
            display: flex;
            align-items: center;
            height: 100%;
            padding: 0.5rem 0.8rem !important;
            color: rgba(255,255,255,0.85) !important;
            position: relative;
            font-size: 14px;
            transition: 0.3s;
            white-space: nowrap; /* PERBAIKAN: Mencegah tulisan Sitobat-AI patah ke bawah */
        }
        
        .nav-custom.active-link {
            color: #ffffff !important;
            font-weight: 700;
        }

        .nav-custom.active-link::after {
            content: "";
            position: absolute;
            bottom: -5px; /* Jarak garis bawah dari teks */
            left: 10px;
            right: 10px;
            height: 3px;
            background: #ffffff;
            border-radius: 10px;
        }

        /* Penyesuaian Sitobat-AI dan Login */
        .navbar-nav .nav-item {
            display: flex;
            align-items: center;
        }

        /* PERBAIKAN UI/UX: Desain Mewah Tombol Login Publik */
        .btn-login-custom {
            background-color: rgba(255, 255, 255, 0.18) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.4) !important;
            padding: 7px 18px !important;
            border-radius: 8px !important;
            font-size: 14px;
            transition: all 0.2s ease-in-out;
        }

        .btn-login-custom:hover {
            background-color: #ffffff !important;
            color: var(--hijau-tua) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-sitobat sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">🌿</div>
            <div>
                <span class="navbar-brand-text">SITOBAT-UP</span>
                <span class="navbar-brand-sub">Taman Koleksi Tanaman Obat Kebun Raya Universitas Pahlawan</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                {{-- Home --}}
                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('/') ? 'active-link' : '' }}" href="{{ url('/') }}">
                        <i class="bi bi-house me-1"></i>Beranda
                    </a>
                </li>
                
                {{-- Katalog --}}
                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('katalog*') ? 'active-link' : '' }}" href="{{ url('/katalog') }}">
                        <i class="bi bi-grid me-1"></i>Tanaman Obat
                    </a>
                </li>

                {{-- Galeri --}}
                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('galeri*') ? 'active-link' : '' }}" href="{{ url('/galeri') }}">
                        <i class="bi bi-images me-1"></i>Galeri
                    </a>
                </li>

                {{-- Berita --}}
                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('berita*') ? 'active-link' : '' }}" href="{{ url('/berita') }}">
                        <i class="bi bi-newspaper me-1"></i>Berita
                    </a>
                </li>

                {{-- Ulasan --}}
                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('ulasan*') ? 'active-link' : '' }}" href="{{ url('/ulasan') }}">
                        <i class="bi bi-chat-dots me-1"></i>Ulasan
                    </a>
                </li>



                {{-- Tombol Login (SUDAH DISULAP JADI HIGHLIGHT PUTIH PREMIUM COCOK UI/UX) --}}
                <li class="nav-item ms-lg-2">
                    @auth
                        <a href="{{ auth()->user()->role == 'admin' ? url('/admin/dashboard') : url('/pj/dashboard') }}" 
                        class="btn btn-login-custom d-flex align-items-center fw-bold">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                        class="btn btn-login-custom d-flex align-items-center fw-bold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<footer class="footer-main mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <h5>🌿 SITOBAT-UP</h5>
                <p style="font-size:.9rem;">Sistem Informasi Tanaman Obat Taman Koleksi Kebun Raya Universitas Pahlawan Tuanku Tambusai, Bangkinang, Riau.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>Kontak</h5>
                <ul class="list-unstyled" style="font-size:.9rem;">
                    <li><i class="bi bi-geo-alt me-2"></i>Bangkinang, Kab. Kampar, Riau</li>
                    <li><i class="bi bi-building me-2"></i>Universitas Pahlawan</li>
  
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom mt-4">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} SITOBAT-UP — Cindy Fatika Sari.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>