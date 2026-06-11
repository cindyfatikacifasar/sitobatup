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
    <link href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --hijau-tua: #1a5c2a;
            --hijau-mid: #2d8a4e;
            --hijau-muda: #4caf72;
        }
        * { font-family: 'Poppins', sans-serif; }
        body { background: #f8faf8; }

        /* ── Navbar ── */
        .navbar-sitobat {
            background: linear-gradient(135deg, var(--hijau-tua) 0%, var(--hijau-mid) 100%);
            box-shadow: 0 2px 15px rgba(26,92,42,0.3);
            padding: 12px 0;
        }
        .navbar-brand-text { color: #fff !important; font-weight: 700; font-size: 1.4rem; line-height: 1.1; }
        .navbar-brand-sub  { font-size: 0.65rem; font-weight: 400; color: #fff !important; opacity: 1; display: block; }
        .navbar-sitobat .nav-link {
            color: rgba(255,255,255,0.88) !important;
            font-weight: 500;
            transition: all .2s;
            padding: 8px 14px !important;
            border-radius: 6px;
        }
        .navbar-sitobat .nav-link:hover,
        .navbar-sitobat .nav-link.active { color: #fff !important; background: rgba(255,255,255,0.15); }

        /* Nav item underline */
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
            content: "";
            position: absolute;
            bottom: -5px;
            left: 10px; right: 10px;
            height: 3px;
            background: #ffffff;
            border-radius: 10px;
        }
        .navbar-nav .nav-item { display: flex; align-items: center; }

        /* Tombol Login */
        .btn-login-custom {
            background-color: rgba(255,255,255,0.18) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255,255,255,0.4) !important;
            padding: 7px 18px !important;
            border-radius: 8px !important;
            font-size: 14px;
            transition: all 0.2s ease-in-out;
        }
        .btn-login-custom:hover {
            background-color: #ffffff !important;
            color: var(--hijau-tua) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-1px);
        }

        /* ── Custom Language Switcher ── */
        .lang-switcher {
            position: relative;
        }
        .lang-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.35);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 30px;
            cursor: pointer;
            transition: background 0.2s;
            white-space: nowrap;
            user-select: none;
        }
        .lang-btn:hover { background: rgba(255,255,255,0.25); }
        .lang-btn .bi-chevron-down {
            font-size: 10px;
            transition: transform 0.2s;
        }
        .lang-btn.open .bi-chevron-down { transform: rotate(180deg); }

        .lang-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            min-width: 220px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            overflow: hidden;
            z-index: 9999;
            padding: 6px 0;
            max-height: 380px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #c8e6c9 transparent;
        }
        .lang-dropdown::-webkit-scrollbar { width: 5px; }
        .lang-dropdown::-webkit-scrollbar-track { background: transparent; }
        .lang-dropdown::-webkit-scrollbar-thumb { background: #c8e6c9; border-radius: 10px; }
        .lang-dropdown.show { display: block; }

        .lang-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            font-size: 13.5px;
            color: #333;
            cursor: pointer;
            transition: background 0.15s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        .lang-option:hover { background: #f0f8f2; color: var(--hijau-tua); }
        .lang-option.active {
            background: #e8f5ec;
            color: var(--hijau-tua);
            font-weight: 600;
        }
        .lang-flag {
            width: 24px;
            height: 18px;
            flex-shrink: 0;
            border-radius: 3px;
            overflow: hidden;
            display: inline-block;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .lang-flag .fi {
            width: 100%;
            height: 100%;
            display: block;
            background-size: cover;
            background-position: center;
        }
        .lang-code {
            width: 24px;
            height: 18px;
            flex-shrink: 0;
            border-radius: 3px;
            overflow: hidden;
            display: inline-block;
            margin-left: auto;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
            opacity: 0.5;
        }
        .lang-code .fi {
            width: 100%;
            height: 100%;
            display: block;
            background-size: cover;
            background-position: center;
        }

        /* Sembunyikan semua sisa Google Translate bawaan */
        iframe.goog-te-banner-frame,
        .goog-te-banner,
        #goog-gt-tt,
        .goog-tooltip,
        .goog-tooltip:hover,
        .goog-text-highlight {
            display: none !important;
            visibility: hidden !important;
        }
        body { top: 0px !important; position: static !important; }
        .skiptranslate { display: none !important; }
        #google_translate_element { display: none !important; }

        /* ── Responsive ── */
        @media (min-width: 992px) and (max-width: 1366px) {
            .navbar-brand-sub { display: none !important; }
            .nav-custom { font-size: 13px; padding: 0.5rem 0.4rem !important; }
        }
        @media (max-width: 768px) {
            .carousel-item { height: 400px !important; }
            .carousel-caption h1 { font-size: 2rem; }
            .lang-dropdown { right: auto; left: 0; }
        }

        /* ── Slider ── */
        .carousel-item {
            height: 600px !important;
            background-color: #000 !important;
            background-position: center !important;
            background-size: cover !important;
            background-repeat: no-repeat;
            position: relative;
        }
        .carousel-item::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4);
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

        /* ── Footer ── */
        .footer-main { background: var(--hijau-tua); color: rgba(255,255,255,0.85); padding: 50px 0 20px; }
        .footer-main h5 { color: white; font-weight: 700; margin-bottom: 16px; }
        .footer-main a { color: rgba(255,255,255,0.75); text-decoration: none; }
        .footer-main a:hover { color: white; }
        .footer-bottom { background: rgba(0,0,0,0.2); padding: 14px 0; text-align: center; color: rgba(255,255,255,0.6); font-size: .85rem; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Google Translate hidden element tetap ada agar engine-nya berjalan --}}
<div id="google_translate_element" style="display:none;"></div>

<nav class="navbar navbar-expand-lg navbar-sitobat sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <div style="width:45px;height:45px;position:relative;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <img src="{{ asset('assets/img/logo-sitobat.png') }}"
                     alt=""
                     style="height:115px;width:115px;max-width:none;object-fit:contain;position:absolute;filter:brightness(1.25) contrast(1.2) drop-shadow(0px 0px 10px rgba(255,255,255,0.95)) drop-shadow(0px 3px 6px rgba(0,0,0,0.35));">
            </div>
            <div>
                <span class="navbar-brand-text">SITOBAT-UP</span>
                <span class="navbar-brand-sub">Taman Koleksi Tanaman Obat Kebun Raya Universitas Pahlawan</span>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon" style="filter:invert(1);"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-center gap-2">

                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('/') ? 'active-link' : '' }}" href="{{ url('/') }}">
                        <i class="bi bi-house me-1"></i>{{ __('Beranda') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('katalog*') ? 'active-link' : '' }}" href="{{ url('/katalog') }}">
                        <i class="bi bi-grid me-1"></i>{{ __('Tanaman Obat') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('galeri*') ? 'active-link' : '' }}" href="{{ url('/galeri') }}">
                        <i class="bi bi-images me-1"></i>{{ __('Galeri') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('berita*') ? 'active-link' : '' }}" href="{{ url('/berita') }}">
                        <i class="bi bi-newspaper me-1"></i>{{ __('Berita') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-custom {{ request()->is('ulasan*') ? 'active-link' : '' }}" href="{{ url('/ulasan') }}">
                        <i class="bi bi-chat-dots me-1"></i>{{ __('Ulasan') }}
                    </a>
                </li>

                {{-- ✅ Custom Language Switcher --}}
                <li class="nav-item ms-lg-1 me-lg-1 flex-shrink-0">
                    <div class="lang-switcher" id="langSwitcher">
                        <button class="lang-btn" id="langBtn" onclick="toggleLangDropdown()" type="button">
                            <i class="bi bi-globe2"></i>
                            <span id="langLabel">Language</span>
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        <div class="lang-dropdown" id="langDropdown">
                            <button class="lang-option active" onclick="setLang('id', 'Bahasa Indonesia', 'id', 'ID')">
                                <span class="lang-flag"><span class="fi fi-id"></span></span>
                                Bahasa Indonesia
                                <span class="lang-code"><span class="fi fi-id"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('en', 'English (UK)', 'gb', 'EN')">
                                <span class="lang-flag"><span class="fi fi-gb"></span></span>
                                English (UK)
                                <span class="lang-code"><span class="fi fi-gb"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('zh-CN', '简体中文 (Mandarin)', 'cn', 'CN')">
                                <span class="lang-flag"><span class="fi fi-cn"></span></span>
                                简体中文 (Mandarin)
                                <span class="lang-code"><span class="fi fi-cn"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('hi', 'हिन्दी (India)', 'in', 'IN')">
                                <span class="lang-flag"><span class="fi fi-in"></span></span>
                                हिन्दी (India)
                                <span class="lang-code"><span class="fi fi-in"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('nl', 'Nederlands (Belanda)', 'nl', 'NL')">
                                <span class="lang-flag"><span class="fi fi-nl"></span></span>
                                Nederlands (Belanda)
                                <span class="lang-code"><span class="fi fi-nl"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('it', 'Italiano (Itali)', 'it', 'IT')">
                                <span class="lang-flag"><span class="fi fi-it"></span></span>
                                Italiano (Itali)
                                <span class="lang-code"><span class="fi fi-it"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('es', 'Español (Spanyol)', 'es', 'ES')">
                                <span class="lang-flag"><span class="fi fi-es"></span></span>
                                Español (Spanyol)
                                <span class="lang-code"><span class="fi fi-es"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('de', 'Deutsch (Jerman)', 'de', 'DE')">
                                <span class="lang-flag"><span class="fi fi-de"></span></span>
                                Deutsch (Jerman)
                                <span class="lang-code"><span class="fi fi-de"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('fr', 'Français (Prancis)', 'fr', 'FR')">
                                <span class="lang-flag"><span class="fi fi-fr"></span></span>
                                Français (Prancis)
                                <span class="lang-code"><span class="fi fi-fr"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('ar', 'العربية (Arab)', 'sa', 'AR')">
                                <span class="lang-flag"><span class="fi fi-sa"></span></span>
                                العربية (Arab)
                                <span class="lang-code"><span class="fi fi-sa"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('ja', '日本語 (Jepang)', 'jp', 'JA')">
                                <span class="lang-flag"><span class="fi fi-jp"></span></span>
                                日本語 (Jepang)
                                <span class="lang-code"><span class="fi fi-jp"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('ko', '한국어 (Korea)', 'kr', 'KO')">
                                <span class="lang-flag"><span class="fi fi-kr"></span></span>
                                한국어 (Korea)
                                <span class="lang-code"><span class="fi fi-kr"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('pt', 'Português (Brasil)', 'br', 'PT')">
                                <span class="lang-flag"><span class="fi fi-br"></span></span>
                                Português (Brasil)
                                <span class="lang-code"><span class="fi fi-br"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('ru', 'Русский (Rusia)', 'ru', 'RU')">
                                <span class="lang-flag"><span class="fi fi-ru"></span></span>
                                Русский (Rusia)
                                <span class="lang-code"><span class="fi fi-ru"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('ms', 'Bahasa Melayu', 'my', 'MS')">
                                <span class="lang-flag"><span class="fi fi-my"></span></span>
                                Bahasa Melayu
                                <span class="lang-code"><span class="fi fi-my"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('tr', 'Türkçe (Turki)', 'tr', 'TR')">
                                <span class="lang-flag"><span class="fi fi-tr"></span></span>
                                Türkçe (Turki)
                                <span class="lang-code"><span class="fi fi-tr"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('vi', 'Tiếng Việt', 'vn', 'VI')">
                                <span class="lang-flag"><span class="fi fi-vn"></span></span>
                                Tiếng Việt
                                <span class="lang-code"><span class="fi fi-vn"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('th', 'ภาษาไทย (Thai)', 'th', 'TH')">
                                <span class="lang-flag"><span class="fi fi-th"></span></span>
                                ภาษาไทย (Thai)
                                <span class="lang-code"><span class="fi fi-th"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('pl', 'Polski (Polandia)', 'pl', 'PL')">
                                <span class="lang-flag"><span class="fi fi-pl"></span></span>
                                Polski (Polandia)
                                <span class="lang-code"><span class="fi fi-pl"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('uk', 'Українська (Ukraina)', 'ua', 'UK')">
                                <span class="lang-flag"><span class="fi fi-ua"></span></span>
                                Українська (Ukraina)
                                <span class="lang-code"><span class="fi fi-ua"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('fa', 'فارسی (Persia)', 'ir', 'FA')">
                                <span class="lang-flag"><span class="fi fi-ir"></span></span>
                                فارسی (Persia)
                                <span class="lang-code"><span class="fi fi-ir"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('ro', 'Română (Rumania)', 'ro', 'RO')">
                                <span class="lang-flag"><span class="fi fi-ro"></span></span>
                                Română (Rumania)
                                <span class="lang-code"><span class="fi fi-ro"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('sv', 'Svenska (Swedia)', 'se', 'SV')">
                                <span class="lang-flag"><span class="fi fi-se"></span></span>
                                Svenska (Swedia)
                                <span class="lang-code"><span class="fi fi-se"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('no', 'Norsk (Norwegia)', 'no', 'NO')">
                                <span class="lang-flag"><span class="fi fi-no"></span></span>
                                Norsk (Norwegia)
                                <span class="lang-code"><span class="fi fi-no"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('da', 'Dansk (Denmark)', 'dk', 'DA')">
                                <span class="lang-flag"><span class="fi fi-dk"></span></span>
                                Dansk (Denmark)
                                <span class="lang-code"><span class="fi fi-dk"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('fi', 'Suomi (Finlandia)', 'fi', 'FI')">
                                <span class="lang-flag"><span class="fi fi-fi"></span></span>
                                Suomi (Finlandia)
                                <span class="lang-code"><span class="fi fi-fi"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('cs', 'Čeština (Ceko)', 'cz', 'CS')">
                                <span class="lang-flag"><span class="fi fi-cz"></span></span>
                                Čeština (Ceko)
                                <span class="lang-code"><span class="fi fi-cz"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('hu', 'Magyar (Hungaria)', 'hu', 'HU')">
                                <span class="lang-flag"><span class="fi fi-hu"></span></span>
                                Magyar (Hungaria)
                                <span class="lang-code"><span class="fi fi-hu"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('el', 'Ελληνικά (Yunani)', 'gr', 'EL')">
                                <span class="lang-flag"><span class="fi fi-gr"></span></span>
                                Ελληνικά (Yunani)
                                <span class="lang-code"><span class="fi fi-gr"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('he', 'עברית (Ibrani)', 'il', 'HE')">
                                <span class="lang-flag"><span class="fi fi-il"></span></span>
                                עברית (Ibrani)
                                <span class="lang-code"><span class="fi fi-il"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('sw', 'Kiswahili (Swahili)', 'ke', 'SW')">
                                <span class="lang-flag"><span class="fi fi-ke"></span></span>
                                Kiswahili (Swahili)
                                <span class="lang-code"><span class="fi fi-ke"></span></span>
                            </button>
                            <button class="lang-option" onclick="setLang('tl', 'Filipino (Filipina)', 'ph', 'TL')">
                                <span class="lang-flag"><span class="fi fi-ph"></span></span>
                                Filipino (Filipina)
                                <span class="lang-code"><span class="fi fi-ph"></span></span>
                            </button>
                        </div>
                    </div>
                </li>

                {{-- Tombol Login --}}
                <li class="nav-item ms-lg-1 flex-shrink-0">
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

{{-- Google Translate Engine (tersembunyi, tapi aktif) --}}
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'id',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');
    }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>
    // ─── Language Switcher Logic ───────────────────────────────────────────────

    function toggleLangDropdown() {
        const btn = document.getElementById('langBtn');
        const dd  = document.getElementById('langDropdown');
        btn.classList.toggle('open');
        dd.classList.toggle('show');
    }

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function(e) {
        const switcher = document.getElementById('langSwitcher');
        if (!switcher.contains(e.target)) {
            document.getElementById('langBtn').classList.remove('open');
            document.getElementById('langDropdown').classList.remove('show');
        }
    });

    function setLang(langCode, langName, flag, code) {
        // Tutup dropdown dulu
        document.getElementById('langBtn').classList.remove('open');
        document.getElementById('langDropdown').classList.remove('show');

        if (langCode === 'id') {
            // Reset ke Bahasa Indonesia: hapus cookie lalu reload
            eraseCookie('googtrans');
            location.reload();
        } else {
            // Set cookie googtrans lalu reload — cara paling andal
            // Google Translate membaca cookie ini saat halaman dimuat
            const val = '/id/' + langCode;
            setCookie('googtrans', val, 365);
            // Beberapa browser butuh cookie di subdomain juga
            setCookie('googtrans', val, 365, '.' + location.hostname);
            location.reload();
        }
    }

    function eraseCookie(name) {
        // Hapus di semua kemungkinan path & domain
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=' + location.hostname + ';';
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=.' + location.hostname + ';';
    }

    function setCookie(name, value, days, domain) {
        const d = new Date();
        d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
        const expires = '; expires=' + d.toUTCString();
        const domainPart = domain ? '; domain=' + domain : '';
        document.cookie = name + '=' + value + expires + domainPart + '; path=/';
    }

    // ─── Restore label dari cookie saat halaman dimuat ────────────────────────
    (function restoreLangLabel() {
        const langMap = {
            'en':    ['English (UK)',       '🇬🇧', 'EN'],
            'zh-CN': ['简体中文 (Mandarin)', '🇨🇳', 'CN'],
            'hi':    ['हिन्दी (India)',      '🇮🇳', 'IN'],
            'nl':    ['Nederlands',          '🇳🇱', 'NL'],
            'it':    ['Italiano',            '🇮🇹', 'IT'],
            'es':    ['Español',             '🇪🇸', 'ES'],
            'de':    ['Deutsch',             '🇩🇪', 'DE'],
            'fr':    ['Français',            '🇫🇷', 'FR'],
            'ar':    ['العربية',             '🇸🇦', 'AR'],
            'ja':    ['日本語',              '🇯🇵', 'JA'],
            'ko':    ['한국어',              '🇰🇷', 'KO'],
        };

        // Baca cookie googtrans
        const match = document.cookie.match(/googtrans=\/id\/([^;]+)/);
        if (match && match[1] && langMap[match[1]]) {
            const [, code] = langMap[match[1]];
            document.getElementById('langLabel').textContent = code;

            // Tandai active
            document.querySelectorAll('.lang-option').forEach(btn => {
                const btnLang = btn.getAttribute('onclick').match(/'([^']+)'/)?.[1];
                if (btnLang === match[1]) btn.classList.add('active');
                else btn.classList.remove('active');
            });
        }
    })();
</script>

@stack('scripts')
</body>
</html>