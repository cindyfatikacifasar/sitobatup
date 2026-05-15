@extends('layouts.app')
@section('title','Kirim Saran')
@section('content')
<div style="background:linear-gradient(135deg,#1a5c2a,#2d8a4e);padding:40px 0 30px;color:white;">
    <div class="container"><h1 class="h3 fw-bold mb-1">💬 Kirim Saran</h1><p class="mb-0" style="opacity:.85;font-size:.9rem;">Sampaikan masukan Anda untuk pengembangan Taman Koleksi Tanaman Obat</p></div>
</div>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card">
                <div class="card-header" style="background:#e8f5e9;color:#1a5c2a;font-weight:600;">
                    <i class="bi bi-chat-dots me-2"></i>Formulir Saran & Masukan
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4" style="font-size:.88rem;">
                        Saran Anda sangat berarti bagi kami untuk terus meningkatkan kualitas layanan Taman Koleksi Tanaman Obat Kebun Raya Universitas Pahlawan.
                    </p>
                    <form method="POST" action="{{ route('saran.kirim') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-600" style="font-size:.88rem;">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Anda" value="{{ old('nama') }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-600" style="font-size:.88rem;">Kontak (Email/No. HP)</label>
                            <input type="text" name="kontak" class="form-control" placeholder="Opsional - untuk kami hubungi kembali" value="{{ old('kontak') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-600" style="font-size:.88rem;">Pesan Saran <span class="text-danger">*</span></label>
                            <textarea name="pesan" class="form-control @error('pesan') is-invalid @enderror" rows="5" placeholder="Tuliskan saran, kritik, atau masukan Anda di sini..." required>{{ old('pesan') }}</textarea>
                            @error('pesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-hijau w-100 py-2">
                            <i class="bi bi-send me-2"></i>Kirim Saran
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4 mt-md-0">
            <div class="card" style="background:linear-gradient(135deg,#e8f5e9,#f1f8f2);border:none;">
                <div class="card-body p-4">
                    <h5 class="fw-bold" style="color:#1a5c2a;"><i class="bi bi-lightbulb me-2"></i>Kenapa Saran Anda Penting?</h5>
                    <p class="text-muted" style="font-size:.85rem;">Masukan dari masyarakat membantu kami:</p>
                    <ul style="font-size:.85rem;color:#444;">
                        <li class="mb-2">Meningkatkan informasi tanaman obat yang lebih lengkap</li>
                        <li class="mb-2">Memperbaiki tampilan dan fitur website</li>
                        <li class="mb-2">Menambah koleksi tanaman yang relevan</li>
                        <li>Meningkatkan pelayanan di lokasi taman</li>
                    </ul>
                    <div style="background:rgba(45,138,78,.1);border-radius:8px;padding:12px;margin-top:12px;">
                        <div style="font-size:.82rem;color:#1a5c2a;"><i class="bi bi-shield-check me-2"></i>Saran Anda bersifat rahasia dan hanya dibaca oleh pengelola.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection