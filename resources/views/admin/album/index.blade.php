@extends('layouts.admin')
@section('title', 'Manajemen Album')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">📁 Manajemen Album Galeri</h5>
        <p class="text-muted small">Kelola koleksi album untuk mengelompokkan foto.</p>
    </div>
    <button type="button" class="btn btn-success btn-sm px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAlbum" style="background-color: #1a5c2a; border-color: #1a5c2a;">
        <i class="bi bi-plus-lg me-1"></i> Buat Album Baru
    </button>
</div>

{{-- FILTER PENCARIAN BARU: Seragam dan Kompak ala Halaman Berita --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 10px;">
    <div class="card-body p-3">
        <form action="{{ route('admin.album.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari nama album..." value="{{ request('cari') }}" style="border-radius: 5px;">
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-success btn-sm px-3" style="background-color: #1a5c2a; border-color: #1a5c2a;">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                @if(request('cari'))
                    <a href="{{ route('admin.album.index') }}" class="btn btn-secondary btn-sm px-3" style="border-radius: 5px;">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0" style="border-radius: 10px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary" style="width: 50px;">No</th>
                        <th class="py-3 text-secondary">Nama Album</th>
                        <th class="py-3 text-secondary text-center">Jumlah Foto</th>
                        <th class="py-3 text-secondary">Tanggal Dibuat</th>
                        <th class="py-3 text-secondary text-center" style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($albums as $index => $a)
                    <tr>
                        <td class="px-4 fw-bold text-muted">{{ $albums->firstItem() + $index }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $a->nama_album }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-info text-dark px-3">
                                <i class="bi bi-images me-1"></i> {{ $a->galeris_count }} Foto
                            </span>
                        </td>
                        <td>
                            <div class="small text-muted"><i class="bi bi-calendar3 me-1"></i> {{ $a->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group gap-1">
                                <a href="{{ route('admin.album.show', $a->id) }}" class="btn btn-sm btn-outline-primary" style="padding: 2px 6px;" title="Buka Album">
                                    <i class="bi bi-eye"></i>
                                </a>
                                {{-- Tombol Edit --}}
                                <button type="button" class="btn btn-sm btn-outline-warning" style="padding: 2px 6px;" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEditAlbum{{ $a->id }}" title="Edit Album">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.album.destroy', $a->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus album ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 2px 6px;" title="Hapus Album">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEditAlbum{{ $a->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Nama Album</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.album.update', $a->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body py-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nama Album</label>
                                            <input type="text" name="nama_album" class="form-control" value="{{ $a->nama_album }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning px-4 fw-bold">Update Album</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data album.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahAlbum" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-folder-plus me-2"></i>Tambah Album Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.album.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Album</label>
                        <input type="text" name="nama_album" class="form-control" placeholder="Contoh: Kegiatan Mahasiswa 2026" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4" style="background-color: #1a5c2a; border-color: #1a5c2a;">Simpan Album</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $albums->links() }}
</div>

@endsection