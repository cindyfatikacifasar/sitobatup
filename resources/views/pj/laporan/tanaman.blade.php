{{-- resources/views/pj/laporan/tanaman.blade.php --}}
@extends('layouts.pj')
@section('title','Laporan Tanaman Obat')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold" style="color:#1a3a5c;">🌿 Laporan Koleksi Tanaman Obat</h5>
    <a href="{{ route('pj.laporan.export') }}" target="_blank" class="btn btn-sm btn-success"><i class="bi bi-printer me-1"></i>Cetak Laporan</a>
</div>

<!-- Statistik -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div style="font-size:1.8rem;font-weight:700;color:#1a3a5c;">{{ $stats['total'] }}</div>
            <div style="font-size:.78rem;color:#888;">Total Koleksi</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div style="font-size:1.8rem;font-weight:700;color:#388e3c;">{{ $stats['tersedia'] }}</div>
            <div style="font-size:.78rem;color:#888;">Tersedia</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div style="font-size:1.8rem;font-weight:700;color:#c62828;">{{ $stats['tidak_tersedia'] }}</div>
            <div style="font-size:.78rem;color:#888;">Tidak Tersedia</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div style="font-size:1.8rem;font-weight:700;color:#1565c0;">{{ $kategoris->count() }}</div>
            <div style="font-size:.78rem;color:#888;">Kategori</div>
        </div>
    </div>
</div>

<!-- Per Kategori -->
<div class="card mb-4">
    <div class="card-header fw-600"><i class="bi bi-pie-chart me-2"></i>Distribusi per Kategori</div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Kategori</th><th>Jumlah Tanaman</th><th>Persentase</th></tr></thead>
            <tbody>
                @foreach($stats['per_kategori'] as $k)
                <tr>
                    <td style="font-size:.86rem;">{{ $k->nama }}</td>
                    <td><span class="badge bg-success">{{ $k->tanaman_obats_count }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress flex-fill" style="height:8px;">
                                <div class="progress-bar bg-success" style="width:{{ $stats['total'] > 0 ? round($k->tanaman_obats_count/$stats['total']*100) : 0 }}%"></div>
                            </div>
                            <span style="font-size:.8rem;min-width:35px;">{{ $stats['total'] > 0 ? round($k->tanaman_obats_count/$stats['total']*100) : 0 }}%</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Filter & Tabel Tanaman -->
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <select name="kategori" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)<option value="{{ $k->id }}" {{ request('kategori')==$k->id?'selected':'' }}>{{ $k->nama }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="tersedia" {{ request('status')=='tersedia'?'selected':'' }}>Tersedia</option>
                <option value="tidak_tersedia" {{ request('status')=='tidak_tersedia'?'selected':'' }}>Tidak Tersedia</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-1">
            <button type="submit" class="btn btn-primary btn-sm flex-fill"><i class="bi bi-search me-1"></i>Filter</button>
            <a href="{{ route('pj.laporan.tanaman') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
        </div>
    </form>
</div></div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>#</th><th>Nama Tanaman</th><th>Nama Ilmiah</th><th class="d-none d-md-table-cell">Kategori</th><th class="d-none d-lg-table-cell">Bagian</th><th>Status</th><th class="d-none d-lg-table-cell">Views</th></tr></thead>
                <tbody>
                    @forelse($tanaman as $i => $t)
                    <tr>
                        <td>{{ $tanaman->firstItem()+$i }}</td>
                        <td style="font-size:.86rem;font-weight:600;">{{ $t->nama }}</td>
                        <td style="font-size:.82rem;font-style:italic;color:#666;">{{ $t->nama_ilmiah }}</td>
                        <td class="d-none d-md-table-cell"><span class="badge" style="background:#e8f5e9;color:#1a5c2a;font-size:.72rem;">{{ $t->kategori->nama??'-' }}</span></td>
                        <td class="d-none d-lg-table-cell" style="font-size:.82rem;">{{ ucfirst($t->bagian_digunakan??'-') }}</td>
                        <td><span class="badge {{ $t->status_ketersediaan=='tersedia'?'bg-success':'bg-danger' }}" style="font-size:.72rem;">{{ $t->status_ketersediaan=='tersedia'?'Tersedia':'Tidak' }}</span></td>
                        <td class="d-none d-lg-table-cell" style="font-size:.82rem;">{{ number_format($t->views) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tanaman->hasPages())<div class="card-footer">{{ $tanaman->links() }}</div>@endif
</div>
@endsection