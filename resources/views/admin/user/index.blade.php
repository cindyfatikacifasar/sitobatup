{{-- resources/views/admin/user/index.blade.php --}}
@extends('layouts.admin')
@section('title','Kelola Penanggungjawab')
@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-3">
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">👥 Akun Penanggungjawab</h5>
    <a href="{{ route('admin.user.create') }}" class="btn btn-hijau btn-sm"><i class="bi bi-plus me-1"></i>Tambah Akun</a>
</div>

{{-- Tampilan Desktop (Tabel) --}}
<div class="d-none d-md-block">
    <div class="card shadow-sm border-0" style="border-radius: 10px;">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary" style="width: 60px;">#</th>
                        <th class="py-3 text-secondary">Nama</th>
                        <th class="py-3 text-secondary">Email</th>
                        <th class="py-3 text-secondary">No. HP</th>
                        <th class="py-3 text-secondary">Dibuat</th>
                        <th class="py-3 text-secondary text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $u)
                    <tr>
                        <td class="px-4 fw-bold text-muted">{{ $users->firstItem()+$i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($u->foto)
                                    <img src="{{ Storage::url($u->foto) }}" class="rounded-circle" width="34" height="34" style="object-fit:cover;">
                                @else
                                    <div style="width:34px;height:34px;background:#e8f5e9;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.9rem;">👤</div>
                                @endif
                                <div>
                                    <div style="font-weight:600;font-size:.87rem;" class="text-dark">{{ $u->name }}</div>
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info-subtle" style="font-size:.68rem; border-radius: 4px;">Penanggungjawab</span>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:.84rem;">{{ $u->email }}</td>
                        <td style="font-size:.84rem;">{{ $u->phone ?? '-' }}</td>
                        <td style="font-size:.8rem; color:#6c757d;">{{ $u->created_at->format('d M Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group gap-1">
                                <a href="{{ route('admin.user.edit',$u) }}" class="btn btn-sm btn-outline-warning" style="padding: 2px 6px;" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.user.destroy',$u) }}" class="d-inline" onsubmit="return confirm('Hapus akun ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" style="padding: 2px 6px;" title="Hapus"><i class="bi bi-trash"></i></button>
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
    </div>
</div>

{{-- Tampilan Mobile (Card List) --}}
<div class="d-md-none">
    @forelse($users as $i => $u)
    <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                <span class="text-muted small">No. {{ $users->firstItem()+$i }}</span>
                <span class="badge bg-info bg-opacity-10 text-info border border-info-subtle fw-bold px-2 py-0.5" style="font-size: 0.68rem; border-radius: 30px;">Penanggungjawab</span>
            </div>
            
            <div class="d-flex align-items-center gap-2.5 mb-3">
                @if($u->foto)
                    <img src="{{ Storage::url($u->foto) }}" class="rounded-circle" width="40" height="40" style="object-fit:cover;">
                @else
                    <div style="width:40px;height:40px;background:#e8f5e9;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.1rem;">👤</div>
                @endif
                <div>
                    <div class="fw-bold text-dark fs-6">{{ $u->name }}</div>
                    <div class="text-muted small">{{ $u->email }}</div>
                </div>
            </div>
            
            <div class="row g-2 mb-3 bg-light p-2 rounded" style="font-size: 0.8rem; margin-left: 0; margin-right: 0;">
                <div class="col-6">
                    <span class="text-muted d-block small">No. HP</span>
                    <span class="fw-bold text-dark">{{ $u->phone ?? '-' }}</span>
                </div>
                <div class="col-6">
                    <span class="text-muted d-block small">Dibuat</span>
                    <span class="fw-bold text-dark">{{ $u->created_at->format('d M Y') }}</span>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.user.edit',$u) }}" class="btn btn-sm btn-outline-warning px-3"><i class="bi bi-pencil me-1"></i> Edit</a>
                <form method="POST" action="{{ route('admin.user.destroy',$u) }}" class="d-inline" onsubmit="return confirm('Hapus akun ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger px-3"><i class="bi bi-trash me-1"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="card shadow-sm border-0 text-center p-4" style="border-radius: 10px;">
        <p class="text-muted mb-0">Belum ada akun penanggungjawab.</p>
    </div>
    @endforelse
</div>

@if($users->hasPages())
    <div class="mt-3 px-2">
        {{ $users->links() }}
    </div>
@endif
@endsection