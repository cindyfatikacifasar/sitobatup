{{-- resources/views/admin/tanaman/create.blade.php --}}
@extends('layouts.admin')
@section('title','Tambah Tanaman Obat')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.tanaman.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">+ Tambah Tanaman Obat Baru</h5>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.tanaman.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-600">Nama Tanaman <span class="text-danger">*</span></label>
                            <input type="text" name="nama_tanaman" class="form-control" placeholder="Contoh: Jahe Merah" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-600">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Deskripsi Singkat</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan asal usul tanaman..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Khasiat & Manfaat</label>
                        <textarea name="khasiat" id="editor_khasiat" class="form-control"></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-4 text-center p-3 border rounded bg-light">
                        <label class="form-label d-block fw-600">Foto Utama Tanaman</label>
                        <img id="preview" src="{{ asset('img/no-image.png') }}" class="img-fluid rounded mb-2" style="max-height: 200px;">
                        <input type="file" name="foto_utama" class="form-control" onchange="previewImage(this)">
                        <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Bagian yang Digunakan</label>
                        <div class="d-flex flex-wrap gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="bagian[]" value="Daun" id="daun">
                                <label class="form-check-label" for="daun">Daun</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="bagian[]" value="Batang" id="batang">
                                <label class="form-check-label" for="batang">Batang</label>
                            </div>
                            </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="text-end">
                <a href="{{ route('admin.tanaman.index') }}" class="btn btn-light px-4">Batal</a>
                <button type="submit" class="btn btn-success px-5">Simpan Data Tanaman</button>
            </div>
        </form>
    </div>
</div>
@endsection