@extends('layouts.admin')
@section('title', 'Detail Berita')
@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>
        <img src="{{ Storage::url($berita->foto) }}" class="img-fluid rounded mb-4" style="max-height: 400px; width: 100%; object-fit: cover;">
        <h2 class="fw-bold">{{ $berita->judul }}</h2>
        <div class="mb-3">
            @if($berita->is_popular) <span class="badge bg-warning text-dark">Populer</span> @endif
        </div>
        <p class="text-muted small">Ditulis oleh: {{ $berita->penulis }} | {{ $berita->created_at->format('d M Y') }}</p>
        <hr>
        <div style="white-space: pre-wrap;">{{ $berita->isi }}</div>
    </div>
</div>
@endsection