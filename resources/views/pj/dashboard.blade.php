{{-- resources/views/pj/dashboard.blade.php --}}
@extends('layouts.pj')
@section('title','Dashboard Laporan')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div style="font-size:1.7rem;font-weight:700;color:#1a3a5c;">{{ $totalTanaman }}</div>
            <div style="font-size:.78rem;color:#888;">🌿 Total Tanaman</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div style="font-size:1.7rem;font-weight:700;color:#1a3a5c;">{{ $totalKategori }}</div>
            <div style="font-size:.78rem;color:#888;">🏷️ Kategori</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div style="font-size:1.7rem;font-weight:700;color:#e65100;">{{ $saranBelumBaca }}</div>
            <div style="font-size:.78rem;color:#888;">💬 Saran Belum Dibaca</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div style="font-size:1.7rem;font-weight:700;color:#388e3c;">{{ $pengunjungHari }}</div>
            <div style="font-size:.78rem;color:#888;">👥 Pengunjung Hari Ini</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-graph-up me-2" style="color:#2d6a9e;"></i>Grafik Pengunjung 14 Hari Terakhir</div>
            <div class="card-body">
                <canvas id="grafikPJ" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-star me-2" style="color:#f9a825;"></i>Tanaman Paling Banyak Dilihat</div>
            <div class="card-body p-0">
                <table class="table mb-0">
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

<!-- Aksi Cepat -->
<div class="card mb-4">
    <div class="card-header"><i class="bi bi-lightning me-2" style="color:#f9a825;"></i>Aksi Cepat</div>
    <div class="card-body">
        <div class="row g-2">
            <div class="col-6 col-md-3">
                <a href="{{ route('pj.laporan.tanaman') }}" class="btn btn-success w-100 py-3 d-flex flex-column align-items-center gap-1" style="border-radius:12px;">
                    <span style="font-size:1.5rem;">🌿</span><span style="font-size:.82rem;">Laporan Tanaman</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('pj.laporan.pengunjung') }}" class="btn btn-primary w-100 py-3 d-flex flex-column align-items-center gap-1" style="border-radius:12px;">
                    <span style="font-size:1.5rem;">👥</span><span style="font-size:.82rem;">Laporan Pengunjung</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('pj.saran.index') }}" class="btn btn-warning w-100 py-3 d-flex flex-column align-items-center gap-1" style="border-radius:12px;">
                    <span style="font-size:1.5rem;">💬</span><span style="font-size:.82rem;">Lihat Saran ({{ $saranBelumBaca }})</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('pj.saran.create') }}" class="btn btn-info w-100 py-3 d-flex flex-column align-items-center gap-1 text-white" style="border-radius:12px;">
                    <span style="font-size:1.5rem;">📨</span><span style="font-size:.82rem;">Kirim Saran ke Admin</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Saran Terbaru -->
@if($saranTerbaru->count())
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-chat-dots me-2"></i>Saran Terbaru dari Masyarakat</span>
        <a href="{{ route('pj.saran.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Nama</th><th>Pesan</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($saranTerbaru as $s)
                <tr class="{{ !$s->is_read?'table-warning':'' }}">
                    <td style="font-size:.84rem;font-weight:{{ !$s->is_read?'700':'400' }};">{{ $s->nama }}</td>
                    <td style="font-size:.82rem;">{{ Str::limit($s->pesan,50) }}</td>
                    <td><span class="badge {{ !$s->is_read?'bg-danger':'bg-secondary' }}" style="font-size:.7rem;">{{ !$s->is_read?'Baru':'Dibaca' }}</span></td>
                    <td style="font-size:.78rem;">{{ $s->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('pj.saran.show',$s->id) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

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