{{-- resources/views/admin/tanaman/show.blade.php --}}
@extends('layouts.admin')
@section('title','Detail Tanaman')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.tanaman.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">🌿 {{ $tanaman->nama }}</h5>
</div>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div style="height:220px;background:#e8f5e9;border-radius:12px 12px 0 0;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                @if($tanaman->foto)<img src="{{ Storage::url($tanaman->foto) }}" style="width:100%;height:220px;object-fit:cover;">
                @else<span style="font-size:5rem;">🌿</span>@endif
            </div>
            <div class="card-body">
                @if($tanaman->qr_code)
                <div class="text-center p-2" style="background:#f8faf8;border-radius:8px;margin-bottom:12px;">
                    <img src="{{ Storage::url($tanaman->qr_code) }}" style="width:110px;height:110px;">
                    <div style="font-size:.74rem;color:#888;margin-top:4px;">QR Code Tanaman</div>
                </div>
                @endif
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.tanaman.edit',$tanaman) }}" class="btn btn-warning btn-sm flex-fill"><i class="bi bi-pencil me-1"></i>Edit</a>
                    <a href="{{ route('admin.tanaman.qr-download',$tanaman->id) }}" class="btn btn-success btn-sm flex-fill"><i class="bi bi-download me-1"></i>Download QR</a>
                    <a href="{{ route('admin.tanaman.generate-qr',$tanaman->id) }}" class="btn btn-outline-secondary btn-sm w-100"><i class="bi bi-arrow-repeat me-1"></i>Generate Ulang QR</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="fw-bold" style="color:#1a5c2a;">{{ $tanaman->nama }}</h5>
                <p class="text-muted fst-italic mb-3">{{ $tanaman->nama_ilmiah }}</p>
                <div class="row g-2" style="font-size:.85rem;">
                    <div class="col-6"><strong>Kategori:</strong> {{ $tanaman->kategori->nama ?? '-' }}</div>
                    <div class="col-6"><strong>Bagian:</strong> {{ ucfirst($tanaman->bagian_digunakan??'-') }}</div>
                    <div class="col-6"><strong>Asal Usul:</strong> {{ $tanaman->asal_usul??'-' }}</div>
                    <div class="col-6"><strong>Lokasi:</strong> {{ $tanaman->lokasi_etalase??'-' }}</div>

                    <div class="col-6"><strong>Views:</strong> {{ number_format($tanaman->views) }}</div>
                </div>
            </div>
        </div>
        <div class="card mb-2"><div class="card-header fw-600">Deskripsi</div><div class="card-body" style="font-size:.88rem;line-height:1.8;">{{ $tanaman->deskripsi }}</div></div>
        <div class="card mb-2"><div class="card-header fw-600">Khasiat</div><div class="card-body" style="font-size:.88rem;line-height:1.8;">{{ $tanaman->khasiat }}</div></div>
        @if($tanaman->cara_pengolahan)
        <div class="card"><div class="card-header fw-600">Cara Pengolahan</div><div class="card-body" style="font-size:.88rem;line-height:1.8;">{{ $tanaman->cara_pengolahan }}</div></div>
        @endif
    </div>
</div>
@endsection