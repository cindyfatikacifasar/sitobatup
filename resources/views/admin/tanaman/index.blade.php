{{-- resources/views/admin/tanaman/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Kelola Tanaman Obat')
@section('content')

<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">🌿 Tanaman Obat</h5>
        <p class="text-muted small mb-0">Kelola seluruh data koleksi tanaman obat keluarga (TOGA) beserta klasifikasinya.</p>
    </div>
    <a href="{{ route('admin.tanaman.create') }}" class="btn btn-success btn-sm px-3 shadow-sm w-100 w-sm-auto text-center" style="background-color: #1a5c2a; border-color: #1a5c2a;">
        <i class="bi bi-plus-lg me-1"></i> Tambah Tanaman
    </a>
</div>

{{-- FILTER & PENCARIAN BARU: Seragam dan Kompak ala Halaman Berita, Album, Galeri, Kategori, & Saran --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 10px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.tanaman.index') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama tanaman (Indonesia / Latin)..." value="{{ request('search') }}" style="border-radius: 5px;">
            </div>
            <div class="col-12 col-md-4">
                <select name="kategori" class="form-select form-select-sm" style="border-radius: 5px;">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori ?? $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-auto d-flex gap-2 w-100 w-md-auto">
                <button type="submit" class="btn btn-success btn-sm px-3 flex-fill flex-md-none" style="background-color: #1a5c2a; border-color: #1a5c2a;">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                @if(request('search') || request('kategori'))
                    <a href="{{ route('admin.tanaman.index') }}" class="btn btn-secondary btn-sm px-3 flex-fill flex-md-none text-center" style="border-radius: 5px;">Reset</a>
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
                        <th class="px-4 py-3 text-secondary" width="60">#</th>
                        <th class="py-3 text-secondary">Nama Tanaman</th>
                        <th class="py-3 text-secondary" style="width: 200px;">Kategori</th>
                        <th class="py-3 text-secondary" style="width: 100px;">Views</th>
                        <th class="py-3 text-secondary text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tanaman as $i => $t)
                    <tr>
                        <td class="px-4 fw-bold text-muted">{{ $tanaman->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($t->foto)
                                    <img src="{{ Storage::url($t->foto) }}" style="width:36px;height:36px;object-fit:cover;border-radius:6px;" class="shadow-sm">
                                @else
                                    <div style="width:36px;height:36px;background:#e8f5e9;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;" class="shadow-sm">🌿</div>
                                @endif
                                <div>
                                    <div style="font-weight:600;font-size:.88rem;" class="text-dark">{{ $t->nama }}</div>
                                    <div style="font-size:.75rem;color:#888;font-style:italic;">{{ $t->nama_ilmiah }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @forelse($t->kategoris as $kat)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2 py-1 fw-bold" style="font-size:.72rem; border-radius: 4px;">
                                        {{ $kat->nama_kategori ?? $kat->nama }}
                                    </span>
                                @empty
                                    <span class="badge bg-light text-muted border border-light-subtle px-2 py-1 fw-normal" style="font-size:.72rem; border-radius: 4px;">-</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="text-muted small fw-bold">{{ number_format($t->views) }}</td>
                        <td class="text-center">
                            <div class="btn-group gap-1 flex-wrap justify-content-center">
                                <a href="{{ route('admin.tanaman.show', $t->id) }}" class="btn btn-sm btn-outline-primary" style="padding: 2px 6px;" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.tanaman.edit',$t) }}" class="btn btn-sm btn-outline-warning" style="padding: 2px 6px;" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('admin.tanaman.qr-download',$t->id) }}" class="btn btn-sm btn-outline-success" style="padding: 2px 6px;" title="Download QR">
                                    <i class="bi bi-qr-code"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.tanaman.destroy',$t) }}" class="d-inline" onsubmit="return confirm('Hapus tanaman ini?')">
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
                            <i class="bi bi-tree-fill fs-1 d-block mb-2" style="color: #1a5c2a; opacity: 0.5;"></i>
                            Belum ada data tanaman obat yang ditemukan.
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
    @if($tanaman->isEmpty())
        <div class="card shadow-sm border-0 text-center p-4" style="border-radius: 10px;">
            <p class="text-muted mb-0">Belum ada data tanaman obat yang ditemukan.</p>
        </div>
    @else
        @foreach($tanaman as $i => $t)
        <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <span class="text-muted small">No. {{ $tanaman->firstItem() + $i }}</span>
                    <span class="badge bg-light text-muted border border-light-subtle px-2 py-0.5" style="font-size: 0.68rem; border-radius: 4px;">
                        <i class="bi bi-eye-fill me-1"></i> {{ number_format($t->views) }} views
                    </span>
                </div>
                
                <div class="d-flex align-items-center gap-2.5 mb-3">
                    @if($t->foto)
                        <img src="{{ Storage::url($t->foto) }}" style="width:46px;height:46px;object-fit:cover;border-radius:8px;" class="shadow-sm">
                    @else
                        <div style="width:46px;height:46px;background:#e8f5e9;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;" class="shadow-sm">🌿</div>
                    @endif
                    <div>
                        <div class="fw-bold text-dark fs-6">{{ $t->nama }}</div>
                        <div class="text-muted small italic">{{ $t->nama_ilmiah }}</div>
                    </div>
                </div>

                <div class="mb-3">
                    <span class="text-muted small d-block mb-1">Kategori Khasiat</span>
                    <div class="d-flex flex-wrap gap-1">
                        @forelse($t->kategoris as $kat)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2 py-1 fw-bold" style="font-size:.68rem; border-radius: 4px;">
                                {{ $kat->nama_kategori ?? $kat->nama }}
                            </span>
                        @empty
                            <span class="text-muted small"><em>- Tidak ada kategori -</em></span>
                        @endforelse
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-1 flex-wrap">
                    <a href="{{ route('admin.tanaman.show', $t->id) }}" class="btn btn-sm btn-outline-primary px-2.5" title="Detail">
                        <i class="bi bi-eye me-1"></i> Detail
                    </a>
                    <a href="{{ route('admin.tanaman.edit',$t) }}" class="btn btn-sm btn-outline-warning px-2.5" title="Edit">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.tanaman.qr-download',$t->id) }}" class="btn btn-sm btn-outline-success px-2.5" title="QR">
                        <i class="bi bi-qr-code me-1"></i> QR
                    </a>
                    <form method="POST" action="{{ route('admin.tanaman.destroy',$t) }}" class="d-inline" onsubmit="return confirm('Hapus tanaman ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger px-2.5" title="Hapus">
                            <i class="bi bi-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

@if($tanaman->hasPages())
    <div class="mt-3 px-2">
        {{ $tanaman->links() }}
    </div>
@endif

@endsection