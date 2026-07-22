{{-- resources/views/admin/profil.blade.php --}}
@extends('layouts.admin')
@section('title','Profil Saya')
@section('content')
<h5 class="mb-3 fw-bold" style="color: #43a047;">👤 Profil Admin</h5>
<div class="row justify-content-center">
    <div class="col-md-11 col-lg-10"> {{-- Melebarkan container agar pas menyamping --}}
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="row align-items-center">
                        {{-- SISI KIRI: KHUSUS TAMPILAN FOTO PROFIL ADMINISTRATOR --}}
                        <div class="col-md-4 text-center border-end py-2">
                            <div class="position-relative d-inline-block mb-2">
                                @if($user->foto)
                                    <img src="{{ Storage::url($user->foto) }}" class="rounded-circle shadow-sm" width="110" height="110" style="object-fit:cover;border:3px solid #2d8a4e;">
                                @else
                                    <div style="width:110px;height:110px;background:#e8f5e9;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:3rem;margin:0 auto;border:3px solid #2d8a4e;">👤</div>
                                @endif
                            </div>
                            <div class="fw-bold text-dark mt-1" style="font-size: 1.05rem;">{{ $user->name }}</div>
                            <span class="badge bg-success mt-1" style="font-size: 0.78rem; padding: 5px 12px; border-radius: 20px;">Administrator</span>
                            
                            {{-- Pindah Input File ke Sisi Bawah Foto Agar Hemat Ruang Vertikal --}}
                            <div class="text-start px-2 mt-3">
                                <label class="form-label fw-600 mb-1" style="font-size:.82rem;">Ganti Foto Profil</label>
                                <input type="file" name="foto" class="form-control form-control-sm" accept="image/*" style="border-radius: 6px;">
                            </div>
                        </div>

                        {{-- SISI KANAN: FORMULIR INPUT DATA (Dibuat Grid Padat Sejajar form-control-sm) --}}
                        <div class="col-md-8 ps-md-4 mt-3 mt-md-0">
                            <div class="row g-2"> {{-- g-2 membuat jarak vertikal antar elemen lebih rapat --}}
                                
                                {{-- Input Nama --}}
                                <div class="col-12">
                                    <label class="form-label fw-600 mb-1" style="font-size:.82rem;">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name',$user->name) }}" required style="border-radius: 7px;">
                                </div>

                                {{-- Input Email --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-600 mb-1" style="font-size:.82rem;">Email</label>
                                    <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email',$user->email) }}" required style="border-radius: 7px;">
                                    @error('email')<div class="invalid-feedback" style="font-size: 0.75rem;">{{ $message }}</div>@enderror
                                </div>

                                {{-- Input No HP --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-600 mb-1" style="font-size:.82rem;">No. HP</label>
                                    <input type="text" name="phone" class="form-control form-control-sm" value="{{ old('phone',$user->phone) }}" style="border-radius: 7px;">
                                </div>

                                {{-- Input Password Baru --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-600 mb-1" style="font-size:.82rem;">Password Baru</label>
                                    <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" style="border-radius: 7px;">
                                    <small class="text-muted d-block" style="font-size: 0.72rem;">Kosongkan jika tidak ingin mengubah</small>
                                    @error('password')<div class="invalid-feedback" style="font-size: 0.75rem;">{{ $message }}</div>@enderror
                                </div>

                                {{-- Input Konfirmasi Password --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-600 mb-1" style="font-size:.82rem;">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control form-control-sm" style="border-radius: 7px;">
                                </div>

                                {{-- Tombol Simpan Menggunakan Class Asli Kamu btn-hijau --}}
                                <div class="col-12 text-end mt-3">
                                    <button type="submit" class="btn btn-success btn-sm px-4 shadow-sm" style="background-color: #43a047; border-color: #43a047; border-radius: 5px;">
                                        <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                                    </button> 
                                </div>

                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection