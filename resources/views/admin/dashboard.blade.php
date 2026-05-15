@extends('layouts.admin')
@section('title','Dashboard')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="stat-icon" style="background:#e8f5e9;color:#2d8a4e;font-size:1.2rem;">🌿</div>
            </div>
            <div style="font-size:1.8rem;font-weight:700;color:#1a5c2a;">{{ $totalTanaman }}</div>
            <div style="font-size:.78rem;color:#888;">Total Tanaman</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e3f2fd;color:#1976d2;font-size:1.2rem;">🏷️</div>
            <div style="font-size:1.8rem;font-weight:700;color:#1976d2;">{{ $totalKategori }}</div>
            <div style="font-size:.78rem;color:#888;">Kategori</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce4ec;color:#c2185b;font-size:1.2rem;">📰</div>
            <div style="font-size:1.8rem;font-weight:700;color:#c2185b;">{{ $totalBerita }}</div>
            <div style="font-size:.78rem;color:#888;">Total Berita</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8eaf6;color:#3949ab;font-size:1.2rem;">🖼️</div>
            <div style="font-size:1.8rem;font-weight:700;color:#3949ab;">{{ $totalGaleri }}</div>
            <div style="font-size:.78rem;color:#888;">Galeri</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff3e0;color:#e65100;font-size:1.2rem;">💬</div>
            <div style="font-size:1.8rem;font-weight:700;color:#e65100;">{{ $saranBelumBaca }}</div>
            <div style="font-size:.78rem;color:#888;">Saran Baru</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f5e9;color:#388e3c;font-size:1.2rem;">👥</div>
            <div style="font-size:1.8rem;font-weight:700;color:#388e3c;">{{ $pengunjungHari }}</div>
            <div style="font-size:.78rem;color:#888;">Pengunjung Hari Ini</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Grafik pengunjung -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-graph-up me-2" style="color:#2d8a4e;"></i>Grafik Pengunjung 30 Hari Terakhir
            </div>
            <div class="card-body">
                <canvas id="grafikPengunjung" height="100"></canvas>
            </div>
        </div>
    </div>
    <!-- Tanaman Populer -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-star me-2" style="color:#f9a825;"></i>Tanaman Paling Sering Dilihat
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
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

<!-- Aksi Cepat -->
<div class="card">
    <div class="card-header"><i class="bi bi-lightning me-2" style="color:#f9a825;"></i>Aksi Cepat</div>
    <div class="card-body">
        <div class="row g-2">
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.tanaman.create') }}" class="btn btn-success w-100 py-3 d-flex flex-column align-items-center gap-1" style="border-radius:12px;">
                    <span style="font-size:1.5rem;">🌿</span><span style="font-size:.82rem;">+ Tanaman Baru</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.berita.create') }}" class="btn btn-primary w-100 py-3 d-flex flex-column align-items-center gap-1" style="border-radius:12px;">
                    <span style="font-size:1.5rem;">📰</span><span style="font-size:.82rem;">+ Berita Baru</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.galeri.create') }}" class="btn btn-info w-100 py-3 d-flex flex-column align-items-center gap-1 text-white" style="border-radius:12px;">
                    <span style="font-size:1.5rem;">🖼️</span><span style="font-size:.82rem;">+ Foto Galeri</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.saran.index') }}" class="btn btn-warning w-100 py-3 d-flex flex-column align-items-center gap-1" style="border-radius:12px;">
                    <span style="font-size:1.5rem;">💬</span><span style="font-size:.82rem;">Cek Saran ({{ $saranBelumBaca }})</span>
                </a>
            </div>
        </div>
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