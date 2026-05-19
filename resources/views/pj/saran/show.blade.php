@extends('layouts.app_pj')
@section('title', 'Detail Saran Masuk')
@section('content')

<div class="mb-4">
    <a href="{{ route('pj.saran.index') }}" class="btn btn-sm btn-light border fw-semibold px-3" style="border-radius: 8px;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Saran
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-header text-white p-3" style="background-color: #11411c; border-top-left-radius: 14px; border-top-right-radius: 14px;">
        <h5 class="card-title mb-0 fw-bold">Detail Pesan Masukan</h5>
    </div>
    <div class="card-body p-4">
        <div class="row mb-3 border-bottom pb-2">
            <div class="col-md-3 fw-bold text-muted">Nama Pengirim :</div>
            <div class="col-md-9 fw-bold text-dark">{{ $saran->nama ?? 'Anonim' }}</div>
        </div>
        
        <div class="row mb-3 border-bottom pb-2">
            <div class="col-md-3 fw-bold text-muted">Kontak (Email/HP) :</div>
            <div class="col-md-9 text-dark">{{ $saran->email ?? $saran->no_hp ?? '-' }}</div>
        </div>

        <div class="row mb-3 border-bottom pb-2">
            <div class="col-md-3 fw-bold text-muted">Tanggal Kirim :</div>
            <div class="col-md-9 text-muted">{{ $saran->created_at ? $saran->created_at->format('d F Y H:i') : '-' }} WIB</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-3 fw-bold text-muted">Isi Kritik & Saran :</div>
            <div class="col-md-9 bg-light p-3 rounded-3 text-dark" style="white-space: pre-line; line-height: 1.6;">
                {{ $saran->isi_saran ?? $saran->pesan ?? $saran->isi ?? 'Tidak ada teks pesan.' }}
            </div>
        </div>
    </div>
</div>

@endsection