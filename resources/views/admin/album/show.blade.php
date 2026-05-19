@extends('layouts.admin')
@section('title', 'Isi Album ' . $album->nama_album)
@section('content')

<style>
    .media-card { transition: all 0.3s ease; border-radius: 12px; overflow: hidden; }
    .media-card:hover { transform: scale(1.02); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
    .media-box { height: 180px; width: 100%; object-fit: cover; background: #f0f4f1; }
    .video-icon { position: absolute; top: 50%; start: 50%; transform: translate(-50%, -50%); color: white; opacity: 0.8; }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.album.index') }}" class="btn btn-sm btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <div>
            <h5 class="mb-0 fw-bold text-success">📁 {{ $album->nama_album }}</h5>
            <p class="text-muted small mb-0">{{ $album->deskripsi ?? 'Tidak ada deskripsi album.' }}</p>
        </div>
    </div>
    
    {{-- Tombol Cepat: Upload foto langsung ke album ini --}}
    <a href="{{ route('admin.galeri.create') }}?album_id={{ $album->id }}" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Tambah Foto ke Album Ini
    </a>
</div>

<hr>

<div class="row g-3">
    @forelse($galeris as $g)
        @php $isVideo = Str::endsWith($g->foto, ['.mp4', '.mov', '.avi']); @endphp
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 media-card border-0 shadow-sm">
                <div class="position-relative">
                    @if($isVideo)
                        <video src="{{ Storage::url($g->foto) }}" class="media-box"></video>
                        <div class="video-icon"><i class="bi bi-play-circle fs-1"></i></div>
                    @else
                        <img src="{{ Storage::url($g->foto) }}" alt="{{ $g->judul }}" class="media-box">
                    @endif
                </div>
                <div class="card-body p-2 text-center">
                    <div style="font-size:.85rem; font-weight:600;" class="text-truncate" title="{{ $g->judul }}">
                        {{ $g->judul }}
                    </div>
                    <div class="d-flex gap-1 mt-2 justify-content-center">
                        <a href="{{ route('admin.galeri.edit', $g->id) }}" class="btn btn-sm btn-outline-warning p-1 px-2">
                            <i class="bi bi-pencil small"></i>
                        </a>
                        <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger p-1 px-2">
                                <i class="bi bi-trash small"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="display-4 text-muted opacity-25"><i class="bi bi-images"></i></div>
            <p class="text-muted mt-3">Album ini masih kosong. Belum ada foto atau video.</p>
        </div>
    @endforelse
</div>

@endsection