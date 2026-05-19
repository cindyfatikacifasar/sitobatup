@extends('layouts.admin')
@section('title', 'Kelola Berita')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">📰 Berita & Informasi</h5>
        <p class="text-muted small">Kelola berita kegiatan untuk klasifikasi informasi tanaman obat.</p>
    </div>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-success btn-sm px-3 shadow-sm" style="background-color: #1a5c2a; border-color: #1a5c2a;">
        <i class="bi bi-plus-lg me-1"></i> Tambah Berita
    </a>
</div>

{{-- Filter Pencarian yang Serasi dengan Tema Kategori --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 10px;">
    <div class="card-body p-3">
        <form action="{{ route('admin.berita.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari judul berita..." value="{{ request('cari') }}" style="border-radius: 5px;">
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-success btn-sm px-3" style="background-color: #1a5c2a; border-color: #1a5c2a;">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                @if(request('cari'))
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary btn-sm px-3">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Card Tabel Utama Berita ala Halaman Kategori --}}
<div class="card shadow-sm border-0" style="border-radius: 10px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary" style="width: 60px;">No</th>
                        <th class="py-3 text-secondary">Nama Berita / Judul</th>
                        <th class="py-3 text-secondary" style="width: 120px;">Penulis</th>
                        <th class="py-3 text-secondary text-center" style="width: 120px;">Status</th>
                        <th class="py-3 text-secondary text-center" style="width: 100px;">Views</th>
                        <th class="py-3 text-secondary text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beritas as $index => $b)
                    <tr>
                        <td class="px-4 fw-bold text-muted">
                            {{ method_exists($beritas, 'firstItem') ? $beritas->firstItem() + $index : $index + 1 }}
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $b->judul }}</div>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($b->created_at)->format('d M Y') }}
                            </small>
                        </td>
                        <td class="text-secondary small">{{ $b->penulis ?? 'Admin' }}</td>
                        <td class="text-center">
                            @if(($b->status ?? 'Published') == 'Published')
                                <span class="badge bg-success-subtle text-success px-2 py-1" style="font-size: 0.75rem; border-radius: 4px;">Published</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning px-2 py-1" style="font-size: 0.75rem; border-radius: 4px;">Draft</span>
                            @endif
                        </td>
                        <td class="text-center text-muted small fw-bold">{{ $b->views ?? 0 }}</td>
                        <td class="text-center">
                            <div class="btn-group gap-1">
                                {{-- Tombol Lihat Publik --}}
                                <a href="{{ route('berita.detail', $b->slug ?? $b->id) }}" target="_blank" class="btn btn-sm btn-outline-primary" style="padding: 2px 6px;" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.berita.edit', $b->id) }}" class="btn btn-sm btn-outline-warning" style="padding: 2px 6px;" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.berita.destroy', $b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus berita ini?')">
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
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-newspaper fs-1 d-block mb-2" style="color: #1a5c2a; opacity: 0.5;"></i>
                            Belum ada data berita yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(method_exists($beritas, 'links'))
    <div class="mt-4 px-2">
        {{ $beritas->links() }}
    </div>
@endif

@endsection