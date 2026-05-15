{{-- resources/views/pj/saran/create.blade.php --}}
@extends('layouts.pj')
@section('title','Kirim Saran ke Admin')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('pj.saran.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold" style="color:#1a3a5c;">📨 Kirim Saran ke Admin</h5>
</div>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header" style="background:#e3f2fd;color:#1a3a5c;font-weight:600;">
                <i class="bi bi-send me-2"></i>Formulir Saran untuk Administrator
            </div>
            <div class="card-body p-4">
                <p class="text-muted mb-4" style="font-size:.88rem;">
                    Gunakan formulir ini untuk menyampaikan saran, masukan, atau laporan kepada Administrator SITOBAT-UP terkait pengelolaan sistem atau data tanaman obat.
                </p>
                <form method="POST" action="{{ route('pj.saran.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-600" style="font-size:.88rem;">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', auth()->user()->name) }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-600" style="font-size:.88rem;">Isi Saran / Masukan <span class="text-danger">*</span></label>
                        <textarea name="pesan" class="form-control @error('pesan') is-invalid @enderror"
                            rows="6" placeholder="Tuliskan saran atau masukan Anda untuk Admin..." required>{{ old('pesan') }}</textarea>
                        @error('pesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Minimal 10 karakter</small>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-send me-2"></i>Kirim Saran
                        </button>
                        <a href="{{ route('pj.dashboard') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4 mt-4 mt-md-0">
        <div class="card" style="background:linear-gradient(135deg,#e3f2fd,#f0f8ff);border:none;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3" style="color:#1a3a5c;"><i class="bi bi-info-circle me-2"></i>Informasi</h6>
                <p class="text-muted" style="font-size:.85rem;">Saran yang Anda kirim akan masuk ke daftar saran Admin SITOBAT-UP dan akan ditindaklanjuti secepatnya.</p>
                <ul style="font-size:.84rem;color:#444;">
                    <li class="mb-1">Saran akan tercatat atas nama Anda</li>
                    <li class="mb-1">Admin dapat membaca saran Anda di panel admin</li>
                    <li>Gunakan ini untuk melaporkan data yang perlu diperbaiki</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection