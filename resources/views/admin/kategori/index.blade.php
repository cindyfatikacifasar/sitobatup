{{-- resources/views/admin/kategori/index.blade.php --}}
@extends('layouts.admin')
@section('title','Kelola Kategori')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">🏷️ Kategori Tanaman</h5>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-hijau btn-sm"><i class="bi bi-plus me-1"></i>Tambah Kategori</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Nama Kategori</th><th>Jumlah Tanaman</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($kategoris as $i => $k)
                <tr>
                    <td>{{ $kategoris->firstItem()+$i }}</td>
                    <td><strong>{{ $k->nama_kategori }}</strong><br><small class="text-muted">{{ $k->slug }}</small></td>
                    <td><span class="badge bg-success">{{ $k->tanaman_obats_count }} tanaman</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.kategori.edit',$k) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.kategori.destroy',$k) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kategoris->hasPages())<div class="card-footer">{{ $kategoris->links() }}</div>@endif
</div>
@endsection