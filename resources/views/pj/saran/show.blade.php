{{-- resources/views/pj/saran/show.blade.php --}}
@extends('layouts.pj')
@section('title','Detail Saran')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('pj.saran.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold" style="color:#1a3a5c;">💬 Detail Saran Masyarakat</h5>
</div>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-circle me-2"></i>{{ $saran->nama }}
                <span class="badge bg-info ms-2" style="font-size:.73rem;">Pengunjung</span>
            </div>
            <div class="card-body">
                @if($saran->kontak)
                <p class="text-muted mb-2" style="font-size:.85rem;"><i class="bi bi-telephone me-1"></i>{{ $saran->kontak }}</p>
                @endif
                <p class="text-muted mb-3" style="font-size:.82rem;"><i class="bi bi-calendar3 me-1"></i>{{ $saran->created_at->format('d F Y, H:i') }}</p>
                <div style="background:#f5f8fb;border-radius:10px;padding:16px;font-size:.92rem;line-height:1.8;color:#333;border-left:4px solid #2d6a9e;">
                    {{ $saran->pesan }}
                </div>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('pj.saran.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                    <a href="{{ route('pj.saran.create') }}" class="btn btn-primary btn-sm ms-auto"><i class="bi bi-send me-1"></i>Balas via Saran ke Admin</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection