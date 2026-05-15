{{-- resources/views/admin/galeri/edit.blade.php --}}
@extends('layouts.admin')
@section('title','Edit Foto Galeri')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.galeri.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">✏️ Edit Foto: {{ Str::limit($galeri->judul,40) }}</h5>
</div>
<div class="card" style="max-width:560px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.galeri.update',$galeri) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-600" style="font-size:.88rem;">Judul Foto <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul',$galeri->judul) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-600" style="font-size:.88rem;">Tanggal <span class="text-danger">*</span></label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal',$galeri->tanggal) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-600" style="font-size:.88rem;">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi',$galeri->deskripsi) }}</textarea>
            </div>
            <div class="mb-4">
                <label class="form-label fw-600" style="font-size:.88rem;">Ganti Foto (opsional)</label>
                <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImg(this,'prev')">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
                <div id="prev" class="mt-2">
                    @if($galeri->foto)<img src="{{ Storage::url($galeri->foto) }}" style="height:100px;border-radius:8px;object-fit:cover;">@endif
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-hijau"><i class="bi bi-save me-1"></i>Perbarui</button>
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
function previewImg(input, id) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById(id).innerHTML = '<img src="'+e.target.result+'" style="height:100px;border-radius:8px;object-fit:cover;">';
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection