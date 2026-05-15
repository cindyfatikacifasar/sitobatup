@extends('layouts.admin')
@section('title','Edit Berita')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">✏️ Edit Berita</h5>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.berita.update', $berita->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-bold">Judul Berita</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $berita->judul) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Penulis</label>
                    <input type="text" name="penulis" class="form-control" value="{{ old('penulis', $berita->penulis) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Ganti Foto (Opsional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Isi Berita</label>
                    <textarea name="isi" class="form-control" rows="10" required>{{ old('isi', $berita->isi) }}</textarea>
                </div>

                <div class="col-12 mt-2">
                    <div class="form-check form-switch p-3 border rounded bg-light">
                        <input class="form-check-input ms-0 me-2" type="checkbox" name="is_popular" id="isPopular" value="1" {{ $berita->is_popular ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="isPopular" style="color: #1a5c2a;">
                            <i class="bi bi-star-fill me-1 text-warning"></i> Tampilkan di Carousel Beranda (Berita Populer)
                        </label>
                    </div>
                </div>

                <div class="col-12 mt-2">
                    <div class="form-check">
                        <input type="checkbox" name="is_published" class="form-check-input" id="published" value="1" {{ $berita->is_published ? 'checked' : '' }}>
                        <label class="form-check-label" for="published">Publikasikan Berita</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success px-4 fw-bold">Update Berita</button>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection