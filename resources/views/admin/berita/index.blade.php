{{-- resources/views/admin/berita/index.blade.php --}}
@extends('layouts.admin')
@section('title','Kelola Berita')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">📰 Berita & Informasi</h5>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-hijau btn-sm"><i class="bi bi-plus me-1"></i>Tulis Berita</a>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari judul berita..." value="{{ request('search') }}"></div>

        <div class="col-md-4 d-flex gap-1">
            <button type="submit" class="btn btn-hijau btn-sm flex-fill"><i class="bi bi-search me-1"></i>Cari</button>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
        </div>
    </form>
</div></div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Judul</th><th class="d-none d-lg-table-cell">Penulis</th><th class="d-none d-md-table-cell">Status</th><th class="d-none d-lg-table-cell">Views</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($beritas as $i => $b)
                <tr>
                    <td>{{ $beritas->firstItem()+$i }}</td>
                    <td>
                        <div style="font-size:.87rem;font-weight:600;">{{ Str::limit($b->judul,55) }}</div>
                        <div class="text-muted" style="font-size:.75rem;">{{ $b->created_at->format('d M Y') }}</div>
                    </td>
                    <td class="d-none d-lg-table-cell" style="font-size:.83rem;">{{ $b->penulis }}</td>
                    <td class="d-none d-md-table-cell">
                        <span class="badge {{ $b->is_published ? 'bg-success' : 'bg-secondary' }}" style="font-size:.73rem;">{{ $b->is_published ? 'Published' : 'Draft' }}</span>
                    </td>
                    <td class="d-none d-lg-table-cell" style="font-size:.83rem;">{{ number_format($b->views) }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.berita.show',$b) }}" class="btn btn-sm btn-outline-info" title="Lihat"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.berita.edit',$b) }}" class="btn btn-sm btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.berita.destroy',$b) }}" onsubmit="return confirm('Hapus berita ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada berita.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($beritas->hasPages())<div class="card-footer">{{ $beritas->links() }}</div>@endif
</div>
@endsection