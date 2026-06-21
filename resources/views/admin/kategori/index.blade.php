{{-- resources/views/admin/kategori/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Manajemen Kategori')
@section('content')

<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">🏷️ Kategori Khasiat</h5>
        <p class="text-muted small mb-0">Kelola kategori khasiat untuk klasifikasi tanaman obat.</p>
    </div>
    <button type="button" class="btn btn-success btn-sm px-3 shadow-sm w-100 w-sm-auto" data-bs-toggle="modal" data-bs-target="#modalTambah" style="background-color: #1a5c2a; border-color: #1a5c2a;">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
    </button>
</div>

{{-- Menampilkan Pesan Sukses Alami --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- FILTER PENCARIAN BARU: Seragam dan Kompak ala Halaman Berita, Album, & Galeri --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 10px;">
    <div class="card-body p-3">
        <form action="{{ route('admin.kategori.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-12 col-md-6">
                <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari nama kategori..." value="{{ request('cari') }}" style="border-radius: 5px;">
            </div>
            <div class="col-12 col-md-auto d-flex gap-2 w-100 w-md-auto">
                <button type="submit" class="btn btn-success btn-sm px-3 flex-fill flex-md-none" style="background-color: #1a5c2a; border-color: #1a5c2a;">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                @if(request('cari'))
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary btn-sm px-3 flex-fill flex-md-none text-center" style="border-radius: 5px;">Reset</a>
                @endif
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
                        <th class="px-4 py-3" style="width: 50px;">No</th>
                        <th>Nama Kategori</th>
                        {{-- PERBAIKAN: Menambahkan tajuk kolom jumlah tanaman baru --}}
                        <th class="text-center" style="width: 200px;">Jumlah Tanaman</th>
                        <th class="text-center" style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoris as $index => $k)
                    <tr>
                        {{-- Perbaikan Penomoran Agar Berlanjut Otomatis ke Angka 16 dst --}}
                        <td class="px-4 text-muted">{{ $kategoris->firstItem() + $index }}</td>
                        <td class="fw-bold">{{ $k->nama_kategori }}</td>
                        
                        {{-- PERBAIKAN: Menampilkan nilai statistik hitungan real-time dari relasi database --}}
                        <td class="text-center">
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle fw-bold px-3 py-1.5" style="border-radius: 30px; font-size: 0.8rem;">
                                <i class="bi bi-tree-fill me-1"></i> {{ $k->tanaman_obats_count ?? 0 }} Tanaman
                            </span>
                        </td>

                        <td class="text-center">
                            <div class="btn-group gap-1">
                                {{-- Tombol Detail - Ikon Mata Berwarna Biru --}}
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $k->id }}" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </button>
                                
                                {{-- Tombol Edit --}}
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $k->id }}" title="Edit Kategori">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.kategori.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Kategori">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Tampilan Mobile (Card List) --}}
<div class="d-md-none">
    @if($kategoris->isEmpty())
        <div class="card shadow-sm border-0 text-center p-4" style="border-radius: 10px;">
            <p class="text-muted mb-0">Tidak ada data kategori ditemukan.</p>
        </div>
    @else
        @foreach($kategoris as $index => $k)
        <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <span class="text-muted small">No. {{ $kategoris->firstItem() + $index }}</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle fw-bold px-2.5 py-1" style="border-radius: 30px; font-size: 0.75rem;">
                        <i class="bi bi-tree-fill me-1"></i> {{ $k->tanaman_obats_count ?? 0 }} Tanaman
                    </span>
                </div>
                <div class="mb-3">
                    <span class="text-muted small d-block">Nama Kategori</span>
                    <span class="fw-bold text-dark fs-6">{{ $k->nama_kategori }}</span>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    {{-- Tombol Detail --}}
                    <button type="button" class="btn btn-sm btn-outline-primary px-3" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $k->id }}">
                        <i class="bi bi-eye me-1"></i> Detail
                    </button>
                    {{-- Tombol Edit --}}
                    <button type="button" class="btn btn-sm btn-outline-warning px-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $k->id }}">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </button>
                    {{-- Tombol Hapus --}}
                    <form action="{{ route('admin.kategori.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger px-3">
                            <i class="bi bi-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

