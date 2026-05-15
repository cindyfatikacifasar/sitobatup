{{-- resources/views/admin/user/create.blade.php --}}
@extends('layouts.admin')
@section('title','Tambah Penanggungjawab')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">+ Tambah Akun Penanggungjawab</h5>
</div>
<div class="card" style="max-width:560px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.user.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-600" style="font-size:.88rem;">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-600" style="font-size:.88rem;">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-600" style="font-size:.88rem;">No. HP</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-600" style="font-size:.88rem;">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-600" style="font-size:.88rem;">Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-600" style="font-size:.88rem;">Foto Profil</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <small class="text-muted">Opsional. Format JPG/PNG, maks 2MB</small>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-hijau"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection