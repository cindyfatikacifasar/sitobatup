{{-- resources/views/admin/user/edit.blade.php --}}
@extends('layouts.admin')
@section('title','Edit Penanggungjawab')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">✏️ Edit Akun: {{ $user->name }}</h5>
</div>
<div class="card" style="max-width:560px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.user.update',$user) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-600" style="font-size:.88rem;">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-600" style="font-size:.88rem;">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-600" style="font-size:.88rem;">No. HP</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone',$user->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-600" style="font-size:.88rem;">Password Baru</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-600" style="font-size:.88rem;">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <div class="col-12">
                    <label class="form-label fw-600" style="font-size:.88rem;">Ganti Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    @if($user->foto)
                    <div class="mt-2"><img src="{{ Storage::url($user->foto) }}" class="rounded-circle" width="60" height="60" style="object-fit:cover;"></div>
                    @endif
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-hijau"><i class="bi bi-save me-1"></i>Perbarui</button>
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection