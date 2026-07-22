@extends('layouts.app')
@section('title', $album->nama_album)
@section('content')

<style>
    .photo-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .photo-card:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }
    .img-frame {
        height: 240px;
        width: 100%;
        overflow: hidden;
        background: #f8f9fa;
    }
    .img-frame img, .img-frame video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .btn-back-uat {
        background: white;
        color: #43a047 !important;
        font-weight: 600;
        padding: 8px 20px;
        border-radius: 30px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-back-uat:hover {
        transform: translateX(-3px);
        background: #f8f9fa;
    }
    
    /* FIX POPUP CLOSE BUTTON */
    .modal-close-container {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 1060;
    }
    .btn-close-custom {
        background-color: white !important;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        opacity: 1 !important;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .btn-close-custom i {
        color: #000000 !important;
        font-size: 1.25rem;
        font-weight: bold;
        display: inline-block;
    }
    .btn-close-custom:hover {
        background-color: #e6e6e6 !important;
        transform: scale(1.05);
    }
</style>

<div style="background: linear-gradient(135deg, #43a047 0%, #43a047 100%); padding: 50px 0 40px 0; color: white;">
    <div class="container">
        <a href="{{ route('public.galeri') }}" class="btn-back-uat text-decoration-none text-success mb-3">
            <i class="bi bi-arrow-left fw-bold"></i> 
        </a>
        <h2 class="fw-bold mb-1">📂 {{ $album->nama_album }}</h2>
        <p class="small opacity-75 mb-0">Menampilkan isi berkas dari album resmi</p>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        @forelse($album->galeris as $g)
        @php
            // Deteksi format video secara aman (Mendukung Huruf Kecil & Kapital)
            $isVideo = Str::contains(strtolower($g->foto), ['.mp4', '.mov', '.avi']);
        @endphp
        
        <div class="col-md-4 col-sm-6">
            {{-- Tambah data-bs-type agar Javascript tahu berkas ini foto atau video --}}
            <div class="card h-100 photo-card shadow-sm" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-img="{{ asset('storage/' . $g->foto) }}" data-bs-title="{{ $g->judul }}" data-bs-desc="{{ $g->keterangan }}" data-bs-type="{{ $isVideo ? 'video' : 'image' }}">
                <div class="img-frame">
                    @if($isVideo)
                        <div class="bg-dark d-flex align-items-center justify-content-center h-100 position-relative">
                            <video class="w-100 h-100 object-fit-cover" muted playsinline>
                                <source src="{{ asset('storage/' . $g->foto) }}">
                            </video>
                            <i class="bi bi-play-circle-fill text-white position-absolute fs-1" style="opacity: 0.85;"></i>
                        </div>
                    @else
                        <img src="{{ asset('storage/' . $g->foto) }}" alt="{{ $g->judul }}">
                    @endif
                </div>
                <div class="card-body p-3 bg-white">
                    <h6 class="fw-bold text-dark text-truncate mb-1">{{ $g->judul ?? 'Dokumentasi' }}</h6>
                    <p class="text-muted small mb-0 text-truncate">{{ $g->keterangan ?? 'Klik untuk melihat detail berkas' }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="bi bi-images fs-1 text-success d-block mb-2"></i>
            <p class="fw-bold">Belum ada berkas documentation di dalam album ini.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- MODAL POPUP FIX DUA DUNIA: BISA PUTAR VIDEO & TAMPILKAN FOTO --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden; background: white; position: relative;">
            
            <div class="modal-close-container">
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            {{-- Tempat Konten Utama Melayang Dinamik --}}
            <div class="modal-body p-0 text-center d-flex align-items-center justify-content-center" style="min-height: 300px; background-color: #111 !important;">
                {{-- Wadah Gambar --}}
                <img src="" id="modalImage" class="img-fluid d-none" style="max-height: 70vh; object-fit: contain; width: 100%;">
                
                {{-- Wadah Video Player Aktif --}}
                <video id="modalVideo" controls class="img-fluid d-none" style="max-height: 70vh; width: 100%; outline: none;"></video>
            </div>
            
            <div class="p-4 bg-white border-top">
                <h5 class="fw-bold text-dark mb-2" id="modalTitle">Judul Gambar</h5>
                <p class="text-muted mb-0 fs-6" id="modalDesc">Keterangan lengkap foto dokumentasi.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var imageModal = document.getElementById('imageModal');
        
        // Matikan player video jika modal ditutup secara mendadak agar suara tidak bocor
        imageModal.addEventListener('hidden.bs.modal', function () {
            var modalVid = imageModal.querySelector('#modalVideo');
            modalVid.pause();
            modalVid.src = "";
        });

        imageModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var imgSrc = button.getAttribute('data-bs-img');
            var title = button.getAttribute('data-bs-title');
            var desc = button.getAttribute('data-bs-desc');
            var type = button.getAttribute('data-bs-type'); // Ambil info tipe berkas

            var modalImg = imageModal.querySelector('#modalImage');
            var modalVid = imageModal.querySelector('#modalVideo');
            var modalTitle = imageModal.querySelector('#modalTitle');
            var modalDesc = imageModal.querySelector('#modalDesc');

            // Atur Visibilitas Konten: Pilih memunculkan Video Player atau Image Tag
            if (type === 'video') {
                modalImg.classList.add('d-none');
                modalImg.src = "";
                
                modalVid.src = imgSrc;
                modalVid.classList.remove('d-none');
                modalVid.load(); // Paksa browser membaca ulang aliran streaming video
            } else {
                modalVid.classList.add('d-none');
                modalVid.pause();
                modalVid.src = "";
                
                modalImg.src = imgSrc;
                modalImg.classList.remove('d-none');
            }

            modalTitle.textContent = title ? title : 'Dokumentasi Kegiatan';
            modalDesc.textContent = desc ? desc : 'Tidak ada deskripsi tambahan.';
        });
    });
</script>

@endsection