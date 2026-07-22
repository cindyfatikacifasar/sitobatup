@extends('layouts.pj')
@section('title', 'Kotak Saran Masuk')
@section('content')

<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        {{-- Mengubah nama judul halaman menjadi Laporan Saran --}}
        <h4 class="fw-bold text-dark mb-1">💬 Laporan Ulasan Pengunjung</h4>
        <p class="text-muted small mb-0">Review kritik, ulasan, dan umpan balik masyarakat terhadap sistem Taman Herbal Kebun Raya Universitas Pahlawan.</p>
    </div>
    {{-- TAMBAHAN: Tombol Cetak Laporan Saran --}}
    <button type="button" class="btn text-white px-4 fw-bold shadow-sm text-center" style="background-color: #1a5c2a; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#modalCetakUlasan">
        <i class="bi bi-printer-fill me-2"></i> Cetak Laporan
    </button>
</div>

{{-- FORM FILTER KALENDER --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form action="{{ route('pj.ulasan.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-5">
                <label class="form-label small fw-bold text-muted mb-1">Dari Tanggal:</label>
                <input type="date" name="tanggal_mulai" class="form-control form-control-sm" value="{{ request('tanggal_mulai') }}" style="border-radius: 8px;">
            </div>
            <div class="col-12 col-md-5">
                <label class="form-label small fw-bold text-muted mb-1">Sampai Tanggal:</label>
                <input type="date" name="tanggal_selesai" class="form-control form-control-sm" value="{{ request('tanggal_selesai') }}" style="border-radius: 8px;">
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-sm text-white w-100 fw-bold" style="background-color: #11411c; border-radius: 8px; height: 31px;">
                    <i class="bi bi-filter me-1"></i> Filter Tanggal
                </button>
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
                        <th>Pengirim</th>
                        <th>Isi Ulasan </th>
                        <th>Tanggal Kirim</th>
                        {{-- PERBAIKAN: Mengubah nama kolom sesuai instruksi Sindi --}}
                        <th class="text-center" style="width: 150px;">Rating</th>
                        <th class="text-center" style="width: 180px;">Kontak Pengunjung</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ulasan as $index => $s)
                    <tr style="{{ (isset($s->is_read) && !$s->is_read) ? 'background-color: rgba(26, 92, 42, 0.02);' : '' }}">
                        <td class="ps-4 fw-semibold text-muted">
                            {{ $ulasan->firstItem() + $index }}
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">{{ $s->nama ?? 'Anonim' }}</span>
                            <small class="text-muted">{{ $s->email ?? '-' }}</small>
                        </td>
                        <td>
                            <div class="text-muted text-wrap" style="max-width: 380px;">
                                {{ $s->isi_ulasan ?? $s->pesan ?? $s->isi ?? 'Tidak ada teks pesan.' }}
                            </div>
                        </td>
                        <td>
                            <span class="text-muted small">{{ $s->created_at ? $s->created_at->format('d-m-Y H:i') : '-' }} WIB</span>
                        </td>
                        {{-- PERBAIKAN: Mengganti Status dengan Output Bintang Rating --}}
                        <td class="text-center">
                            @if(isset($s->rating) && $s->rating > 0)
                                <div class="text-warning small">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $s->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                </div>
                            @else
                                <span class="text-muted small">⭐⭐⭐⭐⭐</span>
                            @endif
                        </td>
                        {{-- PERBAIKAN: Mengganti Detail dengan Informasi Kontak Handphone Pengunjung --}}
                        <td class="text-center">
                            @if(!empty($s->no_hp) || !empty($s->telepon))
                                <span class="badge bg-light text-success border border-success-subtle py-1 px-2" style="font-size: 0.85rem; border-radius: 6px;">
                                    <i class="bi bi-whatsapp me-1"></i> {{ $s->no_hp ?? $s->telepon }}
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-envelope-open fs-1 text-success d-block mb-2" style="opacity: 0.5;"></i>
                            <h6 class="fw-bold mb-1">Belum Ada Ulasan Masuk</h6>
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
    @forelse($ulasan as $index => $s)
    <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px; {{ (isset($s->is_read) && !$s->is_read) ? 'border-left: 4px solid #1a5c2a;' : '' }}">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                <span class="text-muted small">No. {{ $ulasan->firstItem() + $index }}</span>
                <span class="text-muted small">{{ $s->created_at ? $s->created_at->format('d-m-Y H:i') : '-' }} WIB</span>
            </div>
            
            <div class="mb-2">
                <span class="fw-bold text-dark d-block fs-6">{{ $s->nama ?? 'Anonim' }}</span>
                <small class="text-muted d-block mb-1">{{ $s->email ?? '-' }}</small>
                
                @if(isset($s->rating) && $s->rating > 0)
                    <div class="text-warning small mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $s->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                        @endfor
                    </div>
                @else
                    <span class="text-muted small d-block mb-2">⭐⭐⭐⭐⭐</span>
                @endif
            </div>
            
            <div class="p-2 bg-light rounded text-muted mb-3" style="font-size: 0.85rem; line-height: 1.45;">
                {{ $s->isi_ulasan ?? $s->pesan ?? $s->isi ?? 'Tidak ada teks pesan.' }}
            </div>
            
            @if(!empty($s->no_hp) || !empty($s->telepon))
            <div class="d-flex justify-content-end">
                <span class="badge bg-light text-success border border-success-subtle py-1.5 px-3" style="font-size: 0.8rem; border-radius: 6px;">
                    <i class="bi bi-whatsapp me-1"></i> {{ $s->no_hp ?? $s->telepon }}
                </span>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="card shadow-sm border-0 text-center p-4" style="border-radius: 10px;">
        <p class="text-muted mb-0">Belum Ada Ulasan Masuk</p>
    </div>
    @endforelse
</div>

@if($ulasan->hasPages())
    <div class="mt-3 px-2">
        {{ $ulasan->links() }}
    </div>
@endif

{{-- MODAL PARAMETER POP-UP CETAK (⚡ REVISI: DISULAP JADI LEBAR LUAS DENGAN PADDING LAPANG P-5 SEPERTI TANAMAN) --}}
<div class="modal fade" id="modalCetakUlasan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> {{-- ⚡ Perubahan ukuran menjadi modal-lg --}}
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header text-white px-4 py-3" style="background-color: #11411c; border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title fw-bold">🖨️ Cetak Laporan Ulasan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pj.laporan.export') }}" method="GET" target="_blank">
                {{-- Input hidden untuk memberi tahu LaporanController kalau yang dicetak adalah modul ulasan --}}
                <input type="hidden" name="jenis_laporan" value="Ulasan">
                
                <div class="modal-body p-5"> {{-- ⚡ Perubahan padding menjadi p-5 agar visual terasa longgar dan rapi --}}
                    <p class="text-muted mb-4" style="font-size: 0.95rem;">Silakan tentukan rentang waktu data ulasan masuk yang ingin diekspor ke dalam dokumen cetak fisik.</p>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-2">Rentang Waktu (Paket Cetak):</label>
                        <select name="rentang_cetak" class="form-select form-select-lg" style="border-radius: 8px; font-size: 0.95rem;">
                            <option value="semua">✨ Semua Data Ulasan Masuk</option>
                            <option value="tiga_bulan">📅 3 Bulan Terakhir</option>
                            <option value="enam_bulan">🗓️ 6 Bulan Terakhir</option>
                        </select>
                    </div>

                    <div class="text-center my-4 position-relative">
                        <hr class="text-muted">
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small fw-bold">ATAU ATUR TANGGAL KUSTOM</span>
                    </div>

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
                        <i class="bi bi-printer-fill me-1"></i> Proses Cetak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection