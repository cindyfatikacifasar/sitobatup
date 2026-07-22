@extends('layouts.admin')
@section('title','Tambah Berita')

@section('content')
<div class="container-fluid">
    {{-- Header Judul Halaman --}}
    <div class="mb-4">
        <h5 class="mb-0 fw-bold" style="color: #43a047;">📰 Tambah Berita & Informasi Baru</h5>
        <p class="text-muted small">Buat artikel kegiatan atau informasi publikasi untuk Kebun Raya Universitas Pahlawan.</p>
    </div>

    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            {{-- SISI KIRI: INPUT DATA UTAMA --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 10px;">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Judul Berita/Artikel *</label>
                            <input type="text" name="judul" class="form-control form-control-lg" placeholder="Masukkan Judul Berita..." required style="border-radius: 6px; font-size: 1.1rem;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Penulis *<span class="text-danger">*</span></label>
                            <input type="text" name="penulis" class="form-control form-control-sm" placeholder="Contoh: Admin, Humas UP" value="{{ old('penulis', 'Admin') }}" required style="border-radius: 5px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Isi Berita *</label>
                            <textarea name="isi_berita" id="editor" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SISI KANAN: PENGATURAN PUBLIKASI & CAROUSEL --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 10px;">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Tanggal Publish *</label>
                            <input type="date" name="tanggal_publish" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 5px;">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Foto Cover *</label>
                            <input type="file" name="foto_cover" class="form-control" accept="image/*" required onchange="previewSingle(this)" style="border-radius: 5px;">
                            <img id="prev-cover" class="img-fluid rounded mt-2 d-none shadow-sm" style="max-height: 180px; width: 100%; object-fit: cover;">
                        </div>

                        {{-- FITUR PILIHAN CAROUSEL YANG HILANG SUDAH KEMBALI --}}
                        <div class="mb-3 bg-light p-3 rounded" style="border-radius: 8px;">
                            <label class="form-label fw-bold text-dark d-block mb-1">Tampilkan di Carousel?</label>
                            <small class="text-muted d-block mb-2" style="font-size: 0.75rem; line-height: 1.3;">Jika diaktifkan, berita ini akan terpajang besar di banner utama halaman beranda depan website.</small>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_carousel" value="1" id="switchCarousel" style="cursor: pointer;">
                                <label class="form-check-input-label small fw-bold text-success" for="switchCarousel" style="cursor: pointer; margin-left: 5px;">
                                    Aktifkan di Beranda
                                </label>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">
                        
                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm" style="background-color: #43a047; border-color: #43a047; border-radius: 6px;">
                            <i class="bi bi-send-fill me-1"></i> Terbitkan Berita
                        </button>
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-light w-100 mt-2 border" style="border-radius: 6px;">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- UPGRADE CDN KE VERSION STABIL TERBARU YANG BEBAS DARI KOTAK MERAH LOCK TEXT --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    // Penjinak kotak merah pengunci sinkronisasi text area
    CKEDITOR.config.versionCheck = false;
    
    // Inisialisasi Textarea Editor bawaanmu
    CKEDITOR.replace('editor');
    
    // Fungsi Preview Gambar Cover
    function previewSingle(input) {
        const preview = document.getElementById('prev-cover');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection