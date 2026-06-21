@extends('layouts.pj')
@section('title', 'Laporan Galeri')
@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div><h4 class="fw-bold text-dark mb-1">🖼️ Laporan Album Dokumentasi</h4><p class="text-muted small mb-0">Review album visual kegiatan kebun raya.</p></div>
    {{-- ⚡ REVISI: Menambahkan ikon printer fill agar kembar identik dengan tombol cetak --}}
    <button type="button" class="btn text-white px-4 fw-bold shadow-sm text-center" style="background-color: #1a5c2a; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#modalCetak"><i class="bi bi-printer-fill me-1"></i> Cetak Laporan</button>
</div>

{{-- Saringan Filter (PAKET WAKTU DI SINI SUDAH DIHAPUS TOTAL DAN DIBUAT SEJAJAR RAPI) --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form action="{{ route('pj.laporan.galeri') }}" method="GET" class="row g-2 align-items-end">
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
    <div class="card shadow-sm border-0" style="border-radius: 10px;">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary" style="width: 70px;">No</th>
                        <th class="py-3 text-secondary">Nama Album Dokumentasi</th>
                        <th class="py-3 text-secondary" style="width: 320px;">Deskripsi Album</th>
                        <th class="py-3 text-secondary text-center" style="width: 180px;">Total Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($albums as $i => $album)
                    <tr>
                        <td class="px-4 fw-bold text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-bold text-dark" style="font-size:0.88rem;">
                                <i class="bi bi-folder-fill text-warning me-2"></i>{{ $album->nama_album }}
                            </div>
                        </td>
                        <td class="text-muted small">
                            {{ $album->deskripsi ?? 'Tidak ada deskripsi.' }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 fw-bold" style="border-radius: 30px; font-size: 0.75rem;">
                                <i class="bi bi-image me-1"></i> {{ $album->galeris_count }} Berkas Foto
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="bi bi-images fs-2 d-block mb-2 text-secondary opacity-50"></i>
                            Belum ada album visual terdokumentasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Tampilan Mobile (Card List) --}}
<div class="d-md-none">
    @forelse($albums as $i => $album)
    <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                <span class="text-muted small">No. {{ $loop->iteration }}</span>
                <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-0.5 fw-bold" style="border-radius: 30px; font-size: 0.68rem;">
                    <i class="bi bi-image me-1"></i> {{ $album->galeris_count }} Foto
                </span>
            </div>
            
            <div class="mb-2">
                <span class="text-muted small d-block mb-0.5">Nama Album</span>
                <div class="fw-bold text-dark fs-6">
                    <i class="bi bi-folder-fill text-warning me-1.5"></i>{{ $album->nama_album }}
                </div>
            </div>
            
            <div>
                <span class="text-muted small d-block mb-0.5">Deskripsi</span>
                <p class="text-muted small mb-0">{{ $album->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>
    </div>
    @empty
    <div class="card shadow-sm border-0 text-center p-4" style="border-radius: 10px;">
        <p class="text-muted mb-0">Belum ada album visual terdokumentasi.</p>
    </div>
    @endforelse
</div>

{{-- MODAL PARAMETER POPUP CETAK --}}
{{-- 💡 REVISI MODAL: Menambahkan class modal-lg agar ukuran pop-up melebar proporsional seperti laporan tanaman --}}
<div class="modal fade" id="modalCetak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header text-white" style="background-color: #11411c; border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title fw-bold">🖨️ Cetak Laporan Galeri</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pj.laporan.export') }}" method="GET" target="_blank">
                <input type="hidden" name="jenis_laporan" value="galeri">
                <div class="modal-body p-4">
                    {{-- ⚡ REVISI TAMBAHAN: Menyinkronkan dropdown Paket Waktu / Rentang Waktu di dalam pop-up modal --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">Rentang Waktu (Paket Cetak):</label>
                        <select name="rentang_cetak" class="form-select" style="border-radius: 8px;">
                            <option value="semua">✨ Semua Album</option>
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