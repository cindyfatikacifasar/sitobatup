<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SITOBAT-UP | Sistem Informasi Tanaman Obat</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap 5 CSS untuk Slider Rapi -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background-color: #f8f9fa;
            }
            /* Custom CSS untuk merapikan teks di atas gambar */
            .carousel-item {
                height: 650px;
                min-height: 400px;
                background: no-repeat center center scroll;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            .carousel-item::before {
                content: "";
                position: absolute;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0, 0, 0, 0.5); /* Overlay gelap agar teks terbaca */
            }
            .carousel-caption {
                bottom: 15% !important;
                left: 8% !important;
                right: 8% !important;
                text-align: left !important;
                z-index: 2;
            }
            .carousel-caption h1 {
                font-size: 3.5rem;
                font-weight: 800;
                line-height: 1.2;
                max-width: 850px;
                text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            }
            .carousel-caption p {
                font-size: 1.25rem;
                max-width: 700px;
                margin-bottom: 2rem;
            }
            .navbar-sitobat {
                background-color: #1a5928 !important; /* Hijau Khas SITOBAT */
            }
            .btn-warning {
                background-color: #ffc107;
                border: none;
                color: #000;
                font-weight: bold;
            }
        </style>
    </head>
    <body class="antialiased">
        
        <!-- Header / Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-sitobat sticky-top shadow">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="https://universitaspahlawan.ac.id/wp-content/uploads/2020/01/logo-up-300x300.png" alt="Logo" width="40" height="40" class="me-2">
                    <div>
                        <span class="fw-bold d-block" style="line-height: 1;">SITOBAT-UP</span>
                        <small style="font-size: 0.7rem;">Kebun Raya Universitas Pahlawan</small>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto fw-semibold">
                        <li class="nav-item"><a class="nav-link active" href="/"><i class="bi bi-house-door me-1"></i> Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="/katalog"><i class="bi bi-grid me-1"></i> Katalog</a></li>
                        <li class="nav-item"><a class="nav-link" href="/galeri"><i class="bi bi-images me-1"></i> Galeri</a></li>
                        <li class="nav-item"><a class="nav-link" href="/berita"><i class="bi bi-newspaper me-1"></i> Berita</a></li>
                        <li class="nav-item"><a class="nav-link" href="/ulasan"><i class="bi bi-chat-dots me-1"></i> Ulasan</a></li>
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link btn btn-outline-light ms-lg-3">Dashboard</a></li>
                            @else
                                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link btn btn-outline-light ms-lg-3">Log in</a></li>
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Slider Section -->
        <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($beritas as $key => $item)
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>
            
            <div class="carousel-inner">
                @forelse($beritas as $item)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}" 
                    style="background-image: url('{{ asset('storage/' . $item->foto) }}');">
                   
                   <div class="carousel-caption">
                       <h1>{{ $item->judul }}</h1>
                       <a href="/berita/{{ $item->id }}" class="btn-baca-baru">Baca Selengkapnya</a>
                   </div>
               </div>

                        <!-- Judul -->
                        <h1 class="mb-3">{{ $item->judul }}</h1>

                        <!-- Deskripsi Singkat -->
                        <p class="d-none d-md-block">{{ Str::limit(strip_tags($item->isi), 170) }}</p>

                        <!-- Tombol -->
                        <a href="/berita/{{ $item->id }}" class="btn-baca-selengkapnya">
                            Baca Selengkapnya
                        </a>
                        </a>
                    </div>
                </div>
                @empty
                <div class="carousel-item active" style="background-color: #222;">
                    <div class="carousel-caption text-center">
                        <h1>Selamat Datang di SITOBAT-UP</h1>
                        <p>Informasi tanaman obat Kebun Raya Universitas Pahlawan.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <!-- Footer / Section Tambahan Bisa Taruh di Sini -->

        <!-- Bootstrap 5 JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>