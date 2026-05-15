{{-- resources/views/pj/laporan/pengunjung.blade.php --}}
@extends('layouts.pj')
@section('title','Laporan Pengunjung')
@section('content')
<h5 class="mb-3 fw-bold" style="color:#1a3a5c;">👥 Laporan Data Pengunjung</h5>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div style="font-size:1.8rem;font-weight:700;color:#1a3a5c;">{{ number_format($hari) }}</div>
            <div style="font-size:.78rem;color:#888;">Hari Ini</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div style="font-size:1.8rem;font-weight:700;color:#1565c0;">{{ number_format($minggu) }}</div>
            <div style="font-size:.78rem;color:#888;">Minggu Ini</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div style="font-size:1.8rem;font-weight:700;color:#388e3c;">{{ number_format($bulan) }}</div>
            <div style="font-size:.78rem;color:#888;">Bulan Ini</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div style="font-size:1.8rem;font-weight:700;color:#6a1b9a;">{{ number_format($total) }}</div>
            <div style="font-size:.78rem;color:#888;">Total Keseluruhan</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="bi bi-graph-up me-2"></i>Tren Pengunjung 30 Hari Terakhir</div>
    <div class="card-body">
        <canvas id="grafikPengunjung" height="100"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikPengunjung').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($grafik,'tanggal')) !!},
        datasets: [{
            label: 'Jumlah Pengunjung',
            data: {!! json_encode(array_column($grafik,'jumlah')) !!},
            backgroundColor: 'rgba(45,106,158,0.5)',
            borderColor: 'rgba(45,106,158,1)',
            borderWidth: 1, borderRadius: 4,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});
</script>
@endpush
@endsection