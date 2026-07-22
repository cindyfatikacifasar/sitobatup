@extends('layouts.admin')
@section('title','Dashboard')
@section('content')

{{-- CSS KHUSUS UNTUK MENINGKATKAN KUALITAS UI/UX STAT-CARD --}}
<style>
    .custom-stat-card {
        border: none !important;
        border-radius: 14px !important;
        background: #ffffff;
        transition: all 0.3s ease-in-out;
    }
    .custom-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }
    .stat-icon-wrapper {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

{{-- 1. KOTAK-KOTAK TOTAL DATA (STATISTIK DENGAN UI/UX UPGRADE) --}}
<div class="row g-3 mb-4">
    {{-- Total Tanaman --}}
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card custom-stat-card shadow-sm h-100">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon-wrapper" style="background:#e8f5e9;">
                        <span style="font-size: 1.2rem;">🌿</span>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success fw-bold" style="font-size: 0.68rem; border-radius: 30px;">Herbal</span>
                </div>
                <div>
                    <div style="font-size:1.75rem; font-weight:700; color: #43a047; line-height: 1.2;">{{ $totalTanaman }}</div>
                    <div style="font-size:.75rem; color:#6c757d; font-weight: 500; margin-top: 2px;">Total Tanaman</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Kategori --}}
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card custom-stat-card shadow-sm h-100">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon-wrapper" style="background:#e3f2fd;">
                        <span style="font-size: 1.2rem;">🏷️</span>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold" style="font-size: 0.68rem; border-radius: 30px;">Filter</span>
                </div>
                <div>
                    <div style="font-size:1.75rem; font-weight:700; color:#1976d2; line-height: 1.2;">{{ $totalKategori }}</div>
                    <div style="font-size:.75rem; color:#6c757d; font-weight: 500; margin-top: 2px;">Kategori</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Berita --}}
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card custom-stat-card shadow-sm h-100">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon-wrapper" style="background:#fce4ec;">
                        <span style="font-size: 1.2rem;">📰</span>
                    </div>
                    <span class="badge bg-danger bg-opacity-10 text-danger fw-bold" style="font-size: 0.68rem; border-radius: 30px;">Info</span>
                </div>
                <div>
                    <div style="font-size:1.75rem; font-weight:700; color:#c2185b; line-height: 1.2;">{{ $totalBerita }}</div>
                    <div style="font-size:.75rem; color:#6c757d; font-weight: 500; margin-top: 2px;">Total Berita</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Galeri --}}
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card custom-stat-card shadow-sm h-100">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon-wrapper" style="background:#e8eaf6;">
                        <span style="font-size: 1.2rem;">🖼️</span>
                    </div>
                    <span class="badge bg-indigo bg-opacity-10 text-indigo fw-bold" style="font-size: 0.68rem; border-radius: 30px; color: #3949ab; background-color: rgba(57,73,171,0.1);">Foto</span>
                </div>
                <div>
                    <div style="font-size:1.75rem; font-weight:700; color:#3949ab; line-height: 1.2;">{{ $totalGaleri }}</div>
                    <div style="font-size:.75rem; color:#6c757d; font-weight: 500; margin-top: 2px;">Galeri</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ulasan Baru --}}
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card custom-stat-card shadow-sm h-100">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon-wrapper" style="background:#fff3e0;">
                        <span style="font-size: 1.2rem;">💬</span>
                    </div>
                    @if($ulasanBelumBaca > 0)
                        <span class="badge bg-warning text-dark fw-bold animate-pulse" style="font-size: 0.68rem; border-radius: 30px;">New</span>
                    @endif
                </div>
                <div>
                    <div style="font-size:1.75rem; font-weight:700; color:#e65100; line-height: 1.2;">{{ $ulasanBelumBaca }}</div>
                    <div style="font-size:.75rem; color:#6c757d; font-weight: 500; margin-top: 2px;">Ulasan Baru</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pengunjung Hari Ini --}}
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card custom-stat-card shadow-sm h-100">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon-wrapper" style="background:#e8f5e9;">
                        <span style="font-size: 1.2rem;">👥</span>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success fw-bold" style="font-size: 0.68rem; border-radius: 30px;">Live</span>
                </div>
                <div>
                    <div style="font-size:1.75rem; font-weight:700; color:#388e3c; line-height: 1.2;">{{ $pengunjungHari }}</div>
                    <div style="font-size:.75rem; color:#6c757d; font-weight: 500; margin-top: 2px;">Pengunjung Kini</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. SEKSI GRAFIK & LIST TANAMAN POPULER (KODINGAN UTAMA KAMU) --}}
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
            <div class="card-header bg-white py-3 fw-bold text-dark border-bottom-0">
                <i class="bi bi-graph-up me-2" style="color:#2d8a4e;"></i>Grafik Pengunjung 30 Hari Terakhir
            </div>
            <div class="card-body">
                <canvas id="grafikPengunjung" height="100"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
            <div class="card-header bg-white py-3 fw-bold text-dark border-bottom-0">
                <i class="bi bi-star me-2" style="color:#f9a825;"></i>Tanaman Paling Sering Dilihat
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <tbody>
                        @foreach($tanamanPopuler as $i => $t)
                        <tr>
                            <td width="30" class="ps-3">
                                <span class="badge rounded-pill" style="background:{{ $i==0?'#FFD700':($i==1?'#C0C0C0':($i==2?'#CD7F32':'#e8f5e9')) }};color:{{ $i<3?'white':'#1a5c2a' }};">{{ $i+1 }}</span>
                            </td>
                            <td>
                                <div style="font-size:.85rem;font-weight:600;">{{ $t->nama }}</div>
                                <div style="font-size:.75rem;color:#888;font-style:italic;">{{ $t->nama_ilmiah }}</div>
                            </td>
                            <td class="pe-3 text-end">
                                <span style="font-size:.82rem;color:#2d8a4e;font-weight:600;">{{ number_format($t->views) }}</span>
                                <div style="font-size:.7rem;color:#aaa;">views</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- NOTE: KOMPONEN BLOK AKSI CEPAT LAMA SUDAH DIHAPUS TOTAL DI SINI --}}

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikPengunjung').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($grafik,'tanggal')) !!},
        datasets: [{
            label: 'Pengunjung',
            data: {!! json_encode(array_column($grafik,'jumlah')) !!},
            backgroundColor: 'rgba(45,138,78,0.4)',
            borderColor: 'rgba(45,138,78,1)',
            borderWidth: 1, borderRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endpush
@endsection