@extends('layouts.admin')
@section('title', 'Tambah Album Baru')
@section('content')

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.album.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-bold" style="color: #43a047;">📁 Buat Album Baru</h5>
</div>

<div class="card shadow-sm border-0" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('admin.album.store') }}" method="POST">
            @csrf

            {{-- Pesan Error Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Album *</label>
                <input type="text" name="nama_album" class="form-control" 
                       placeholder="Contoh: Kegiatan Sosialisasi 2026" value="{{ old('nama_album') }}" required>
                <small class="text-muted">Nama ini akan otomatis menjadi link (slug).</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi Album</label>
                <textarea name="deskripsi" class="form-control" rows="3" 
                          placeholder="Jelaskan sedikit tentang isi album ini...">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="text-end border-top pt-3">
                <a href="{{ route('admin.album.index') }}" class="btn btn-light px-4">Batal</a>
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check-lg me-1"></i> Simpan Album
                </button>
            </div>
        </form>
    </div>
</div>

@endsection