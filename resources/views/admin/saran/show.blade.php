{{-- resources/views/admin/saran/show.blade.php --}}
@extends('layouts.admin')
@section('title','Detail Saran')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.saran.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">💬 Detail Saran</h5>
</div>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-person-circle me-2"></i>{{ $saran->nama }}</span>
                <span class="badge {{ $saran->pengirim=='pengunjung'?'bg-info':'bg-warning text-dark' }}">
                    {{ $saran->pengirim=='pengunjung'?'Pengunjung':'Penanggungjawab' }}
                </span>
            </div>
            <div class="card-body">
                @if($saran->kontak)
                <p class="text-muted mb-2" style="font-size:.85rem;"><i class="bi bi-telephone me-1"></i>{{ $saran->kontak }}</p>
                @endif
                <p class="text-muted mb-3" style="font-size:.83rem;"><i class="bi bi-calendar3 me-1"></i>{{ $saran->created_at->format('d F Y, H:i') }}</p>
                <div style="background:#f8faf8;border-radius:10px;padding:16px;font-size:.92rem;line-height:1.8;color:#333;border-left:4px solid #2d8a4e;">
                    {{ $saran->pesan }}
                </div>
                <div class="d-flex gap-2 mt-3">
                    @if(!$saran->is_read)
                    <form method="POST" action="{{ route('admin.saran.baca',$saran->id) }}">
                        @csrf
                        <button class="btn btn-success btn-sm"><i class="bi bi-check2 me-1"></i>Tandai Dibaca</button>
                    </form>
                    @else
                    <span class="badge bg-secondary py-2 px-3">✓ Sudah Dibaca</span>
                    @endif
                    <form method="POST" action="{{ route('admin.saran.destroy',$saran->id) }}" onsubmit="return confirm('Hapus saran ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Hapus</button>
                    </form>
                    <a href="{{ route('admin.saran.index') }}" class="btn btn-outline-secondary btn-sm ms-auto"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection