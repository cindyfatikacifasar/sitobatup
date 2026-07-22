{{-- resources/views/admin/kategori/edit.blade.php --}}
@extends('layouts.admin')
@section('title','Edit Kategori')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold" style="color: #43a047;">✏️ Edit Kategori: {{ $kategori->nama }}</h5>
</div>
<div class="card" style="max-width:520px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.kategori.update',$kategori) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-600" style="font-size:.88rem;">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" value="{{ old('nama', $kategori->nama) }}" required>
                @error('nama_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-hijau"><i class="bi bi-save me-1"></i>Perbarui</button>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection