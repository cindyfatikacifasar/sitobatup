@extends('layouts.admin')
@section('title', 'Edit Album')
@section('content')

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.album.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">✏️ Edit Album: {{ $album->nama_album }}</h5>
</div>

<div class="card shadow-sm border-0" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('admin.album.update', $album->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- PENTING: Harus pakai PUT untuk update --}}

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
                       value="{{ old('nama_album', $album->nama_album) }}" required>
                <small class="text-muted">Jika nama diubah, slug URL juga akan terupdate otomatis.</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi Album</label>
                <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $album->deskripsi) }}</textarea>
            </div>

            <div class="text-end border-top pt-3">
                <a href="{{ route('admin.album.index') }}" class="btn btn-light px-4">Batal</a>
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-save me-1"></i> Perbarui Album
                </button>
            </div>
        </form>
    </div>
</div>

@endsection