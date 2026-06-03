@extends('layouts.pj')
@section('title', 'Laporan Tanaman Obat')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">🌿 Laporan Koleksi Tanaman Obat</h4>
        <p class="text-muted small mb-0">Review database tanaman obat keluarga (Apotek Hidup) Universitas Pahlawan.</p>
    </div>
    
    {{-- Tombol Pemicu Modal Pop-up Cetak --}}
    <button type="button" class="btn text-white px-4 fw-bold shadow-sm" style="background-color: #1a5c2a; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#modalCetakLaporan">
        <i class="bi bi-printer me-2"></i> Cetak Laporan
    </button>
</div>

{{-- FORM FILTER UTAMA (DI HALAMAN UTAMA - ⚡ REVISI: PAKET WAKTU DIHAPUS & GRID DIPERLEBAR) --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form action="{{ route('pj.laporan.tanaman') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-bold text-muted mb-1">Dari Tanggal:</label>
                <input type="date" name="tanggal_mulai" class="form-control form-control-sm" value="{{ request('tanggal_mulai') }}" style="border-radius: 8px;">
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-bold text-muted mb-1">Sampai Tanggal:</label>
                <input type="date" name="tanggal_selesai" class="form-control form-control-sm" value="{{ request('tanggal_selesai') }}" style="border-radius: 8px;">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm text-white w-100 fw-bold" style="background-color: #11411c; border-radius: 8px; height: 31px;">
                    <i class="bi bi-filter me-1"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- TABEL DATA TANAMAN OBAT --}}
<div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                <thead class="text-white" style="background-color: #11411c;">
                    <tr>
                        <th class="ps-4 py-3" style="width: 60px;">No</th>
                        <th style="width: 100px;">Foto</th>
                        <th>Nama Lokal</th>
                        <th>Nama Ilmiah</th>
                        <th>Kategori</th>
                        <th class="text-center" style="width: 130px;">Total Dilihat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tanamans as $index => $t)
                    <tr>
                        <td class="ps-4 fw-semibold text-muted">
                            {{ method_exists($tanamans, 'firstItem') ? $tanamans->firstItem() + $index : $index + 1 }}
                        </td>
                        <td>
                            @php $fileFoto = $t->foto ?? $t->gambar ?? null; @endphp
                            @if($fileFoto)
                                <img src="{{ asset('storage/' . $fileFoto) }}" class="rounded shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted shadow-sm" style="width: 60px; height: 60px; font-size: 1.2rem;">🌱</div>
                            @endif
                        </td>
                        <td><span class="fw-bold text-dark">{{ $t->nama_lokal ?? $t->nama ?? 'Tanaman Obat' }}</span></td>
                        <td><span class="text-muted"><i>{{ $t->nama_ilmiah ?? '-' }}</i></span></td>
                        <td>
                            @if(isset($t->kategori))
                                <span class="badge bg-opacity-10 text-success p-2 small" style="background-color: rgba(26, 92, 42, 0.1); font-weight: 600;">
                                    {{ $t->kategori->nama_kategori ?? $t->kategori->nama ?? 'Umum' }}
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-light text-dark px-3 py-2 border fw-bold">
                                <i class="bi bi-eye text-primary me-1"></i> {{ $t->views ?? 0 }} Kali
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-tree fs-1 text-success d-block mb-2" style="opacity: 0.5;"></i>
                            <h6 class="fw-bold mb-1">Belum Ada Data Tanaman</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ method_exists($tanamans, 'links') ? $tanamans->links() : '' }}
</div>

{{-- MODAL POP-UP CETAK LAPORAN (⚡ REVISI UTAMA: MODAL-LG & PADDING P-5 SUPAYA LAPANG & RAPI, PAKET CETAK DIHAPUS) --}}
<div class="modal fade" id="modalCetakLaporan" tabindex="-1" aria-labelledby="modalCetakLaporanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> {{-- ⚡ Perubahan ukuran menjadi modal-lg --}}
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header text-white px-4 py-3" style="background-color: #11411c; border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title fw-bold" id="modalCetakLaporanLabel">🖨️ Cetak Dokumen Laporan Koleksi Tanaman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pj.laporan.export') }}" method="GET" target="_blank">
                <input type="hidden" name="jenis_laporan" value="tanaman">
                <div class="modal-body p-5"> {{-- ⚡ Perubahan padding menjadi p-5 agar visual terasa longgar dan rapi --}}
                    <p class="text-muted mb-4" style="font-size: 0.95rem;">Silakan tentukan rentang kalender di bawah ini untuk mengunduh berkas fisik laporan data tanaman obat keluarga secara berkala.</p>
                    
                    {{-- Rentang Tanggal Kalender Kustom Kolom Lebar --}}
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-2">Dari Tanggal:</label>
                            <input type="date" name="cetak_tanggal_mulai" class="form-control form-control-lg" style="border-radius: 8px; font-size: 0.95rem;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-2">Sampai Tanggal:</label>
                            <input type="date" name="cetak_tanggal_selesai" class="form-control form-control-lg" style="border-radius: 8px; font-size: 0.95rem;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px; border-top: 1px solid #eee;">
                    <button type="button" class="btn btn-secondary fw-bold px-4 py-2" style="border-radius: 8px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white fw-bold px-5 py-2" style="background-color: #1a5c2a; border-radius: 8px;">
                        <i class="bi bi-printer me-1"></i> Proses Cetak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection