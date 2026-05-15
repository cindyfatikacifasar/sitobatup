@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Berita/Artikel *</label>
                            <input type="text" name="judul" class="form-control form-control-lg" placeholder="Masukkan Judul Berita..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Berita *</label>
                            <textarea name="isi_berita" id="editor" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Publish *</label>
                            <input type="date" name="tanggal_publish" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Cover *</label>
                            <input type="file" name="foto_cover" class="form-control" accept="image/*" required onchange="previewSingle(this)">
                            <img id="prev-cover" class="img-fluid rounded mt-2 d-none shadow-sm">
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Terbitkan Berita</button>
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-light w-100 mt-2">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
    
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