@extends('layouts.app')

@section('title', 'Ulasan Pengunjung - SITOBAT-UP')

@section('content')

<style>
    /* Styling khusus untuk interaksi input rating bintang */
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 6px;
    }
    .rating-input input {
        display: none;
    }
    .rating-input label {
        font-size: 1.8rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
    }
    .rating-input input:checked ~ label,
    .rating-input label:hover,
    .rating-input label:hover ~ label {
        color: #ffc107; /* Warna emas saat di-hover atau di-klik */
    }
    .star-gold {
        color: #ffc107;
    }
    /* Kustomisasi scrollbar halus untuk daftar ulasan */
    .review-scroll::-webkit-scrollbar {
        width: 5px;
    }
    .review-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .review-scroll::-webkit-scrollbar-thumb {
        background: #ccdbd0;
        border-radius: 10px;
    }
</style>

<div class="container py-5">
    {{-- HEADER HALAMAN UTAMA --}}
    <div class="text-center mb-5">
        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 fw-bold mb-2" style="border-radius: 30px; font-size: 0.78rem;">📢 SUARA PENGUNJUNG</span>
        <h2 class="fw-bold text-dark">Laporan Ulasan Masuk</h2>
        <p class="text-muted mx-auto mb-0" style="max-width: 600px; font-size: 0.92rem;">Apresiasi dan masukan Anda sangat berarti untuk pengembangan fasilitas koleksi tanaman obat Kebun Raya Universitas Pahlawan.</p>
    </div>

    <div class="row g-4 justify-content-center">
        
        {{-- SISI KIRI: FORMULIR INPUT REVIEWS --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4 p-sm-5" style="border-radius: 20px; background: #ffffff;">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; font-size: 1.3rem;">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Berikan Ulasan Anda</h5>
                        <small class="text-muted">Bagikan pengalaman kunjungan Anda</small>
                    </div>
                </div>

                {{-- PERBAIKAN UX OPSIONAL 1: Notifikasi Edukatif Biar Pengunjung Tanpa Login Tidak Panik --}}
                @if(session('success'))
                    <div class="alert alert-success border-0 small mb-4 shadow-sm p-3" style="background-color: #e8f5e9; color: #1a5c2a; border-radius: 10px; line-height: 1.5;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1"></i>
                            <div>
                                <strong class="d-block mb-1">Ulasan Berhasil Terkirim!</strong>
                                Terima kasih atas partisipasi Anda. Demi kenyamanan informasi bersama, ulasan Anda telah masuk antrean sistem dan akan segera tampil di halaman ini setelah diverifikasi oleh Admin Sitobat.
                            </div>
                        </div>
                    </div>
                @endif

                {{-- TAMBAHAN ID PADA FORM UNTUK TRIGGER JAVASCRIPT ANTI-SPAM --}}
                <form action="{{ route('ulasan.kirim') }}" method="POST" id="formUlasanPublik">
                    @csrf
                    
                    {{-- Input Nama --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control px-3 py-2" placeholder="Masukkan nama Anda..." required style="border-radius: 10px; border: 1px solid #e2e8f0; background-color: #f8fafc; font-size: 0.9rem;">
                    </div>

                    {{-- Input Kontak (Opsional + Privacy Note Hint) --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nomor WhatsApp / Email <span class="text-muted fw-normal">(Opsional)</span></label>
                        <input type="text" name="kontak" class="form-control px-3 py-2" placeholder="Contoh: 08123456xxx" style="border-radius: 10px; border: 1px solid #e2e8f0; background-color: #f8fafc; font-size: 0.9rem;">
                        <div class="form-text text-muted mt-2" style="font-size: 0.75rem; line-height: 1.4;">
                            🔒 <em>Kontak Anda hanya digunakan untuk verifikasi internal pengelola dan <strong>tidak akan ditampilkan</strong> di halaman publik website.</em>
                        </div>
                    </div>

                    {{-- Input Rating Bintang --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary d-block mb-2">Berikan Rating</label>
                        <div class="rating-input">
                            <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="Bintang 5"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Bintang 4"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Bintang 3"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Bintang 2"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Bintang 1"><i class="bi bi-star-fill"></i></label>
                        </div>
                    </div>

                    {{-- Input Pesan Ulasan --}}
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">Isi Ulasan / Kesan Pesan</label>
                        <textarea name="pesan" rows="4" class="form-control px-3 py-2" placeholder="Tuliskan ulasan Anda di sini..." required style="border-radius: 10px; border: 1px solid #e2e8f0; background-color: #f8fafc; font-size: 0.9rem; resize: none;"></textarea>
                    </div>

                    {{-- Tombol Kirim --}}
                    <button type="submit" class="btn text-white w-100 fw-bold py-2 shadow-sm" style="background-color: #1a5c2a; border-radius: 10px; transition: 0.3s;">
                        <i class="bi bi-send shadow-sm me-2"></i> Kirim Ulasan
                    </button>
                </form>
            </div>
        </div>

        {{-- SISI KANAN: LIST REVIEWS PENGUNJUNG YANG SUDAH DI-APPROVE --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 20px; background: #ffffff; min-height: 100%;">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-chat-left-text-fill text-success"></i>
                        <h5 class="fw-bold text-dark mb-0">Ulasan Pengunjung</h5>
                    </div>
                    <span class="badge text-success px-3 py-2 small fw-bold" style="background-color: rgba(26, 92, 42, 0.1); border-radius: 30px; font-size: 0.78rem;">
                        ✔ {{ $reviewsTampil->count() }} Ulasan Terverifikasi
                    </span>
                </div>

                <div class="review-scroll d-flex flex-column gap-3" style="max-height: 520px; overflow-y: auto; padding-right: 5px;">
                    @forelse($reviewsTampil as $rev)
                        <div class="p-3 border-0 rounded-4" style="background-color: #f8faf7 !important; transition: 0.3s;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.92rem;">{{ $rev->nama }}</h6>
                                    <small class="text-muted" style="font-size: 0.78rem;">
                                        <i class="bi bi-calendar4-event me-1"></i>{{ $rev->created_at->format('d M Y') }}
                                    </small>
                                </div>
                                {{-- Tampilan Bintang Emas --}}
                                <div class="star-gold small">
                                    @for($b = 1; $b <= 5; $b++)
                                        @if($b <= $rev->rating)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star text-muted opacity-25"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            {{-- Isi Ulasan --}}
                            <p class="text-secondary mb-0 mt-2" style="font-size: 0.88rem; white-space: pre-line; line-height: 1.5;">
                                {{ $rev->pesan }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted my-auto">
                            <i class="bi bi-chat-left-dots fs-1 text-success d-block mb-2" style="opacity: 0.4;"></i>
                            <h6 class="fw-bold mb-0">Belum Ada Ulasan</h6>
                            <small class="text-muted">Jadilah yang pertama memberikan kesan kunjungan.</small>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

{{-- PERBAIKAN UX MODUL 3: JAVASCRIPT LOCK MECHANISM (Kunci Tombol & Tampilkan Efek Spinner Loading) --}}
<script>
    document.getElementById('formUlasanPublik').addEventListener('submit', function() {
        // Ambil elemen tombol submit di dalam form ulasan publik
        var submitBtn = this.querySelector('button[type="submit"]');
        
        // Kunci tombol secepat kilat agar tidak bisa ditekan berkali-kali oleh user
        submitBtn.disabled = true;
        
        // Ubah isi tombol menjadi loading spinner bawaan bootstrap biar interaktif
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Sedang Mengirim Ulasan...';
    });
</script>

@endsection