@extends('layouts.pj')
@section('title', 'Laporan Pengunjung')
@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div><h4 class="fw-bold text-dark mb-1">📊 Statistik Log Pengunjung</h4><p class="text-muted small mb-0">Review riwayat akses trafik sistem informasi kebun raya.</p></div>
    {{-- ⚡ REVISI: Menambahkan ikon printer fill agar seragam dan konsisten dengan halaman laporan lainnya --}}
    <button type="button" class="btn text-white px-4 fw-bold shadow-sm w-100 w-sm-auto text-center" style="background-color: #1a5c2a; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#modalCetak"><i class="bi bi-printer-fill me-1"></i> Cetak Laporan</button>
</div>

{{-- Saringan Filter (PAKET WAKTU DI SINI SUDAH DIHAPUS TOTAL DAN DIBUAT SEJAJAR RAPI) --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form action="{{ route('pj.laporan.pengunjung') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-5">
                <label class="form-label small fw-bold text-muted mb-1">Dari:</label>
                <input type="date" name="tanggal_mulai" class="form-control form-control-sm" value="{{ request('tanggal_mulai') }}" style="border-radius: 8px;">
            </div>
            <div class="col-12 col-md-5">
                <label class="form-label small fw-bold text-muted mb-1">Sampai:</label>
                <input type="date" name="tanggal_selesai" class="form-control form-control-sm" value="{{ request('tanggal_selesai') }}" style="border-radius: 8px;">
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-sm text-white w-100 fw-bold" style="background-color: #11411c; border-radius: 8px; height: 31px;">🔍 Terapkan</button>
            </div>
        </form>
     </div>
</div>

{{-- Tampilan Desktop (Tabel) --}}
<div class="d-none d-md-block">
    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                <thead class="text-white" style="background-color: #11411c;">
                    <tr>
                        <th class="ps-4 py-3" style="width: 60px;">No</th>
                        <th>Wilayah</th>
                        <th>Perangkat Perambah</th>
                        <th class="text-center">Waktu Akses</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengunjungs as $i => $p)
                    <tr>
                        <td class="ps-4 text-muted">{{ is_array($pengunjungs) ? $i+1 : $pengunjungs->firstItem() + $i }}</td>
                        <td class="fw-bold">{{ $p->ip_address ?? 'Tidak diketahui' }}</td>
                        <td class="text-truncate" style="max-width:250px;">{{ $p->user_agent ?? 'Chrome Windows' }}</td>
                        <td class="text-center text-muted">{{ $p->created_at ? $p->created_at->format('d-m-Y H:i') : now()->format('d-m-Y H:i') }} WIB</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data rekaman log trafik pengunjung.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Tampilan Mobile (Card List) --}}
<div class="d-md-none">
    @forelse($pengunjungs as $i => $p)
    <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                <span class="text-muted small">No. {{ is_array($pengunjungs) ? $i+1 : $pengunjungs->firstItem() + $i }}</span>
                <span class="text-muted small">{{ $p->created_at ? $p->created_at->format('d-m-Y H:i') : now()->format('d-m-Y H:i') }} WIB</span>
            </div>
            <div class="mb-2">
                <span class="text-muted small d-block">IP Pengunjung</span>
                <span class="fw-bold text-dark fs-6">{{ $p->ip_address ?? 'Tidak diketahui' }}</span>
            </div>
            <div>
                <span class="text-muted small d-block mb-1">User Agent / Perangkat</span>
                <div class="p-2 bg-light rounded text-muted small" style="word-break: break-all;">
                    {{ $p->user_agent ?? '-' }}
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card shadow-sm border-0 text-center p-4" style="border-radius: 10px;">
        <p class="text-muted mb-0">Belum ada data log pengunjung.</p>
    </div>
    @endforelse
</div>

@if(!is_array($pengunjungs) && $pengunjungs->hasPages())
    <div class="mt-3 px-2">
        {{ $pengunjungs->links() }}
    </div>
@endif

{{-- MODAL PARAMETER POPUP CETAK --}}
{{-- 💡 REVISI MODAL: Menambahkan class modal-lg agar ukuran pop-up melebar proporsional seperti laporan tanaman --}}
<div class="modal fade" id="modalCetak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header text-white" style="background-color: #11411c; border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title fw-bold">🖨️ Cetak Laporan Pengunjung</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pj.laporan.export') }}" method="GET" target="_blank">
                <input type="hidden" name="jenis_laporan" value="pengunjung">
                <div class="modal-body p-4">
                    {{-- ⚡ REVISI TAMBAHAN: Menyinkronkan dropdown Paket Waktu / Rentang Waktu di dalam pop-up modal --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">Rentang Waktu (Paket Cetak):</label>
                        <select name="rentang_cetak" class="form-select" style="border-radius: 8px;">
                            <option value="semua">✨ Semua Log Trafik</option>
                            <option value="tiga_bulan">📅 3 Bulan Terakhir</option>
                            <option value="enam_bulan">🗓️ 6 Bulan Terakhir</option>
                        </select>
                    </div>
                    <div class="text-center my-3 position-relative">
                        <hr>
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 text-muted small fw-bold">ATAU ATUR TANGGAL</span>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark small">Dari:</label>
                            <input type="date" name="cetak_tanggal_mulai" class="form-control" style="border-radius: 8px;">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark small">Sampai:</label>
                            <input type="date" name="cetak_tanggal_selesai" class="form-control" style="border-radius: 8px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-secondary fw-bold px-3" style="border-radius: 8px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white fw-bold px-4" style="background-color: #1a5c2a; border-radius: 8px;">Proses Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection