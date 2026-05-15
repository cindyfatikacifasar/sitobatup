<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="SITOBAT-UP — Sistem Informasi Tanaman Obat Kebun Raya Universitas Pahlawan">
    <title>@yield('title', 'SITOBAT-UP') | Kebun Raya Universitas Pahlawan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --hijau-tua: #1B5E20;
            --hijau-muda: #2E7D32;
            --hijau-terang: #4CAF50;
            --hijau-pucat: #E8F5E9;
        }
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }
        body { background: #f8faf8; overflow-x: hidden; }
        img { max-width: 100%; }

        /* =====================
           NAVBAR
        ======================== */
        .navbar-sitobat {
            background: linear-gradient(135deg, var(--hijau-tua) 0%, var(--hijau-muda) 100%);
            padding: 10px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,.15);
            position: sticky; top: 0; z-index: 1000;
        }
        .navbar-brand span { color:#fff; font-weight:700; font-size:1.05rem; line-height:1.1; }
        .navbar-brand small { color:rgba(255,255,255,.65); font-size:.62rem; line-height:1; }
        .navbar-sitobat .nav-link {
            color: rgba(255,255,255,.9) !important;
            font-weight: 500; font-size: .88rem;
            padding: 8px 12px !important; border-radius: 8px; transition: .2s;
        }
        .navbar-sitobat .nav-link:hover,
        .navbar-sitobat .nav-link.active { background: rgba(255,255,255,.18); color:#fff !important; }
        .navbar-toggler { border: 2px solid rgba(255,255,255,.4); padding: 4px 8px; }
        .navbar-toggler-icon { filter: brightness(0) invert(1); }
        @media (max-width:991px) {
            .navbar-collapse { background:rgba(0,0,0,.15); border-radius:12px; padding:8px; margin-top:8px; }
            .navbar-sitobat .nav-link { padding:10px 14px !important; border-radius:8px; }
        }

        /* =====================
           HERO
        ======================== */
        .hero-section {
            background: linear-gradient(135deg,var(--hijau-tua) 0%,var(--hijau-muda) 60%,var(--hijau-terang) 100%);
            color: white; padding: 65px 0;
        }
        .hero-section h1 { font-weight:700; font-size:clamp(1.5rem,5vw,2.8rem); line-height:1.2; }
        @media (max-width:576px) {
            .hero-section { padding: 40px 0; }
        }

        /* =====================
           STAT CARDS
        ======================== */
        .stat-card { border:none; border-radius:16px; padding:18px 14px; text-align:center; color:white; }
        .stat-card .stat-number { font-size:clamp(1.8rem,5vw,2.4rem); font-weight:700; line-height:1; }
        .stat-card .stat-label { font-size:.78rem; opacity:.9; margin-top:4px; }
        .stat-card .stat-icon { font-size:1.8rem; opacity:.25; }
        .stat-card.green { background:linear-gradient(135deg,#1B5E20,#2E7D32); }
        .stat-card.teal  { background:linear-gradient(135deg,#004D40,#00695C); }
        .stat-card.amber { background:linear-gradient(135deg,#E65100,#F57C00); }
        .stat-card.blue  { background:linear-gradient(135deg,#0D47A1,#1565C0); }

        /* =====================
           CARD TANAMAN
        ======================== */
        .card-tanaman { border:none; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,.07); transition:.3s; overflow:hidden; }
        .card-tanaman:hover { transform:translateY(-5px); box-shadow:0 12px 35px rgba(0,0,0,.13); }

        /* =====================
           SECTION TITLE
        ======================== */
        .section-title { position:relative; padding-bottom:10px; margin-bottom:24px; font-weight:700; color:var(--hijau-tua); }
        .section-title::after { content:''; position:absolute; bottom:0; left:0; width:48px; height:4px; background:var(--hijau-terang); border-radius:2px; }
        .section-title.text-center::after { left:50%; transform:translateX(-50%); }

        /* =====================
           BUTTONS
        ======================== */
        .btn-hijau { background:var(--hijau-muda); color:white; border:none; border-radius:10px; font-weight:500; transition:.2s; }
        .btn-hijau:hover { background:var(--hijau-tua); color:white; }
        .btn-outline-hijau { border:2px solid var(--hijau-muda); color:var(--hijau-muda); border-radius:10px; font-weight:500; }
        .btn-outline-hijau:hover { background:var(--hijau-muda); color:white; }



        /* =====================
           FILTER CARD
        ======================== */
        .filter-card { border:none; border-radius:16px; box-shadow:0 2px 15px rgba(0,0,0,.06); }

        /* =====================
           PAGINATION
        ======================== */
        .page-link { color:var(--hijau-muda); border-radius:8px !important; margin:0 2px; }
        .page-item.active .page-link { background:var(--hijau-muda); border-color:var(--hijau-muda); }

        /* =====================
           FORM
        ======================== */
        .form-control,.form-select { border-radius:10px; border:1.5px solid #ddd; font-size:.9rem; padding:10px 14px; }
        .form-control:focus,.form-select:focus { border-color:var(--hijau-terang); box-shadow:0 0 0 3px rgba(76,175,80,.15); }

        /* =====================
           FOOTER
        ======================== */
        footer { background:linear-gradient(135deg,#1B5E20,#0a2e0a); color:rgba(255,255,255,.8); }
        footer a { color:rgba(255,255,255,.7); text-decoration:none; }
        footer a:hover { color:white; }

        /* =====================
           ALERT FLASH
        ======================== */
        .alert-flash { border:none; border-radius:0; margin:0; font-size:.9rem; }
        .alert-flash.success { background:#E8F5E9; color:#1B5E20; border-left:4px solid #4CAF50; }
        .alert-flash.error   { background:#FFEBEE; color:#C62828; border-left:4px solid #F44336; }

        /* =====================
           MOBILE FIXES
        ======================== */
        @media (max-width:576px) {
            .container { padding-left:14px; padding-right:14px; }
            section.py-5 { padding-top:2rem !important; padding-bottom:2rem !important; }
            section.py-4 { padding-top:1.5rem !important; padding-bottom:1.5rem !important; }
            .card-tanaman .card-body { padding:12px !important; }
            footer .col-6 { margin-bottom:.5rem; }
            .btn-lg { font-size:.95rem; padding:.5rem 1rem; }
        }
        @media (max-width:400px) {
            .stat-card .stat-number { font-size:1.6rem; }
            .stat-card .stat-label { font-size:.72rem; }
        }
        
    </style>
    @stack('styles')
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-sitobat">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('public.beranda') }}">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-leaf fa-lg text-white"></i>
            </div>
            <div>
                <span>SITOBAT-UP</span>
                <small class="d-none d-sm-block">Kebun Raya Universitas Pahlawan</small>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto gap-1 mt-2 mt-lg-0">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.beranda') ? 'active':'' }}" href="{{ route('public.beranda') }}"><i class="fas fa-home me-1"></i>Beranda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.katalog') ? 'active':'' }}" href="{{ route('public.katalog') }}"><i class="fas fa-seedling me-1"></i>Katalog</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.galeri') ? 'active':'' }}" href="{{ route('public.galeri') }}"><i class="fas fa-images me-1"></i>Galeri</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.berita*') ? 'active':'' }}" href="{{ route('public.berita') }}"><i class="fas fa-newspaper me-1"></i>Berita</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.saran') ? 'active':'' }}" href="{{ route('public.saran') }}"><i class="fas fa-comment-alt me-1"></i>Saran</a></li>
            </ul>
        </div>
    </div>
</nav>

{{-- FLASH --}}
@if(session('success'))
<div class="alert alert-flash success alert-dismissible fade show">
    <div class="container py-1"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
</div>
@endif
@if(session('error'))
<div class="alert alert-flash error alert-dismissible fade show">
    <div class="container py-1"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
</div>
@endif

{{-- KONTEN --}}
@yield('content')

{{-- FOOTER --}}
<footer class="pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div style="width:38px;height:38px;background:rgba(255,255,255,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-leaf text-white"></i>
                    </div>
                    <span style="font-weight:700;font-size:1.05rem;color:white;">SITOBAT-UP</span>
                </div>
                <p style="font-size:.87rem;line-height:1.7;">Sistem Informasi Tanaman Obat Kebun Raya Universitas Pahlawan Tuanku Tambusai.</p>
            </div>
            <div class="col-6 col-md-2">
                <h6 style="font-weight:600;color:white;margin-bottom:12px;font-size:.95rem;">Menu</h6>
                <ul class="list-unstyled" style="font-size:.85rem;">
                    <li class="mb-1"><a href="{{ route('public.beranda') }}">Beranda</a></li>
                    <li class="mb-1"><a href="{{ route('public.katalog') }}">Katalog</a></li>
                    <li class="mb-1"><a href="{{ route('public.galeri') }}">Galeri</a></li>
                    <li class="mb-1"><a href="{{ route('public.berita') }}">Berita</a></li>
                    <li class="mb-1"><a href="{{ route('public.saran') }}">Saran</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3">
                <h6 style="font-weight:600;color:white;margin-bottom:12px;font-size:.95rem;">Lokasi</h6>
                <p style="font-size:.85rem;line-height:1.7;"><i class="fas fa-map-marker-alt me-1 text-warning"></i>Taman Koleksi Tanaman Obat<br>Kebun Raya Universitas Pahlawan<br>Bangkinang, Riau</p>
            </div>
            <div class="col-12 col-md-3">
                <h6 style="font-weight:600;color:white;margin-bottom:12px;font-size:.95rem;">Portal Pengelola</h6>
                <a href="{{ route('admin.login') }}" class="btn btn-sm btn-outline-light w-100 mb-2 text-start"><i class="fas fa-shield-alt me-2"></i>Login Admin</a>
                <a href="{{ route('pj.login') }}" class="btn btn-sm btn-outline-light w-100 text-start"><i class="fas fa-user-tie me-2"></i>Login Penanggung Jawab</a>
            </div>
        </div>
        <hr style="border-color:rgba(255,255,255,.15);margin-top:28px;">
        <p class="text-center mb-0" style="font-size:.8rem;">© {{ date('Y') }} SITOBAT-UP — Kebun Raya Universitas Pahlawan Tuanku Tambusai</p>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>