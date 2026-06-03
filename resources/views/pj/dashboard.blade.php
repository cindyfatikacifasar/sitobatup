@extends('layouts.pj')
@section('title', 'Dashboard Penanggung Jawab')
@section('content')

{{-- CSS KHUSUS UNTUK MENINGKATKAN KUALITAS UI/UX STAT-CARD PENANGGUNG JAWAB --}}
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

{{-- 1. FORMASI BARU 5 KOTAK TOTAL DATA STATISTIK HORIZONTAL --}}
<div class="row g-3 mb-4">
    {{-- Total Tanaman --}}
    <div class="col">
        <div class="card custom-stat-card shadow-sm h-100">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon-wrapper" style="background:#e8f5e9;">
                        <span style="font-size: 1.2rem;">🌿</span>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success fw-bold" style="font-size: 0.65rem; border-radius: 30px;">Koleksi</span>
                </div>
                <div>
                    <div style="font-size:1.65rem; font-weight:700; color:#1a5c2a; line-height: 1.2;">{{ $totalTanaman }}</div>
                    <div style="font-size:.72rem; color:#6c757d; font-weight: 500; margin-top: 2px;">Total Tanaman</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Galeri --}}
    <div class="col">
        <div class="card custom-stat-card shadow-sm h-100">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon-wrapper" style="background:#e8eaf6;">
                        <span style="font-size: 1.2rem;">🖼️</span>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold" style="font-size: 0.65rem; border-radius: 30px; color: #3949ab; background-color: rgba(57,73,171,0.1);">Foto</span>
                </div>
                <div>
                    <div style="font-size:1.65rem; font-weight:700; color:#3949ab; line-height: 1.2;">{{ $totalGaleri ?? 0 }}</div>
                    <div style="font-size:.72rem; color:#6c757d; font-weight: 500; margin-top: 2px;">Total Foto Galeri</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Berita --}}
    <div class="col">
        <div class="card custom-stat-card shadow-sm h-100">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon-wrapper" style="background:#fce4ec;">
                        <span style="font-size: 1.2rem;">📰</span>
                    </div>
                    <span class="badge bg-danger bg-opacity-10 text-danger fw-bold" style="font-size: 0.65rem; border-radius: 30px;">Informasi</span>
                </div>
                <div>
                    <div style="font-size:1.65rem; font-weight:700; color:#c2185b; line-height: 1.2;">{{ $totalBerita ?? 0 }}</div>
                    <div style="font-size:.72rem; color:#6c757d; font-weight: 500; margin-top: 2px;">Total Berita</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pengunjung Keseluruhan --}}
    <div class="col">
        <div class="card custom-stat-card shadow-sm h-100">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon-wrapper" style="background:#e0f7fa;">
                        <span style="font-size: 1.2rem;">👥</span>
                    </div>
                    <span class="badge bg-info bg-opacity-10 text-info fw-bold" style="font-size: 0.65rem; border-radius: 30px; color: #00838f; background-color: rgba(0,131,143,0.1);">Traffic</span>
                </div>
                <div>
                    <div style="font-size:1.65rem; font-weight:700; color:#00838f; line-height: 1.2;">{{ $totalPengunjung ?? 0 }}</div>
                    <div style="font-size:.72rem; color:#6c757d; font-weight: 500; margin-top: 2px;">Pengunjung Keseluruhan</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Ulasan --}}
    <div class="col">
        <div class="card custom-stat-card shadow-sm h-100">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon-wrapper" style="background:#fff3e0;">
                        <span style="font-size: 1.2rem;">💬</span>
                    </div>
                    {{-- ⚡ REVISI BADGE: Diganti menjadi 'Total' agar sesuai dengan kueri count data menyeluruh --}}
                    <span class="badge bg-warning text-dark fw-bold" style="font-size: 0.65rem; border-radius: 30px;">Total</span>
                </div>
                <div>
                    <div style="font-size:1.65rem; font-weight:700; color:#e65100; line-height: 1.2;">{{ $ulasanBelumBaca }}</div>
                    <div style="font-size:.72rem; color:#6c757d; font-weight: 500; margin-top: 2px;">Total Ulasan</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. SEKSI GRAFIK & LIST TANAMAN POPULER (SINKRON 30 HARI KEMBAR DENGAN ADMIN) --}}
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
            <div class="card-header bg-white py-3 fw-bold text-dark border-bottom-0">
                <i class="bi bi-graph-up me-2" style="color:#2d6a9e;"></i>Grafik Pengunjung 30 Hari Terakhir
            </div>
            <div class="card-body">
                <canvas id="grafikPJ" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
            <div class="card-header bg-white py-3 fw-bold text-dark border-bottom-0">
                <i class="bi bi-star me-2" style="color:#f9a825;"></i>Tanaman Paling Banyak Dilihat
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <tbody>
                        @foreach($tanamanPopuler as $i => $t)
                        <tr>
                            <td width="30" class="ps-3"><span class="badge rounded-pill" style="background:{{ $i==0?'#FFD700':($i==1?'#C0C0C0':($i==2?'#CD7F32':'#e8f5e9')) }};color:{{ $i<3?'#333':'#1a5c2a' }};">{{ $i+1 }}</span></td>
                            <td>
                                <div style="font-size:.84rem;font-weight:600;">{{ $t->nama }}</div>
                                <div style="font-size:.74rem;color:#888;font-style:italic;">{{ $t->nama_ilmiah }}</div>
                            </td>
                            <td class="pe-3 text-end" style="font-size:.82rem;color:#2d6a9e;font-weight:600;">{{ number_format($t->views) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikPJ').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($grafik,'tanggal')) !!},
        datasets: [{
            label: 'Pengunjung',
            data: {!! json_encode(array_column($grafik,'jumlah')) !!},
            backgroundColor: 'rgba(45,106,158,0.15)',
            borderColor: 'rgba(45,106,158,1)',
            borderWidth: 2, fill: true, tension: 0.4,
            pointBackgroundColor: 'rgba(45,106,158,1)',
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});
</script>
@endpush
@endsection