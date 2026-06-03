@extends('layouts.admin')
@section('title','Edit Tanaman Obat')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.tanaman.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 5px;">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">🌿 Edit Data Tanaman: {{ $tanaman->nama }}</h5>
</div>

{{-- ⚡ TAMBAHAN UI/UX: Memunculkan kotak pesan error validasi jika terjadi kendala data form --}}
@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 8px;">
        <ul class="mb-0 small fw-bold">
            @foreach ($errors->all() as $error)
                <li><i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm border-0" style="border-radius: 10px;">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.tanaman.update', $tanaman) }}" enctype="multipart/form-data">
            @csrf 
            @method('PUT')
            
            <div class="row g-4">
                {{-- SISI KIRI: INPUT DATA TEKS --}}
                <div class="col-lg-8">
                    
                    {{-- BARIS 1: Nama Tanaman & Nama Ilmiah --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Nama Tanaman <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control form-control-sm" value="{{ old('nama', $tanaman->nama) }}" required style="border-radius: 5px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Nama Ilmiah (Latin) <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ilmiah" class="form-control form-control-sm" value="{{ old('nama_ilmiah', $tanaman->nama_ilmiah) }}" required style="border-radius: 5px; font-style: italic;">
                        </div>
                    </div>

                    {{-- BARIS 2: Kategori Khasiat (CEKLIS MULTIPLE) & Kolektor --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark d-block mb-2">Kategori Khasiat <span class="text-danger">*</span></label>
                            <div class="p-3 border rounded bg-white" style="max-height: 150px; overflow-y: auto; border-radius: 5px;">
                                @foreach($kategoris as $k)
                                    <div class="form-check mb-2">
                                        {{-- PERBAIKAN UTAMA SINDI: Mengubah nama input menjadi kategori_ids[] agar sinkron dengan request Controller --}}
                                        <input class="form-check-input" type="checkbox" name="kategori_ids[]" value="{{ $k->id }}" id="kategori_{{ $k->id }}" 
                                            {{ in_array($k->id, old('kategori_ids', $tanaman->kategoris->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label small text-dark" for="kategori_{{ $k->id }}">
                                            {{ $k->nama_kategori }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Kolektor / Sumber Tanaman <span class="text-danger">*</span></label>
                            <input type="text" name="kolektor" class="form-control form-control-sm" value="{{ old('kolektor', $tanaman->kolektor) }}" required style="border-radius: 5px;">
                        </div>
                    </div>

                    {{-- BARIS 3: Asal Usul Tanaman --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Asal Usul Tanaman <span class="text-danger">*</span></label>
                        <textarea name="asal_usul" rows="3" class="form-control form-control-sm" required style="border-radius: 5px;">{{ old('asal_usul', $tanaman->asal_usul) }}</textarea>
                    </div>

                    {{-- BARIS 4: Deskripsi Tanaman --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Deskripsi Tanaman</label>
                        <textarea name="deskripsi" rows="3" class="form-control form-control-sm" style="border-radius: 5px;">{{ old('deskripsi', $tanaman->deskripsi) }}</textarea>
                    </div>

                    {{-- BARIS 5: Khasiat & Manfaat --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Khasiat & Manfaat</label>
                        <textarea name="khasiat" rows="3" class="form-control form-control-sm" style="border-radius: 5px;">{{ old('khasiat', $tanaman->khasiat) }}</textarea>
                    </div>

                </div>

                {{-- SISI KANAN: FOTO UTAMA TANAMAN --}}
                <div class="col-lg-4">
                    <div class="card bg-light border-0 p-3 mb-3" style="border-radius: 8px;">
                        <label class="form-label small fw-bold text-dark d-block mb-2">Foto Utama Tanaman</label>
                        
                        <div class="mb-3 text-center">
                            @if($tanaman->foto)
                                <img src="{{ Storage::url($tanaman->foto) }}" class="img-fluid rounded shadow-sm" style="max-height: 180px; object-fit: cover;">
                                <small class="text-muted d-block mt-1">Foto saat ini</small>
                            @else
                                <div class="bg-white rounded py-4 text-muted shadow-sm" style="font-size: 2.5rem;">🌿</div>
                                <small class="text-muted d-block mt-1">Belum ada foto</small>
                            @endif
                        </div>

                        <input type="file" name="foto" class="form-control form-control-sm" style="border-radius: 5px;">
                        <div class="form-text text-muted" style="font-size: 0.7rem;">Format: JPG, PNG. Maks: 2MB. Kosongkan jika tidak ingin mengubah foto.</div>
                    </div>
                </div>
            </div>

            {{-- TOMBOL AKSI BAWAH --}}
            <div class="d-flex gap-2 mt-4 border-top pt-3">
                <button type="submit" class="btn btn-success btn-sm px-4 shadow-sm" style="background-color: #1a5c2a; border-color: #1a5c2a;">
                    <i class="bi bi-save me-1"></i> Perbarui Data Tanaman
                </button>
                <a href="{{ route('admin.tanaman.index') }}" class="btn btn-outline-secondary btn-sm px-3" style="border-radius: 5px;">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection