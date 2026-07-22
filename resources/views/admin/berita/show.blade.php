@extends('layouts.admin')
@section('title', 'Detail Berita')
@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> 
    </a>
    <h5 class="mb-0 fw-bold" style="color: #43a047;">📰 Detail Review Berita</h5>
</div>

<div class="card shadow-sm border-0" style="border-radius: 10px;">
    <div class="card-body p-4">
        <h3 class="fw-bold text-dark mb-2">{{ $berita->judul }}</h3>
        <div class="d-flex gap-3 text-muted small mb-4 border-bottom pb-3">
            <div><i class="bi bi-person-fill me-1"></i> Penulis: <strong>{{ $berita->penulis ?? 'Admin' }}</strong></div>
            <div><i class="bi bi-calendar3 me-1"></i> Tanggal: {{ $berita->created_at->format('d M Y H:i') }} WIB</div>
            <div><i class="bi bi-eye-fill me-1"></i> Total Views: {{ number_format($berita->views) }} kali</div>
        </div>
        
        @if($berita->foto)
            <div class="mb-4 text-center bg-light p-2 rounded">
                <img src="{{ Storage::url($berita->foto) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
            </div>
        @endif

        <div class="text-dark" style="line-height: 1.8; text-align: justify;">
            {!! $berita->isi !!}
        </div>
    </div>
</div>
@endsection