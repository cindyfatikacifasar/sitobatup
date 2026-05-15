@extends('layouts.admin')
@section('title','Kelola Galeri Album')
@section('content')

<style>
    .folder-card { 
        transition: all 0.3s ease; 
        border: none; 
        background: #f8fdf9;
        border-radius: 15px;
    }
    .folder-card:hover { transform: translateY(-8px); shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .album-cover { height: 160px; object-fit: cover; border-radius: 12px; }
    .photo-stack { 
        position: relative; 
        padding: 10px; 
        background: #fff; 
        border-radius: 15px; 
        border: 1px solid #e0e0e0;
    }
    /* Efek tumpukan kertas untuk album */
    .photo-stack::before {
        content: ""; position: absolute; top: 5px; left: 15px; right: 15px; height: 10px;
        background: #daeedd; border-radius: 10px; z-index: -1;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold text-success m-0">📁 Koleksi Album Galeri</h5>
    <div class="gap-2 d-flex">
        <a href="{{ route('admin.album.create') }}" class="btn btn-outline-success btn-sm px-3">Buat Album</a>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-success btn-sm px-3">+ Tambah Foto</a>
    </div>
</div>

<div class="row g-4">
    @forelse($albums as $album)
        <div class="col-md-4 col-lg-3">
            <div class="card folder-card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="photo-stack mb-3">
                        @php $firstPhoto = $album->galeris->first(); @endphp
                        @if($firstPhoto)
                            <img src="{{ Storage::url($firstPhoto->foto) }}" class="album-cover w-100 shadow-sm">
                        @else
                            <div class="album-cover w-100 d-flex align-items-center justify-content-center bg-light text-muted">
                                <i class="bi bi-image-fill fs-1 opacity-25"></i>
                            </div>
                        @endif
                        <span class="badge bg-success position-absolute bottom-0 end-0 m-3 shadow">
                            {{ $album->galeris->count() }} Foto
                        </span>
                    </div>

                    <h6 class="fw-bold text-success mb-1 text-truncate">{{ $album->nama_album }}</h6>
                    <p class="text-muted small mb-3"><i class="bi bi-calendar-event me-1"></i> {{ $album->created_at->format('d M Y') }}</p>

                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.album.show', $album->id) }}" class="btn btn-sm btn-light flex-fill border text-success fw-bold">
                            BUKA ALBUM
                        </a>
                        <a href="{{ route('admin.album.edit', $album->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.album.destroy', $album->id) }}" method="POST" onsubmit="return confirm('Hapus album dan seluruh isinya?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-folder-x fs-1 text-muted"></i>
            <p class="text-muted mt-2">Belum ada album galeri.</p>
        </div>
    @endforelse
</div>

@endsection