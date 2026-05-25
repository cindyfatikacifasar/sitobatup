<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | SITOBAT-UP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* SINKRONISASI TEMA HIJAU KEBUN RAYA UNIVERSITAS PAHLAWAN */
        :root { 
            --hijau-tua: #11411c; 
            --hijau-mid: #1a5c2a; 
            --hijau-aksen: #2d8a4e; 
            --sidebar-w: 260px; 
        }
        * { font-family: 'Poppins', sans-serif; }
        body { background: #f4f7f5; }
        
        .sidebar {
            position: fixed; top: 0; left: 0; width: var(--sidebar-w);
            height: 100vh; background: linear-gradient(180deg, var(--hijau-tua) 0%, #0a2410 100%);
            overflow-y: auto; z-index: 1050; transition: transform .3s;
        }
        .sidebar-brand { padding: 20px; border-bottom: 1px solid rgba(255,255,255,.1); }
        .sidebar-brand h5 { color: white; font-weight: 700; margin: 0; font-size: 1.1rem; letter-spacing: 0.5px; }
        .nav-section { padding: 14px 16px 4px; font-size: .68rem; text-transform: uppercase; color: rgba(255,255,255,.4); letter-spacing: 1px; font-weight: 600; }
        
        .sidebar .nav-link { 
            color: rgba(255,255,255,.78); padding: 10px 20px; border-radius: 8px; margin: 1px 8px; 
            font-size: .88rem; font-weight: 500; transition: all .2s; display: flex; align-items: center; gap: 10px; 
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { 
            background: rgba(255,255,255,.15); color: #fff; 
        }
        .sidebar .nav-link.active {
            background: var(--hijau-mid) !important;
            border-left: 4px solid var(--hijau-aksen);
        }
        .sidebar .nav-link i { font-size: 1rem; width: 18px; }
        .sidebar-badge { background: #e74c3c; color: white; border-radius: 50%; padding: 1px 6px; font-size: .7rem; font-weight: 700; }
        
        .main-content { margin-left: var(--sidebar-w); min-height: 100vh; }
        .topbar { background: white; padding: 12px 24px; box-shadow: 0 1px 8px rgba(0,0,0,.08); display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
        .topbar-title { font-weight: 600; color: var(--hijau-tua); font-size: 1rem; }
        .page-body { padding: 24px; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1040; }
        
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2 mb-1">
            <div style="font-size: 1.6rem;">🌿</div>
            <div>
                <h5>SITOBAT-UP</h5>
            </div>
        </div>
        
        <div class="mt-3 d-flex align-items-center gap-2 px-1">
            @if(auth()->user()->foto)
                <img src="{{ asset('storage/' . auth()->user()->foto) }}" 
                     style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.2);">
            @else
                <div style="width: 38px; height: 38px; background: rgba(255,255,255,.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                    👤
                </div>
            @endif
            <div style="overflow: hidden;">
                <div style="color: white; font-size: .85rem; font-weight: 600; line-height: 1.2; white-space: nowrap; text-overflow: ellipsis;">
                    {{ auth()->user()->name }}
                </div>
                <div style="color: rgba(255,255,255,.5); font-size: .7rem;">Penanggungjawab</div>
            </div>
        </div>
    </div>

    <nav class="py-2">
        <div class="nav-section">Menu Utama</div>
        <a href="{{ route('pj.dashboard') }}" class="nav-link {{ request()->routeIs('pj.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section">Laporan</div>
        {{-- 1. Laporan Tanaman --}}
        <a href="{{ route('pj.laporan.tanaman') }}" class="nav-link {{ request()->routeIs('pj.laporan.tanaman') ? 'active' : '' }}">
            <i class="bi bi-flower1"></i> Laporan Tanaman
        </a>
        
        {{-- 2. TAMBAHAN: Laporan Berita --}}
        <a href="{{ route('pj.laporan.berita') }}" class="nav-link {{ request()->routeIs('pj.laporan.berita') ? 'active' : '' }}">
            <i class="bi bi-newspaper"></i> Laporan Berita
        </a>

        {{-- 3. TAMBAHAN: Laporan Galeri --}}
        <a href="{{ route('pj.laporan.galeri') }}" class="nav-link {{ request()->routeIs('pj.laporan.galeri') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Laporan Galeri
        </a>

        {{-- 4. Laporan Pengunjung --}}
        <a href="{{ route('pj.laporan.pengunjung') }}" class="nav-link {{ request()->routeIs('pj.laporan.pengunjung') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Laporan Pengunjung
        </a>
        


   
        <a href="{{ route('pj.saran.index') }}" class="nav-link {{ request()->routeIs('pj.saran.*') ? 'active' : '' }}">
            <i class="bi bi-chat-dots"></i> Laporan Review
            @php $belumBaca = \App\Models\Saran::where('pengirim','pengunjung')->where('is_read',false)->count(); @endphp
            @if($belumBaca > 0)<span class="sidebar-badge">{{ $belumBaca }}</span>@endif
        </a>

        <div class="nav-section">Akun</div>
        <a href="{{ route('pj.profil') }}" class="nav-link {{ request()->routeIs('pj.profil') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profil Saya
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <a href="#" class="nav-link" style="color: rgba(255,80,80,.85);" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i> Logout
        </a>
    </nav>
</div>

<div class="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-list fs-5"></i>
            </button>
            <span class="topbar-title">@yield('title','Dashboard')</span>
        </div>
        {{-- SINKRONISASI: Mengubah tombol website menjadi hijau (btn-outline-success) --}}
        <a href="{{ route('beranda') }}" class="btn btn-sm btn-outline-success" target="_blank">
            <i class="bi bi-globe me-1"></i><span class="d-none d-sm-inline">Website</span>
        </a>
    </div>
    <div class="page-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
</script>
@stack('scripts')
</body>
</html>