{{-- {{-- resources/views/admin/kategori/create.blade.php --}}
// @extends('layouts.admin')
@section('title','Tambah Kategori')
@section('content')

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold" style="color: #43a047;">+ Tambah Kategori</h5>
</div>

{{-- Tambahkan Form di sini --}}
<form action="{{ route('admin.kategori.store') }}" method="POST">
    @csrf 
    <div class="card shadow-sm border-0" style="max-width:520px;">
        <div class="card-body">
            {{-- Pesan Error jika validasi gagal --}}
            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0" style="font-size: 0.85rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-600">Nama Kategori</label>
                {{-- Tambahkan value old agar tulisan tidak hilang jika gagal --}}
                <input type="text" name="nama_kategori" class="form-control" placeholder="Misal: Tanaman Perdu" value="{{ old('nama_kategori') }}" required>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check-lg me-1"></i> Simpan Kategori
                </button>
            </div>
        </div>
    </div>
</form>

@endsection  --}}