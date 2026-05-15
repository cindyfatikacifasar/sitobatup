{{-- resources/views/pj/profil.blade.php --}}
@extends('layouts.pj')
@section('title','Profil Saya')
@section('content')
<h5 class="mb-3 fw-bold" style="color:#1a3a5c;">👤 Profil Penanggungjawab</h5>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    @if($user->foto)
                        <img src="{{ Storage::url($user->foto) }}" class="rounded-circle mb-2" width="90" height="90"
                            style="object-fit:cover;border:3px solid #2d6a9e;">
                    @else
                        <div style="width:90px;height:90px;background:#e3f2fd;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2.5rem;margin:0 auto 8px;border:3px solid #2d6a9e;">👤</div>
                    @endif
                    <div class="fw-bold">{{ $user->name }}</div>
                    <span class="badge bg-info">Penanggungjawab Tanaman Obat</span>
                </div>
                <form method="POST" action="{{ route('pj.profil.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600" style="font-size:.88rem;">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600" style="font-size:.88rem;">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email',$user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600" style="font-size:.88rem;">No. HP</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone',$user->phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600" style="font-size:.88rem;">Password Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600" style="font-size:.88rem;">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600" style="font-size:.88rem;">Ganti Foto Profil</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted">Format JPG/PNG, maks 2MB</small>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 px-4">
                        <i class="bi bi-save me-1"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection