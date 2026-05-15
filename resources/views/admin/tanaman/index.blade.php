{{-- resources/views/admin/tanaman/index.blade.php --}}
@extends('layouts.admin')
@section('title','Kelola Tanaman Obat')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">🌿 Tanaman Obat</h5>
    <a href="{{ route('admin.tanaman.create') }}" class="btn btn-hijau btn-sm"><i class="bi bi-plus me-1"></i>Tambah Tanaman</a>
</div>
<!-- Filter -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama..." value="{{ request('search') }}"></div>
            <div class="col-md-3">
                <select name="kategori" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $k)<option value="{{ $k->id }}" {{ request('kategori')==$k->id?'selected':'' }}>{{ $k->nama }}</option>@endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex gap-1">
                <button type="submit" class="btn btn-hijau btn-sm flex-fill"><i class="bi bi-search me-1"></i>Cari</button>
                <a href="{{ route('admin.tanaman.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr>
                    <th width="40">#</th>
                    <th>Nama Tanaman</th>
                    <th class="d-none d-md-table-cell">Kategori</th>
                    <th class="d-none d-lg-table-cell">Bagian</th>
                    <th class="d-none d-lg-table-cell">Views</th>
                    <th>Aksi</th>
                </tr></thead>
                <tbody>
                    @forelse($tanaman as $i => $t)
                    <tr>
                        <td>{{ $tanaman->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($t->foto)
                                <img src="{{ Storage::url($t->foto) }}" style="width:36px;height:36px;object-fit:cover;border-radius:6px;">
                                @else
                                <div style="width:36px;height:36px;background:#e8f5e9;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;">🌿</div>
                                @endif
                                <div>
                                    <div style="font-weight:600;font-size:.88rem;">{{ $t->nama }}</div>
                                    <div style="font-size:.75rem;color:#888;font-style:italic;">{{ $t->nama_ilmiah }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-md-table-cell"><span class="badge" style="background:#e8f5e9;color:#1a5c2a;font-size:.74rem;">{{ $t->kategori->nama ?? '-' }}</span></td>
                        <td class="d-none d-lg-table-cell" style="font-size:.84rem;">{{ ucfirst($t->bagian_digunakan ?? '-') }}</td>
                        <td class="d-none d-md-table-cell">

                        </td>
                        <td class="d-none d-lg-table-cell" style="font-size:.84rem;">{{ number_format($t->views) }}</td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('admin.tanaman.show', $t->id) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>                                <a href="{{ route('admin.tanaman.edit',$t) }}" class="btn btn-sm btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                <a href="{{ route('admin.tanaman.qr-download',$t->id) }}" class="btn btn-sm btn-outline-success" title="Download QR"><i class="bi bi-qr-code"></i></a>
                                <form method="POST" action="{{ route('admin.tanaman.destroy',$t) }}" onsubmit="return confirm('Hapus tanaman ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data tanaman obat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tanaman->hasPages())
    <div class="card-footer">{{ $tanaman->links() }}</div>
    @endif
</div>
@endsection