{{-- Navigasi Halaman / Pagination Bawah Sesuai Request Kamu (Nempel dan Bisa Klik Balik) --}}
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 mt-3 px-2 text-center text-sm-start">
    <div class="text-muted small">
        Menampilkan {{ $kategoris->firstItem() ?: 0 }} sampai {{ $kategoris->lastItem() ?: 0 }} dari {{ $kategoris->total() }} data.
    </div>
    <div>
        <nav>
            <ul class="pagination pagination-sm mb-0 justify-content-center">
                {{-- Tombol Angka Halaman Manual & Tahan Banting --}}
                <li class="page-item {{ $kategoris->onFirstPage() && request('show') !== 'all' ? 'disabled' : '' }}">
                    <a class="page-link text-success" href="{{ route('admin.kategori.index', array_merge(request()->query(), ['page' => 1])) }}">‹</a>
                </li>
                
                <li class="page-item {{ $kategoris->currentPage() == 1 && request('show') !== 'all' ? 'active' : '' }}">
                    <a class="page-link {{ $kategoris->currentPage() == 1 && request('show') !== 'all' ? 'bg-success border-success text-white' : 'text-success' }}" href="{{ route('admin.kategori.index', array_merge(request()->query(), ['page' => 1])) }}">1</a>
                </li>
                
                <li class="page-item {{ $kategoris->currentPage() == 2 && request('show') !== 'all' ? 'active' : '' }}">
                    <a class="page-link {{ $kategoris->currentPage() == 2 && request('show') !== 'all' ? 'bg-success border-success text-white' : 'text-success' }}" href="{{ route('admin.kategori.index', array_merge(request()->query(), ['page' => 2])) }}">2</a>
                </li>
                
                <li class="page-item {{ !$kategoris->hasMorePages() && request('show') !== 'all' ? 'disabled' : '' }}">
                    <a class="page-link text-success" href="{{ route('admin.kategori.index', array_merge(request()->query(), ['page' => 2])) }}">›</a>
                </li>

                {{-- Tombol ALL - Menggandeng Rapi di Sebelah Kanan Tombol Panah --}}
                <li class="page-item {{ request('show') === 'all' ? 'active' : '' }}">
                    @if(request('show') === 'all')
                        <span class="page-link bg-success border-success text-white fw-bold" style="cursor: default;">All</span>
                    @else
                        <a class="page-link text-success" href="{{ route('admin.kategori.index', array_merge(request()->query(), ['show' => 'all'])) }}"><b>All</b></a>
                    @endif
                </li>
            </ul>
        </nav>
    </div>
</div>

{{-- ==========================================
     KUMPULAN MODAL POP-UP (DI LUAR TABEL & CARD)
     ========================================== --}}

@foreach($kategoris as $k)
    <div class="modal fade" id="modalDetail{{ $k->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 10px;">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-eye me-2"></i> Detail Kategori</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-3 border-bottom pb-2">
                        <label class="text-muted small d-block mb-1">Nama Kategori</label>
                        <span class="fw-bold text-dark fs-5">{{ $k->nama_kategori }}</span>
                    </div>
                    {{-- PERBAIKAN: Menambahkan info total tanaman terikat di dalam modal detail khasiat --}}
                    <div class="mb-3 border-bottom pb-2">
                        <label class="text-muted small d-block mb-1">Total Tanaman</label>
                        <span class="fw-bold text-success"><i class="bi bi-tree-fill me-1"></i> {{ $k->tanaman_obats_count ?? 0 }} Tanaman Obat</span>
                    </div>

                    <div>
                        <label class="text-muted small d-block mb-1">Dibuat Pada</label>
                        <span class="fw-bold text-dark">{{ $k->created_at->format('d M Y H:i') }} WIB</span>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit{{ $k->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 10px;">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.kategori.update', $k->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" value="{{ $k->nama_kategori }}" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning btn-sm px-4 fw-bold">Update Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 10px;">
            <div class="modal-header bg-success text-white" style="background-color: #1a5c2a !important;">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i> Tambah Kategori Khasiat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Antidiabetes, Analgetik" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm px-4" style="background-color: #1a5c2a; border-color: #1a5c2a;">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection