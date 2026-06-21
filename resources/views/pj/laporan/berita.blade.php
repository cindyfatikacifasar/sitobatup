@extends('layouts.pj')
@section('title', 'Laporan Berita')
@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div><h4 class="fw-bold text-dark mb-1">📰 Laporan Publikasi Berita</h4><p class="text-muted small mb-0">Review artikel edukasi Universitas Pahlawan.</p></div>
    <button type="button" class="btn text-white px-4 fw-bold shadow-sm w-100 w-sm-auto text-center" style="background-color: #1a5c2a; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#modalCetak"><i class="bi bi-printer-fill me-1"></i> Cetak Laporan</button>
</div>

{{-- Saringan Filter (PAKET WAKTU DI SINI SUDAH DIHAPUS TOTAL DAN DIBUAT SEJAJAR RAPI) --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form action="{{ route('pj.laporan.berita') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-5">
                <label class="form-label small fw-bold text-muted mb-1">Dari Tanggal:</label>
                <input type="date" name="tanggal_mulai" class="form-control form-control-sm" value="{{ request('tanggal_mulai') }}" style="border-radius: 8px;">
            </div>
            <div class="col-12 col-md-5">
                <label class="form-label small fw-bold text-muted mb-1">Sampai Tanggal:</label>
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
                        <th>Judul Artikel</th>
                        <th>Tanggal Rilis</th>
                        <th class="text-center" style="width: 130px;">Total Klik</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beritas as $i => $b)
                    <tr>
                        <td class="ps-4 text-muted">{{ $beritas->firstItem() + $i }}</td>
                        <td class="fw-bold text-dark">{{ $b->judul }}</td>
                        <td>{{ $b->created_at->format('d-m-Y') }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-3 py-2 fw-bold">👁️ {{ $b->views ?? 0 }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data berita.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Tampilan Mobile (Card List) --}}
<div class="d-md-none">
    @forelse($beritas as $i => $b)
    <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                <span class="text-muted small">No. {{ $beritas->firstItem() + $i }}</span>
                <span class="badge bg-light text-dark border px-2.5 py-0.5 fw-bold" style="font-size: 0.68rem;">
                    👁️ {{ $b->views ?? 0 }} views
                </span>
            </div>
            
            <div class="mb-2">
                <span class="text-muted small d-block mb-0.5">Judul Artikel</span>
                <div class="fw-bold text-dark fs-6">{{ $b->judul }}</div>
            </div>
            
            <div>
                <span class="text-muted small d-block mb-0.5">Tanggal Rilis</span>
                <span class="text-muted small"><i class="bi bi-calendar-event me-1"></i> {{ $b->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="card shadow-sm border-0 text-center p-4" style="border-radius: 10px;">
        <p class="text-muted mb-0">Belum ada data berita.</p>
    </div>
    @endforelse
</div>

@if($beritas->hasPages())
    <div class="mt-3 px-2">
        {{ $beritas->links() }}
    </div>
@endif

{{-- MODAL PARAMETER POPUP CETAK --}}
<div class="modal fade" id="modalCetak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header text-white" style="background-color: #11411c; border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title fw-bold">🖨️ Cetak Laporan Berita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pj.laporan.export') }}" method="GET" target="_blank">
                <input type="hidden" name="jenis_laporan" value="berita">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">Rentang Waktu (Paket Cetak):</label>
                        <select name="rentang_waktu" class="form-select" style="border-radius: 8px;">
                            <option value="semua">✨ Semua Data Berita</option>
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
                            <label class="form-label fw-bold text-dark small">Dari Tanggal:</label>
                            <input type="date" name="tanggal_mulai" class="form-control" style="border-radius: 8px;">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark small">Sampai Tanggal:</label>
                            <input type="date" name="tanggal_selesai" class="form-control" style="border-radius: 8px;">
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