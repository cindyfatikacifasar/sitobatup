@extends('layouts.admin')
@section('title', 'Edit Foto Galeri')
@section('content')

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.galeri.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">✏️ Edit Foto Galeri</h5>
</div>

<div class="card shadow-sm border-0" style="max-width: 800px;">
    <div class="card-body">
        <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Pindah ke Album *</label>
                    <select name="album_id" class="form-select @error('album_id') is-invalid @enderror" required>
                        @foreach($albums as $album)
                            <option value="{{ $album->id }}" {{ old('album_id', $galeri->album_id) == $album->id ? 'selected' : '' }}>
                                {{ $album->nama_album }}
                            </option>
                        @endforeach
                    </select>
                    @error('album_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Judul Foto *</label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" 
                           value="{{ old('judul', $galeri->judul) }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 p-3 bg-light rounded text-center">
                <label class="form-label d-block fw-bold text-start">Preview File Saat Ini:</label>
                @if(Str::endsWith($galeri->foto, ['.mp4', '.mov', '.avi']))
                    <video src="{{ Storage::url($galeri->foto) }}" class="rounded shadow-sm" style="max-height: 150px;"></video>
                @else
                    <img src="{{ Storage::url($galeri->foto) }}" class="rounded shadow-sm" style="max-height: 150px;">
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Ganti File (Kosongkan jika tidak ingin ganti)</label>
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
                @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Keterangan Singkat</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $galeri->keterangan) }}</textarea>
            </div>

            <div class="text-end border-top pt-3 mt-2">
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-light px-4">Batal</a>
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-save me-1"></i> Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>

@endsection