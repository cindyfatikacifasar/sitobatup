@extends('layouts.app')
@section('title', $tanaman->nama)

@section('content')
<div style="background:linear-gradient(135deg,#1a5c2a,#2d8a4e);padding:30px 0 20px;color:white;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size:.85rem;">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}" style="color:rgba(255,255,255,.7);">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('katalog') }}" style="color:rgba(255,255,255,.7);">Katalog</a></li>
                <li class="breadcrumb-item active" style="color:white;">{{ $tanaman->nama }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <!-- Foto & Info Ringkas -->
        <div class="col-lg-4">
            <div class="card">
                <div style="height:280px;background:linear-gradient(135deg,#e8f5e9,#c8e6c9);border-radius:12px 12px 0 0;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    @if($tanaman->foto)
                        <img src="{{ Storage::url($tanaman->foto) }}" alt="{{ $tanaman->nama }}" style="width:100%;height:280px;object-fit:cover;">
                    @else
                        <span style="font-size:6rem;">🌿</span>
                    @endif
                </div>
                <div class="card-body">
                    <h4 class="fw-bold" style="color:#1a5c2a;">{{ $tanaman->nama }}</h4>
                    <p class="text-muted fst-italic mb-3">{{ $tanaman->nama_ilmiah }}</p>

                    <table class="table table-sm" style="font-size:.85rem;">
                        <tr>
                            <td class="text-muted" width="45%">Kategori</td>
                            <td><strong>{{ $tanaman->kategori->nama ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Bagian Digunakan</td>
                            <td><strong>{{ ucfirst($tanaman->bagian_digunakan ?? '-') }}</strong></td>
                        </tr>

                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                @if($tanaman->status_ketersediaan === 'tersedia')
                                    <span class="badge bg-success">Ada</span>
                                @else
                                    <span class="badge bg-danger">Tidak Ada</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Dilihat</td>
                            <td><strong>{{ number_format($tanaman->views) }} kali</strong></td>
                        </tr>
                    </table>



                    <!-- Share -->
                    <div class="mt-3">
                        <div class="text-muted mb-2" style="font-size:.82rem;font-weight:600;">Bagikan:</div>
                        <div class="d-flex gap-2">
                            <a href="https://wa.me/?text={{ urlencode($tanaman->nama . ' - ' . url()->current()) }}" target="_blank" class="btn btn-sm btn-success flex-fill">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-sm btn-primary flex-fill">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <button onclick="copyLink()" class="btn btn-sm btn-outline-secondary flex-fill">
                                <i class="bi bi-link-45deg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Informasi -->
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2" style="color:#2d8a4e;"></i>Deskripsi Tanaman
                </div>
                <div class="card-body" style="font-size:.9rem;line-height:1.8;color:#444;">
                    {{ $tanaman->deskripsi }}
                </div>
            </div>

            <div class="card mb-3" style="border-left:4px solid #2d8a4e;">
                <div class="card-header">
                    <i class="bi bi-heart-pulse me-2" style="color:#2d8a4e;"></i>Asal Tanaman Obat
                </div>
                <div class="card-body" style="font-size:.9rem;line-height:1.8;color:#444;">
                    {{ $tanaman->asal_usul }}
                </div>
            </div>

            <div class="card mb-3" style="border-left:4px solid #2d8a4e;">
                <div class="card-header">
                    <i class="bi bi-heart-pulse me-2" style="color:#2d8a4e;"></i>Khasiat & Manfaat
                </div>
                <div class="card-body" style="font-size:.9rem;line-height:1.8;color:#444;">
                    {{ $tanaman->khasiat }}
                </div>
            </div>



            <div class="card" style="background:linear-gradient(135deg,#e8f5e9,#f1f8f2);border:none;">
                <div class="card-body">
                    <div class="d-flex gap-2 align-items-start">
                        <span style="font-size:1.5rem;">⚠️</span>
                        <div>
                            <strong style="font-size:.88rem;">Peringatan</strong>
                            <p class="text-muted mb-0" style="font-size:.82rem;">
                                Informasi ini bersifat edukatif. Konsultasikan dengan tenaga medis sebelum menggunakan tanaman obat untuk pengobatan. Data telah divalidasi oleh Penanggungjawab Taman Koleksi Tanaman Obat Kebun Raya UP.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

@push('scripts')
<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Link berhasil disalin!');
    });
}
</script>
@endpush
@endsection