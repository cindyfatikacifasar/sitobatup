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
                    {{-- BARIS 1: Nama Tanaman & Nama Ilmiah --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Nama Tanaman <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control form-control-sm" placeholder="Contoh: Jahe Merah" value="{{ old('nama') }}" required style="border-radius: 5px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Nama Ilmiah (Latin) <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ilmiah" class="form-control form-control-sm" placeholder="Contoh: Zingiber officinale var. rubrum" value="{{ old('nama_ilmiah') }}" required style="border-radius: 5px; font-style: italic;">
                        </div>
                    </div>

                    {{-- BARIS 2: Kategori & Kolektor --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select form-select-sm" required style="border-radius: 5px;">
                                <option value="">-- Pilih Kategori Khasiat --</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Kolektor / Sumber Tanaman <span class="text-danger">*</span></label>
                            <input type="text" name="kolektor" class="form-control form-control-sm" placeholder="Contoh: Laboratorium Biologi UP / Nama Penemu" value="{{ old('kolektor') }}" required style="border-radius: 5px;">
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