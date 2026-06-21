@extends('layouts.admin')
@section('title', 'Kelola Ulasan Pengunjung')
@section('content')

<style>
    .star-rating {
        color: #ffc107; /* Warna emas untuk bintang */
        font-size: 1rem;
    }
</style>

<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h5 class="mb-0 fw-bold" style="color:#1a5c2a;">⭐ Kelola Ulasan (Reviews)</h5>
        <p class="text-muted small mb-0">Moderasi ulasan dan rating bintang dari pengunjung Kebun Raya Universitas Pahlawan.</p>
    </div>
</div>

{{-- FILTER & PENCARIAN MENYATU: Kembar Identik 100% dengan Halaman Berita --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 10px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.ulasan.index') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-4">
                <select name="status" class="form-select form-select-sm" style="border-radius: 5px;">
                    <option value="">Semua Status Tampilan</option>
                    <option value="tampil" {{ request('status')=='tampil'?'selected':'' }}>Ditampilkan di Web</option>
                    <option value="sembunyi" {{ request('status')=='sembunyi'?'selected':'' }}>Disembunyikan</option>
                </select>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="input-group input-group-sm">
                    <input type="text" name="cari" class="form-control" placeholder="Cari berdasarkan nama pengirim..." value="{{ request('cari') }}" style="border-radius: 5px 0 0 5px;">
                    <button type="submit" class="btn btn-success px-3" style="background-color: #1a5c2a; border-color: #1a5c2a; border-radius: 0 5px 5px 0;">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>
            </div>

            @if(request('cari') || request('status'))
                <div class="col-12 col-md-auto d-flex justify-content-start">
                    <a href="{{ route('admin.ulasan.index') }}" class="btn btn-secondary btn-sm px-3 w-100 text-center" style="border-radius: 5px;">Reset</a>
                </div>
            @endif
        </form>
    </div>
</div>

{{-- ALERT SUKSES MODERASI --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm p-3 mb-4" role="alert" style="background-color: #e8f5e9; color: #1a5c2a; border-radius: 10px;">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            <span class="small fw-bold">{{ session('success') }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="box-shadow: none;"></button>
    </div>
@endif

{{-- Tampilan Desktop (Tabel) --}}
<div class="d-none d-md-block">
    <div class="card shadow-sm border-0" style="border-radius: 10px;">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary" style="width: 60px;">#</th>
                        <th class="py-3 text-secondary" style="width: 220px;">Pengirim & Kontak</th>
                        <th class="py-3 text-secondary" style="width: 130px;">Rating</th>
                        <th class="py-3 text-secondary">Isi Ulasan</th>
                        <th class="py-3 text-secondary text-center" style="width: 160px;">Tampilkan di Web?</th>
                        <th class="py-3 text-secondary text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ulasans as $i => $s)
                    <tr class="{{ !$s->is_read ? 'table-warning' : '' }}" id="row-ulasan-{{ $s->id }}">
                        <td class="px-4 fw-bold text-muted">{{ $ulasans->firstItem() + $i }}</td>
                        <td>
                            <div class="nama-pengirim {{ !$s->is_read ? 'fw-bold' : '' }} text-dark" style="font-size:0.87rem;">{{ $s->nama }}</div>
                            @if($s->kontak)
                                <div class="text-muted small"><i class="bi bi-whatsapp me-1"></i>{{ $s->kontak }}</div>
                            @else
                                <div class="text-muted small text-black-50"><em>- Tanpa Kontak -</em></div>
                            @endif
                        </td>
                        <td>
                            <div class="star-rating" title="Rating: {{ $s->rating }} Bintang">
                                @for($bintang = 1; $bintang <= 5; $bintang++)
                                    @if($bintang <= $s->rating)
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-star text-muted opacity-25"></i>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td style="font-size:0.85rem; color: #444;">
                            {{ Str::limit($s->pesan, 70) }}
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.ulasan.toggle-display', $s->id) }}" method="POST">
                                @csrf @method('PATCH')
                                @if($s->is_displayed)
                                    <button type="submit" class="btn btn-sm btn-success px-3 py-1 shadow-sm" style="font-size: 0.75rem; border-radius: 20px;">
                                        <i class="bi bi-eye-fill me-1"></i> Ya (Aktif)
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-outline-secondary px-3 py-1" style="font-size: 0.75rem; border-radius: 20px;">
                                        <i class="bi bi-eye-slash-fill me-1"></i> Tidak
                                    </button>
                                @endif
                            </form>
                        </td>
                        <td class="text-center">
                            <div class="btn-group gap-1">
                                <button type="button" class="btn btn-sm btn-outline-primary btn-baca-ulasan" data-id="{{ $s->id }}" style="padding: 2px 6px;" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $s->id }}" title="Lihat Ulasan Lengkap">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.ulasan.destroy', $s->id) }}" class="d-inline" onsubmit="return confirm('Hapus ulasan ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 2px 6px;" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-star-half fs-1 d-block mb-2" style="color: #1a5c2a; opacity: 0.5;"></i>
                            Belum ada ulasan (reviews) dari pengunjung.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Tampilan Mobile (Card List) --}}
