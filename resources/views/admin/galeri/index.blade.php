@extends('layouts.admin')
@section('title', 'Manajemen Foto Galeri')
@section('content')

<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">📸 Manajemen Foto Galeri</h5>
        <p class="text-muted small mb-0">Kelola semua foto koleksi tanaman dan kegiatan.</p>
    </div>
    <a href="{{ route('admin.galeri.create') }}" class="btn btn-success btn-sm px-3 shadow-sm w-100 w-sm-auto text-center" style="background-color: #1a5c2a; border-color: #1a5c2a;">
        <i class="bi bi-plus-lg me-1"></i> Tambah Foto Baru
    </a>
</div>

{{-- ALERT SUKSES --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center justify-content-between p-3 mb-4" role="alert" style="background-color: #e8f5e9; color: #1a5c2a; border-radius: 10px;">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>
                <strong class="d-block">Berhasil!</strong>
                <span class="small">{{ session('success') }}</span>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="box-shadow: none;"></button>
    </div>
@endif

{{-- FILTER PENCARIAN BARU: Seragam dan Kompak ala Halaman Berita & Album --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 10px;">
    <div class="card-body p-3">
        <form action="{{ route('admin.galeri.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-12 col-md-6">
                <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari judul foto atau keterangan..." value="{{ request('cari') }}" style="border-radius: 5px;">
            </div>
            <div class="col-12 col-md-auto d-flex gap-2 w-100 w-md-auto">
                <button type="submit" class="btn btn-success btn-sm px-3 flex-fill flex-md-none" style="background-color: #1a5c2a; border-color: #1a5c2a;">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                @if(request('cari'))
                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary btn-sm px-3 flex-fill flex-md-none text-center" style="border-radius: 5px;">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Tampilan Desktop (Tabel) --}}
<div class="d-none d-md-block">
    <div class="card shadow-sm border-0" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="table-layout: fixed; width: 100%;">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary" style="width: 70px;">No</th>
                            <th class="py-3 text-secondary" style="width: 100px;">Preview</th>
                            <th class="py-3 text-secondary" style="width: 40%;">Judul & Keterangan</th>
                            <th class="py-3 text-secondary" style="width: 35%;">Album</th>
                            <th class="py-3 text-secondary text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($galeris as $index => $g)
                        <tr>
                            <td class="px-4 fw-bold text-muted">{{ $galeris->firstItem() + $index }}</td>
                            <td>
                                <div class="rounded overflow-hidden shadow-sm" style="width: 70px; height: 50px; background-color: #f8f9fa;">
                                    @if(Str::endsWith($g->foto, ['.mp4', '.mov', '.avi']))
                                        <div class="bg-dark d-flex align-items-center justify-content-center h-100">
                                            <i class="bi bi-play-circle text-white"></i>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/' . $g->foto) }}" class="w-100 h-100 object-fit-cover" alt="Preview">
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark text-truncate" title="{{ $g->judul }}">
                                    {{ $g->judul }}
                                </div>
                                <small class="text-muted text-truncate d-block" title="{{ $g->keterangan ?? 'Tidak ada keterangan' }}">
                                    {{ $g->keterangan ?? 'Tidak ada keterangan' }}
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-light text-success border border-success px-2 py-1 d-inline-block text-truncate" style="max-width: 100%;" title="{{ $g->album->nama_album ?? 'Tanpa Album' }}">
                                    <i class="bi bi-folder2-open me-1"></i> {{ $g->album->nama_album ?? 'Tanpa Album' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('admin.galeri.edit', $g->id) }}" class="btn btn-sm btn-outline-warning" style="padding: 2px 6px;" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus foto ini dari galeri?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 2px 6px;" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-images fs-1 d-block mb-2" style="color: #1a5c2a; opacity: 0.5;"></i>
                                Belum ada foto galeri yang diunggah.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Tampilan Mobile (Card List) --}}
<div class="d-md-none">
    @if($galeris->isEmpty())
        <div class="card shadow-sm border-0 text-center p-4" style="border-radius: 10px;">
            <p class="text-muted mb-0">Belum ada foto galeri yang diunggah.</p>
        </div>
    @else
        @foreach($galeris as $index => $g)
        <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <span class="text-muted small">No. {{ $galeris->firstItem() + $index }}</span>
                    <span class="badge bg-light text-success border border-success px-2 py-0.5" style="font-size: 0.68rem; border-radius: 4px;">
                        <i class="bi bi-folder2-open me-1"></i> {{ $g->album->nama_album ?? 'Tanpa Album' }}
                    </span>
                </div>
                
                <div class="d-flex align-items-start gap-2.5 mb-3">
                    <div class="rounded overflow-hidden shadow-sm flex-shrink-0" style="width: 80px; height: 60px; background-color: #f8f9fa;">
                        @if(Str::endsWith($g->foto, ['.mp4', '.mov', '.avi']))
                            <div class="bg-dark d-flex align-items-center justify-content-center h-100">
                                <i class="bi bi-play-circle text-white"></i>
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $g->foto) }}" class="w-100 h-100 object-fit-cover" alt="Preview">
                        @endif
                    </div>
                    <div style="overflow: hidden;">
                        <div class="fw-bold text-dark text-truncate fs-6" title="{{ $g->judul }}">
                            {{ $g->judul }}
                        </div>
                        <small class="text-muted text-truncate d-block small" title="{{ $g->keterangan ?? 'Tidak ada keterangan' }}">
                            {{ $g->keterangan ?? 'Tidak ada keterangan' }}
                        </small>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.galeri.edit', $g->id) }}" class="btn btn-sm btn-outline-warning px-3" title="Edit">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus foto ini dari galeri?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger px-3" title="Hapus">
                            <i class="bi bi-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

@if($galeris->hasPages())
    <div class="mt-3 px-2">
        {{ $galeris->links() }}
    </div>
@endif

@endsection