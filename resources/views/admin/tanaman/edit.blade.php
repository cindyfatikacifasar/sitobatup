{{-- resources/views/admin/tanaman/edit.blade.php --}}
@extends('layouts.admin')
@section('title','Edit Tanaman Obat')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.tanaman.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">✏️ Edit: {{ $tanaman->nama }}</h5>
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.tanaman.update',$tanaman) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.tanaman._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-hijau px-4"><i class="bi bi-save me-1"></i>Perbarui</button>
                <a href="{{ route('admin.tanaman.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection