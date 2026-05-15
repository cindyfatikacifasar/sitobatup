@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-success">Tambah Koleksi Galeri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 border-end">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul Kegiatan *</label>
                                    <input type="text" name="judul" class="form-control" placeholder="Misal: Kunjungan Mahasiswa" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Tanggal *</label>
                                        <input type="date" name="tanggal" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label fw-bold">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Keterangan singkat..."></textarea>
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Unggah Media (Foto/Video) *</label>
                                <div class="border-dashed p-3 text-center rounded bg-light" style="border: 2px dashed #28a745; min-height: 150px;">
                                    <input type="file" name="foto[]" class="form-control mb-2" accept="image/*,video/*" multiple required onchange="previewMedia(this, 'preview-container')">
                                    <small class="text-muted">Sindi bisa pilih banyak file sekaligus.<br>Format: JPG, PNG, MP4. Maks: 10MB</small>
                                </div>
                                
                                <div id="preview-container" class="mt-3 d-flex flex-wrap gap-2" style="max-height: 180px; overflow-y: auto;"></div>
                            </div>
                        </div>
            
                        <div class="text-end border-top mt-3 pt-3">
                            <button type="submit" class="btn btn-success px-5">Simpan Galeri</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <script>
            function previewMedia(input, targetId) {
                const container = document.getElementById(targetId);
                container.innerHTML = '';
                if (input.files) {
                    Array.from(input.files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'position-relative';
                            
                            if (file.type.startsWith('video/')) {
                                div.innerHTML = `<video src="${e.target.result}" class="rounded border" style="width:80px; height:80px; object-fit:cover;"></video>
                                                 <span class="badge bg-dark position-absolute bottom-0 start-0" style="font-size:10px;">Video</span>`;
                            } else {
                                div.innerHTML = `<img src="${e.target.result}" class="rounded border" style="width:80px; height:80px; object-fit:cover;">`;
                            }
                            container.appendChild(div);
                        }
                        reader.readAsDataURL(file);
                    });
                }
            }
            </script>
@endsection