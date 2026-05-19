@extends('layouts.pj')
@section('title', 'Kotak Saran Masuk')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">💬 Kotak Saran & Masukan Pengunjung</h4>
        <p class="text-muted small mb-0">Review kritik, saran, dan umpan balik masyarakat terhadap sistem SITOBAT Universitas Pahlawan.</p>
    </div>
    {{-- TAMBAHAN: Tombol Cetak Laporan Saran --}}
    <button type="button" class="btn text-white px-4 fw-bold shadow-sm" style="background-color: #1a5c2a; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#modalCetakSaran">
        <i class="bi bi-printer me-2"></i> Cetak Laporan
    </button>
</div>

{{-- FORM FILTER KALENDER --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form action="{{ route('pj.saran.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted mb-1">Dari Tanggal:</label>
                <input type="date" name="tanggal_mulai" class="form-control form-control-sm" value="{{ request('tanggal_mulai') }}" style="border-radius: 8px;">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted mb-1">Sampai Tanggal:</label>
                <input type="date" name="tanggal_selesai" class="form-control form-control-sm" value="{{ request('tanggal_selesai') }}" style="border-radius: 8px;">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-sm text-white w-100 fw-bold" style="background-color: #11411c; border-radius: 8px; height: 31px;">
                    <i class="bi bi-filter me-1"></i> Terapkan Saringan Saran
                </button>
            </div>
        </form>
    </div>
</div>

{{-- TABEL DATA KOTAK SARAN MASUK --}}
<div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                <thead class="text-white" style="background-color: #11411c;">
                    <tr>
                        <th class="ps-4 py-3" style="width: 60px;">No</th>
                        <th>Pengirim</th>
                        <th>Isi Kritik & Saran</th>
                        <th>Tanggal Kirim</th>
                        <th class="text-center" style="width: 150px;">Status</th>
                        <th class="text-center" style="width: 150px;">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sarans as $index => $s)
                    <tr style="{{ !$s->is_read ? 'background-color: rgba(26, 92, 42, 0.02);' : '' }}">
                        <td class="ps-4 fw-semibold text-muted">
                            {{ $sarans->firstItem() + $index }}
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">{{ $s->nama ?? 'Anonim' }}</span>
                            <small class="text-muted">{{ $s->email ?? $s->no_hp ?? '-' }}</small>
                        </td>
                        <td>
                            <div class="text-muted text-truncate" style="max-width: 380px;">
                                {{ $s->isi_saran ?? $s->pesan ?? $s->isi ?? 'Tidak ada teks pesan.' }}
                            </div>
                        </td>
                        <td>
                            <span class="text-muted small">{{ $s->created_at ? $s->created_at->format('d-m-Y H:i') : '-' }} WIB</span>
                        </td>
                        <td class="text-center">
                            @if(isset($s->is_read) && !$s->is_read)
                                <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 small fw-bold">
                                    📩 Belum Dibaca
                                </span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 small fw-bold">
                                    ✅ Sudah Ditinjau
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pj.saran.show', $s->id) }}" class="btn btn-sm btn-light border fw-semibold py-1 px-3" style="border-radius: 8px;">
                                <i class="bi bi-eye me-1"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-envelope-open fs-1 text-success d-block mb-2" style="opacity: 0.5;"></i>
                            <h6 class="fw-bold mb-1">Belum Ada Saran Masuk</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $sarans->links() }}
</div>

{{-- MODAL PARAMETER POP-UP CETAK KHUSUS SARAN --}}
<div class="modal fade" id="modalCetakSaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header text-white" style="background-color: #11411c; border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title fw-bold">🖨️ Parameter Cetak Laporan Saran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pj.laporan.export') }}" method="GET" target="_blank">
                {{-- Input hidden untuk memberi tahu LaporanController kalau yang dicetak adalah modul saran --}}
                <input type="hidden" name="jenis_laporan" value="saran">
                
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Silakan tentukan parameter rentang waktu data saran masuk yang ingin diekspor ke dalam dokumen cetak fisik.</p>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small">Pilihan Paket Cetak:</label>
                        <select name="rentang_cetak" class="form-select" style="border-radius: 8px;">
                            <option value="semua">✨ Semua Data Saran Masuk</option>
                            <option value="tiga_bulan">📅 3 Bulan Terakhir</option>
                            <option value="enam_bulan">🗓️ 6 Bulan Terakhir</option>
                        </select>
                    </div>

                    <div class="text-center my-3 position-relative">
                        <hr class="text-muted">
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small fw-bold">ATAU ATUR TANGGAL KUSTOM</span>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark small">Dari Tanggal:</label>
                            <input type="date" name="cetak_tanggal_mulai" class="form-control" style="border-radius: 8px;">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark small">Sampai Tanggal:</label>
                            <input type="date" name="cetak_tanggal_selesai" class="form-control" style="border-radius: 8px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-secondary fw-bold px-3" style="border-radius: 8px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white fw-bold px-4" style="background-color: #1a5c2a; border-radius: 8px;">
                        <i class="bi bi-printer-fill me-1"></i> Proses Cetak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection