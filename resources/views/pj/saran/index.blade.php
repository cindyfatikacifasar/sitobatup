{{-- resources/views/pj/saran/index.blade.php --}}
@extends('layouts.pj')
@section('title','Kelola Saran')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold" style="color:#1a3a5c;">💬 Kelola Saran @if($belumDibaca > 0)<span class="badge bg-danger ms-2">{{ $belumDibaca }} baru</span>@endif</h5>
    <a href="{{ route('pj.saran.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-send me-1"></i>Kirim Saran ke Admin
    </a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="belum" {{ request('status')=='belum'?'selected':'' }}>Belum Dibaca</option>
                    <option value="dibaca" {{ request('status')=='dibaca'?'selected':'' }}>Sudah Dibaca</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm flex-fill">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
                <a href="{{ route('pj.saran.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th class="d-none d-md-table-cell">Pesan</th>
                    <th>Status</th>
                    <th class="d-none d-lg-table-cell">Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sarans as $i => $s)
                <tr class="{{ !$s->is_read?'table-warning':'' }}">
                    <td>{{ $sarans->firstItem()+$i }}</td>
                    <td>
                        <div style="font-size:.86rem;font-weight:{{ !$s->is_read?'700':'400' }};">{{ $s->nama }}</div>
                        @if($s->kontak)
                            <div class="text-muted" style="font-size:.74rem;">{{ $s->kontak }}</div>
                        @endif
                    </td>
                    <td class="d-none d-md-table-cell" style="font-size:.82rem;">
                        {{ Str::limit($s->pesan, 60) }}
                    </td>
                    <td>
                        <span class="badge {{ !$s->is_read?'bg-danger':'bg-secondary' }}" style="font-size:.72rem;">
                            {{ !$s->is_read?'Baru':'Dibaca' }}
                        </span>
                    </td>
                    <td class="d-none d-lg-table-cell" style="font-size:.8rem;">
                        {{ $s->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('pj.saran.show', $s->id) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('pj.saran.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus saran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada saran masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sarans->hasPages())
        <div class="card-footer bg-white border-top-0">
            {{ $sarans->links() }}
        </div>
    @endif
</div>
@endsection