<div class="d-md-none">
    @forelse($ulasans as $i => $s)
    <div class="card shadow-sm border-0 mb-3 {{ !$s->is_read ? 'border-start border-4 border-warning' : '' }}" id="row-ulasan-mobile-{{ $s->id }}" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                <span class="text-muted small">No. {{ $ulasans->firstItem() + $i }}</span>
                
                <form action="{{ route('admin.ulasan.toggle-display', $s->id) }}" method="POST">
                    @csrf @method('PATCH')
                    @if($s->is_displayed)
                        <button type="submit" class="btn btn-sm btn-success px-2.5 py-0.5 shadow-sm" style="font-size: 0.68rem; border-radius: 20px;">
                            <i class="bi bi-eye-fill me-1"></i> Tampil
                        </button>
                    @else
                        <button type="submit" class="btn btn-sm btn-outline-secondary px-2.5 py-0.5" style="font-size: 0.68rem; border-radius: 20px;">
                            <i class="bi bi-eye-slash-fill me-1"></i> Sembunyi
                        </button>
                    @endif
                </form>
            </div>
            
            <div class="mb-2">
                <div class="nama-pengirim {{ !$s->is_read ? 'fw-bold' : '' }} text-dark fs-6">{{ $s->nama }}</div>
                @if($s->kontak)
                    <div class="text-muted small"><i class="bi bi-whatsapp me-1"></i>{{ $s->kontak }}</div>
                @else
                    <div class="text-muted small text-black-50"><em>- Tanpa Kontak -</em></div>
                @endif
            </div>

            <div class="mb-2">
                <div class="star-rating" title="Rating: {{ $s->rating }} Bintang">
                    @for($bintang = 1; $bintang <= 5; $bintang++)
                        @if($bintang <= $s->rating)
                            <i class="bi bi-star-fill"></i>
                        @else
                            <i class="bi bi-star text-muted opacity-25"></i>
                        @endif
                    @endfor
                </div>
            </div>

            <div class="p-2 bg-light rounded text-muted mb-3" style="font-size: 0.82rem; line-height: 1.4;">
                {{ Str::limit($s->pesan, 100) }}
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary btn-baca-ulasan px-3" data-id="{{ $s->id }}" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $s->id }}">
                    <i class="bi bi-eye me-1"></i> Detail
                </button>
                <form method="POST" action="{{ route('admin.ulasan.destroy', $s->id) }}" class="d-inline" onsubmit="return confirm('Hapus ulasan ini secara permanen?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger px-3">
                        <i class="bi bi-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="card shadow-sm border-0 text-center p-4" style="border-radius: 10px;">
        <p class="text-muted mb-0">Belum ada ulasan (reviews) dari pengunjung.</p>
    </div>
    @endforelse
</div>

@if($ulasans->hasPages())
    <div class="mt-3 px-2">
        {{ $ulasans->links() }}
    </div>
@endif

{{-- ==========================================
     KUMPULAN POP-UP MODAL DETAIL LENGKAP
     ========================================== --}}
@foreach($ulasans as $s)
    <div class="modal fade" id="modalDetail{{ $s->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 10px;">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-chat-left-text-fill me-2"></i> Detail Ulasan Pengunjung</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-3 border-bottom pb-2">
                        <label class="text-muted small d-block mb-1">Nama Pengirim</label>
                        <span class="fw-bold text-dark fs-5">{{ $s->nama }}</span>
                    </div>
                    <div class="mb-3 border-bottom pb-2">
                        <label class="text-muted small d-block mb-1">Kontak / WhatsApp</label>
                        <span class="fw-bold text-dark">{{ $s->kontak ?? '- Tidak Ada Kontak -' }}</span>
                    </div>
                    <div class="mb-3 border-bottom pb-2">
                        <label class="text-muted small d-block mb-1">Rating yang Diberikan</label>
                        <div class="star-rating">
                            @for($bintang = 1; $bintang <= 5; $bintang++)
                                @if($bintang <= $s->rating)
                                    <i class="bi bi-star-fill text-warning fs-5"></i>
                                @else
                                    <i class="bi bi-star text-muted opacity-25 fs-5"></i>
                                @endif
                            @endfor
                            <span class="ms-1 text-dark fw-bold small">({{ $s->rating }} / 5)</span>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-2">
                        <label class="text-muted small d-block mb-1">Isi Pesan Ulasan</label>
                        <div class="p-3 bg-light rounded text-dark" style="font-size: 0.9rem; white-space: pre-line; line-height: 1.5;">
                            {{ $s->pesan }}
                        </div>
                    </div>
                    <div>
                        <label class="text-muted small d-block mb-1">Waktu Masuk</label>
                        <span class="text-muted small fw-bold"><i class="bi bi-clock me-1"></i> {{ $s->created_at->format('d M Y H:i') }} WIB</span>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm px-3" style="border-radius: 5px;" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- JAVASCRIPT AJAX UNTUK MENGUBAH STATUS BACA OTOMATIS TANPA RELOAD --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-baca-ulasan').on('click', function() {
        var ulasanId = $(this).data('id');
        var barisTabel = $('#row-ulasan-' + ulasanId);
        var cardMobile = $('#row-ulasan-mobile-' + ulasanId);

        // Kirim permintaan update status via AJAX
        $.ajax({
            url: "{{ url('/admin/ulasan') }}/" + ulasanId + "/read-ajax",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.success) {
                    // Hilangkan warna background kuning secara real-time di tabel desktop
                    barisTabel.removeClass('table-warning');
                    barisTabel.find('.nama-pengirim').removeClass('fw-bold');
                    
                    // Hilangkan warna background kuning di card mobile
                    cardMobile.removeClass('border-start border-4 border-warning');
                    cardMobile.find('.nama-pengirim').removeClass('fw-bold');
                }
            }
        });
    });
});
</script>
@endpush

@endsection