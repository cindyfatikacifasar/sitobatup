{{-- resources/views/admin/user/index.blade.php --}}
@extends('layouts.admin')
@section('title','Kelola Penanggungjawab')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold" style="color: #43a047;">👥 Akun Penanggungjawab</h5>
    <a href="{{ route('admin.user.create') }}" class="btn btn-hijau btn-sm"><i class="bi bi-plus me-1"></i>Tambah Akun</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Nama</th><th class="d-none d-md-table-cell">Email</th><th class="d-none d-lg-table-cell">No. HP</th><th class="d-none d-md-table-cell">Dibuat</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($users as $i => $u)
                <tr>
                    <td>{{ $users->firstItem()+$i }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($u->foto)
                                <img src="{{ Storage::url($u->foto) }}" class="rounded-circle" width="34" height="34" style="object-fit:cover;">
                            @else
                                <div style="width:34px;height:34px;background:#e8f5e9;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.9rem;">👤</div>
                            @endif
                            <div>
                                <div style="font-weight:600;font-size:.87rem;">{{ $u->name }}</div>
                                <span class="badge bg-info" style="font-size:.68rem;">Penanggungjawab</span>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-md-table-cell" style="font-size:.84rem;">{{ $u->email }}</td>
                    <td class="d-none d-lg-table-cell" style="font-size:.84rem;">{{ $u->phone ?? '-' }}</td>
                    <td class="d-none d-md-table-cell" style="font-size:.8rem;">{{ $u->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.user.edit',$u) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.user.destroy',$u) }}" onsubmit="return confirm('Hapus akun ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada akun penanggungjawab.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())<div class="card-footer">{{ $users->links() }}</div>@endif
</div>
@endsection