@extends('layouts.admin')
@section('title', 'Tambah Foto Galeri')
@section('content')

<div class="mb-4">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.galeri.index') }}" class="btn btn-sm btn-outline-secondary py-1 px-2">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h5 class="mb-0 fw-bold" style="color: #43a047;">📸 Tambah Foto Galeri Baru</h5>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal Unggah Galeri:</h6>
        <ul class="mb-0 small ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                {{-- Pilih Album --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Pilih Album *</label>
                    <select name="album_id" id="album_id" class="form-select @error('album_id') is-invalid @enderror" required>
                        <option value="" disabled selected>-- Pilih Album Koleksi --</option>
                        @foreach($albums as $album)
                            <option value="{{ $album->id }}" {{ old('album_id') == $album->id ? 'selected' : '' }}>{{ $album->nama_album }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Judul Foto (Opsional) --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Judul Foto <span class="text-muted font-monospace small">(Opsional)</span></label>
                    <input type="text" name="judul_foto" class="form-control" value="{{ old('judul_foto') }}" placeholder="Kosongkan jika ingin menyamakan dengan nama album">
                </div>

                {{-- File Foto/Video (Multiple - Pakai nama foto[]) --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">File Foto/Video * <span class="text-success small">(Bisa pilih banyak sekaligus)</span></label>
                    <input type="file" name="foto[]" class="form-control @error('foto') is-invalid @enderror" accept="image/*,video/mp4" multiple required>
                    <div class="form-text small text-muted">tahan tombol <b>Ctrl</b> di keyboard untuk memilih lebih dari 1 foto/video sekaligus.</div>
                </div>

                {{-- Keterangan Singkat (Opsional) --}}
                <div class="col-md-12 mb-4">
                    <label class="form-label fw-bold">Keterangan Singkat <span class="text-muted font-monospace small">(Opsional)</span></label>
                    <textarea name="keterangan" class="form-control" rows="4" placeholder="Ceritakan sedikit tentang foto ini (boleh dikosongkan)...">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-end gap-2 border-top pt-3">
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-light btn-sm px-3">Batal</a>
                <button type="submit" class="btn btn-success btn-sm px-4 fw-bold shadow-sm">
                    <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan ke Galeri
                </button>
            </div>
        </form>
    </div>
</div>

@endsection