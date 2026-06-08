<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

        /* 🌐 CSS DROP-DOWN BAHASA */
        .lang-dropdown .dropdown-toggle {
            background: rgba(255,255,255,0.12) !important;
            border: 1px solid rgba(255,255,255,0.3) !important;
            color: white !important; font-size: 13px; font-weight: 600;
            padding: 7px 14px !important; border-radius: 30px !important;
            transition: all 0.2s ease-in-out;
        }
        .lang-dropdown .dropdown-toggle:hover { background: rgba(255,255,255,0.25) !important; }
        .lang-dropdown .dropdown-menu { border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.15); border: none; padding: 6px; margin-top: 8px; }
        .lang-dropdown .dropdown-item { font-size: 0.85rem; font-weight: 500; border-radius: 8px; padding: 8px 14px; color: #333; }
        .lang-dropdown .dropdown-item:hover { background-color: #f0fdf4; color: var(--hijau-tua); }
        .lang-dropdown .dropdown-item.active { background-color: var(--hijau-mid); color: white; }

        /* =====================
        SOLUSI FINAL SLIDER (KHUSUS BACKGROUND)
        ======================== */
        .carousel-item {
            height: 600px !important;
            background-color: #000 !important;
            background-position: center !important;
            background-size: cover !important;
            background-repeat: no-repeat !important;
            position: relative;
        }

        .carousel-item::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
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
        .btn-baca-baru:hover { background-color: #e0a800; transform: scale(1.05); }

        @media (max-width: 768px) {
            .carousel-item { height: 400px !important; }
            .carousel-caption h1 { font-size: 2rem; }
            .dropdown-menu-end { left: 0 !important; right: auto !important; }
        }

        /* ⚡ DEFAULT NAV STYLE (UKURAN NORMAL 14px) */
        .nav-custom {
            display: flex;
            align-items: center;
            height: 100%;
            padding: 0.5rem 0.8rem !important; 
            color: rgba(255,255,255,0.85) !important;
            position: relative;
            font-size: 14px; 
            transition: 0.3s;
            white-space: nowrap;
        }
        
        .nav-custom.active-link { color: #ffffff !important; font-weight: 700; }
        .nav-custom.active-link::after {
            content: ""; position: absolute; bottom: -5px; 
            left: 10px; right: 10px; height: 3px;
            background: #ffffff; border-radius: 10px;
        }

        .navbar-nav .nav-item { display: flex; align-items: center; }

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

        /* ⚡ JAWABAN SOLUSI: Otomatis Mengecil HANYA SAAT BAHASA MANDARIN AKTIF di Layar Laptop */
        @media (min-width: 992px) and (max-width: 1366px) {
            html[lang="zh"] .navbar-brand-sub { display: none !important; }
            html[lang="zh"] .nav-custom { font-size: 11.5px; padding: 0.5rem 0.35rem !important; }
            html[lang="zh"] .nav-custom.active-link::after { left: 4px; right: 4px; }
            html[lang="zh"] .btn-login-custom { padding: 6px 12px !important; font-size: 12px; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-sitobat sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            {{-- 📦 KOTAK PENGAMAN: Menjaga space teks tetap 45px agar tulisan & navbar tidak melar atau rusak --}}
            <div style="width: 45px; height: 45px; position: relative; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                {{-- ⚡ REVISI LOGO: Memperbesar GAMBARNYA SAJA (115px) meluap indah dan sejajar lurus tanpa menggeser elemen lain --}}
                <img src="{{ asset('assets/img/logo-sitobat.png') }}" 
                     alt="" 
                     style="height: 115px; width: 115px; max-width: none; object-fit: contain; position: absolute; filter: brightness(1.25) contrast(1.2) drop-shadow(0px 0px 10px rgba(255, 255, 255, 0.95)) drop-shadow(0px 3px 6px rgba(0,0,0,0.35));">            </div>
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
                        <i class="bi bi-house me-1"></i>{{ __('Beranda') }}
                    </a>
                </li>
                
                {{-- Katalog --}}
                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('katalog*') ? 'active-link' : '' }}" href="{{ url('/katalog') }}">
                        <i class="bi bi-grid me-1"></i>{{ __('Tanaman Obat') }}
                    </a>
                </li>

                {{-- Galeri --}}
                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('galeri*') ? 'active-link' : '' }}" href="{{ url('/galeri') }}">
                        <i class="bi bi-images me-1"></i>{{ __('Galeri') }}
                    </a>
                </li>

                {{-- Berita --}}
                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('berita*') ? 'active-link' : '' }}" href="{{ url('/berita') }}">
                        <i class="bi bi-newspaper me-1"></i>{{ __('Berita') }}
                    </a>
                </li>

                {{-- Ulasan --}}
                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('ulasan*') ? 'active-link' : '' }}" href="{{ url('/ulasan') }}">
                        <i class="bi bi-chat-dots me-1"></i>{{ __('Ulasan') }}
                    </a>
                </li>

                {{-- 🌐 SELEKTOR PILIHAN BAHASA (INDONESIA / INGGRIS / MANDARIN) --}}
                <li class="nav-item dropdown lang-dropdown ms-lg-1">
                    <button class="btn dropdown-toggle text-white d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(app()->getLocale() == 'en')
                            🇬🇧 EN
                        @elseif(app()->getLocale() == 'zh')
                            🇨🇳 ZH
                        @else
                            🇮🇩 ID
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end animate fade-In">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 {{ app()->getLocale() == 'id' ? 'active' : '' }}" href="{{ route('lang.switch', 'id') }}">
                                🇮🇩 Bahasa Indonesia
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">
                                🇬🇧 English (UK)
                            </a>
                        </li>
                        {{-- 🇨🇳 PILIHAN BAHASA MANDARIN --}}
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 {{ app()->getLocale() == 'zh' ? 'active' : '' }}" href="{{ route('lang.switch', 'zh') }}">
                                🇨🇳 简体中文 (Mandarin)
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Tombol Login --}}
                <li class="nav-item ms-lg-1">
                    @auth
                        <a href="{{ auth()->user()->role == 'admin' ? url('/admin/dashboard') : url('/pj/dashboard') }}" 
                        class="btn btn-login-custom d-flex align-items-center fw-bold">
                            <i class="bi bi-speedometer2 me-1"></i> {{ __('Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                        class="btn btn-login-custom d-flex align-items-center fw-bold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('Login') }}
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
                <p style="font-size:.9rem;">{{ __('Sistem Informasi Tanaman Obat Taman Koleksi Kebun Raya Universitas Pahlawan Tuanku Tambusai, Bangkinang, Riau.') }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>{{ __('Kontak') }}</h5>
                <ul class="list-unstyled" style="font-size:.9rem;">
                    <li><i class="bi bi-geo-alt me-2"></i>{{ __('Bangkinang, Kab. Kampar, Riau') }}</li>
                    <li><i class="bi bi-building me-2"></i>{{ __('Universitas Pahlawan') }}</li>
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