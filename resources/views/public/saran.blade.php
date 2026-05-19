@extends('layouts.app') {{-- Sesuaikan dengan layout publik kamu --}}
@section('title', 'Ulasan Pengunjung - SITOBAT-UP')
@section('content')

<style>
    /* Styling khusus untuk interaksi input rating bintang */
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 4px;
    }
    .rating-input input {
        display: none;
    }
    .rating-input label {
        font-size: 1.8rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }
    .rating-input input:checked ~ label,
    .rating-input label:hover,
    .rating-input label:hover ~ label {
        color: #ffc107; /* Warna emas saat di-hover atau di-klik */
    }
    .star-gold {
        color: #ffc107;
    }
</style>

<div class="container py-5">
    <div class="row g-4">
        
        {{-- SISI KIRI: FORMULIR INPUT REVIEWS --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 12px; border-top: 4px solid #1a5c2a !important;">
                <h5 class="fw-bold mb-1" style="color: #1a5c2a;">✍️ Berikan Ulasan Anda</h5>
                <p class="text-muted small mb-4">Bagikan pengalaman dan penilaian Anda setelah berkunjung ke koleksi tanaman obat kami.</p>

                {{-- NOTIFIKASI SUKSES --}}
                @if(session('success'))
                    <div class="alert alert-success border-0 small mb-4" style="background-color: #e8f5e9; color: #1a5c2a; border-radius: 8px;">
                        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('saran.kirim') }}" method="POST">
                    @csrf
                    
                    {{-- Input Nama --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control form-control-sm" placeholder="Masukkan nama Anda..." required style="border-radius: 6px;">
                    </div>

                    {{-- Input Kontak (Opsional + Privacy Note Hint) --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Nomor WhatsApp / Email <span class="text-muted fw-normal">(Opsional)</span></label>
                        <input type="text" name="kontak" class="form-control form-control-sm" placeholder="Contoh: 08123456xxx" style="border-radius: 6px;">
                        <div class="form-text text-muted" style="font-size: 0.72rem; line-height: 1.3;">
                            🔒 <em>Kontak Anda hanya digunakan untuk verifikasi internal pengelola dan <strong>tidak akan ditampilkan</strong> di halaman publik website.</em>
                        </div>
                    </div>

                    {{-- Input Rating Bintang --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark d-block">Berikan Rating</label>
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
                        <label class="form-label small fw-bold text-dark">Isi Ulasan / Kesan Pesan</label>
                        <textarea name="pesan" rows="4" class="form-control small" placeholder="Tuliskan ulasan Anda di sini..." required style="border-radius: 6px; font-size: 0.88rem;"></textarea>
                    </div>

                    {{-- Tombol Kirim --}}
                    <button type="submit" class="btn btn-success btn-sm w-100 py-2 fw-bold shadow-sm" style="background-color: #1a5c2a; border-color: #1a5c2a; border-radius: 6px;">
                        <i class="bi bi-send-fill me-1"></i> Kirim Ulasan
                    </button>
                </form>
            </div>
        </div>

        {{-- SISI KANAN: LIST REVIEWS PENGUNJUNG YANG SUDAH DI-APPROVE --}}
        <div class="col-lg-7">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0 text-dark">💬 Apa Kata Pengunjung?</h5>
                <span class="badge bg-light text-success border border-success px-2 py-1 small" style="font-size: 0.75rem;">
                    {{ $reviewsTampil->count() }} Ulasan Terverifikasi
                </span>
            </div>

            <div class="row g-3" style="max-height: 520px; overflow-y: auto; padding-right: 4px;">
                @forelse($reviewsTampil as $rev)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-3" style="border-radius: 10px; background-color: #ffffff;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.9rem;">{{ $rev->nama }}</h6>
                                    <small class="text-muted" style="font-size: 0.72rem;">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $rev->created_at->format('d M Y') }}
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
                            {{-- Isi Ulasan Penguji (Kontak tidak dipanggil di sini demi keamanan privasi) --}}
                            <p class="text-secondary mb-0" style="font-size: 0.84rem; white-space: pre-line; line-height: 1.4;">
                                {{ $rev->pesan }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="bi bi-chat-square-heart fs-1 d-block mb-2" style="color: #1a5c2a; opacity: 0.4;"></i>
                        Belum ada ulasan yang ditampilkan. jadilah yang pertama memberikan ulasan!
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection@extends('layouts.public') {{-- Sesuaikan dengan layout publik kamu --}}
@section('title', 'Ulasan Pengunjung - SITOBAT-UP')
@section('content')

<style>
    /* Styling khusus untuk interaksi input rating bintang */
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 4px;
    }
    .rating-input input {
        display: none;
    }
    .rating-input label {
        font-size: 1.8rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }
    .rating-input input:checked ~ label,
    .rating-input label:hover,
    .rating-input label:hover ~ label {
        color: #ffc107; /* Warna emas saat di-hover atau di-klik */
    }
    .star-gold {
        color: #ffc107;
    }
</style>

<div class="container py-5">
    <div class="row g-4">
        
        {{-- SISI KIRI: FORMULIR INPUT REVIEWS --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 12px; border-top: 4px solid #1a5c2a !important;">
                <h5 class="fw-bold mb-1" style="color: #1a5c2a;">✍️ Berikan Ulasan Anda</h5>
                <p class="text-muted small mb-4">Bagikan pengalaman dan penilaian Anda setelah berkunjung ke koleksi tanaman obat kami.</p>

                {{-- NOTIFIKASI SUKSES --}}
                @if(session('success'))
                    <div class="alert alert-success border-0 small mb-4" style="background-color: #e8f5e9; color: #1a5c2a; border-radius: 8px;">
                        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('saran.kirim') }}" method="POST">
                    @csrf
                    
                    {{-- Input Nama --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control form-control-sm" placeholder="Masukkan nama Anda..." required style="border-radius: 6px;">
                    </div>

                    {{-- Input Kontak (Opsional + Privacy Note Hint) --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Nomor WhatsApp / Email <span class="text-muted fw-normal">(Opsional)</span></label>
                        <input type="text" name="kontak" class="form-control form-control-sm" placeholder="Contoh: 08123456xxx" style="border-radius: 6px;">
                        <div class="form-text text-muted" style="font-size: 0.72rem; line-height: 1.3;">
                            🔒 <em>Kontak Anda hanya digunakan untuk verifikasi internal pengelola dan <strong>tidak akan ditampilkan</strong> di halaman publik website.</em>
                        </div>
                    </div>

                    {{-- Input Rating Bintang --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark d-block">Berikan Rating</label>
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
                        <label class="form-label small fw-bold text-dark">Isi Ulasan / Kesan Pesan</label>
                        <textarea name="pesan" rows="4" class="form-control small" placeholder="Tuliskan ulasan Anda di sini..." required style="border-radius: 6px; font-size: 0.88rem;"></textarea>
                    </div>

                    {{-- Tombol Kirim --}}
                    <button type="submit" class="btn btn-success btn-sm w-100 py-2 fw-bold shadow-sm" style="background-color: #1a5c2a; border-color: #1a5c2a; border-radius: 6px;">
                        <i class="bi bi-send-fill me-1"></i> Kirim Ulasan
                    </button>
                </form>
            </div>
        </div>

        {{-- SISI KANAN: LIST REVIEWS PENGUNJUNG YANG SUDAH DI-APPROVE --}}
        <div class="col-lg-7">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0 text-dark">💬 Apa Kata Pengunjung?</h5>
                <span class="badge bg-light text-success border border-success px-2 py-1 small" style="font-size: 0.75rem;">
                    {{ $reviewsTampil->count() }} Ulasan Terverifikasi
                </span>
            </div>

            <div class="row g-3" style="max-height: 520px; overflow-y: auto; padding-right: 4px;">
                @forelse($reviewsTampil as $rev)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-3" style="border-radius: 10px; background-color: #ffffff;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.9rem;">{{ $rev->nama }}</h6>
                                    <small class="text-muted" style="font-size: 0.72rem;">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $rev->created_at->format('d M Y') }}
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
                            {{-- Isi Ulasan Penguji (Kontak tidak dipanggil di sini demi keamanan privasi) --}}
                            <p class="text-secondary mb-0" style="font-size: 0.84rem; white-space: pre-line; line-height: 1.4;">
                                {{ $rev->pesan }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="bi bi-chat-square-heart fs-1 d-block mb-2" style="color: #1a5c2a; opacity: 0.4;"></i>
                        Belum ada ulasan yang ditampilkan. jadilah yang pertama memberikan ulasan!
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection