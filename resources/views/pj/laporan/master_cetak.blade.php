<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak_Laporan_{{ $jenis }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: white; font-family: 'Times New Roman', Times, serif; color: black; }
        .kop-surat { border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 20px; }
        table th { background-color: #f2f2f2 !important; color: black !important; border: 1px solid black !important; text-align: center; font-weight: bold; }
        table td { border: 1px solid black !important; }
        @media print { @page { size: landscape; margin: 15mm; } }
    </style>
</head>
<body>
<div class="container-fluid my-4">
    <div class="text-center kop-surat">
        <h4 class="fw-bold mb-0">{{ $judul_laporan }}</h4>
        <h5 class="fw-bold mb-1">TAMAN KOLEKSI TANAMAN OBAT KEBUN RAYA UNIVERSITAS PAHLAWAN TUANKU TAMBUSAI</h5>
        <p class="text-muted small mb-0">Rentang Dokumen: <b>{{ $keterangan_waktu }}</b> | Dicetak otomatis sistem SITOBAT-UP</p>
    </div>

    <table class="table table-bordered align-middle w-100">
        {{-- SWITCH TABEL 1: KHUSUS TANAMAN OBAT --}}
        @if($jenis == 'tanaman')
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Lokal Tanaman</th>
                    <th>Nama Ilmiah (Latin)</th>
                    <th>Status Kategori</th>
                    <th>Tanggal Input</th>
                    <th style="width: 120px;">Total Dilihat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="fw-bold">{{ $d->nama_lokal ?? $d->nama }}</td>
                    <td><i>{{ $d->nama_ilmiah ?? '-' }}</i></td>
                    <td>{{ $d->kategori->nama_kategori ?? $d->kategori->nama ?? 'Umum' }}</td>
                    <td class="text-center">{{ $d->created_at ? $d->created_at->format('d-m-Y') : '-' }}</td>
                    <td class="text-center">{{ $d->views ?? 0 }} Kali</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Tidak ada data koleksi tanaman pada rentang waktu ini.</td></tr>
                @endforelse
            </tbody>

        {{-- SWITCH TABEL 2: KHUSUS BERITA --}}
        @elseif($jenis == 'berita')
            <thead><tr><th style="width:50px;">No</th><th>Judul Berita</th><th>Tanggal Publikasi</th><th>Total Dibaca</th></tr></thead>
            <tbody>
                @forelse($data as $i => $d)
                <tr><td class="text-center">{{ $i+1 }}</td><td class="fw-bold">{{ $d->judul }}</td><td class="text-center">{{ $d->created_at->format('d-m-Y') }}</td><td class="text-center">{{ $d->views ?? 0 }} Kali</td></tr>
                @empty<tr><td colspan="4" class="text-center">Tidak ada data berita.</td></tr>@endforelse
            </tbody>

        {{-- SWITCH TABEL 3: KHUSUS GALERI --}}
        @elseif($jenis == 'galeri')
            <thead><tr><th style="width:50px;">No</th><th>Nama Album Dokumentasi</th><th>Deskripsi</th><th>Tanggal Dibuat</th><th>Jumlah Foto</th></tr></thead>
            <tbody>
                @forelse($data as $i => $d)
                <tr><td class="text-center">{{ $i+1 }}</td><td class="fw-bold">{{ $d->nama_album }}</td><td>{{ $d->deskripsi ?? '-' }}</td><td class="text-center">{{ $d->created_at->format('d-m-Y') }}</td><td class="text-center">{{ $d->galeris_count ?? 0 }} Foto</td></tr>
                @empty<tr><td colspan="5" class="text-center">Tidak ada data album.</td></tr>@endforelse
            </tbody>

        {{-- SWITCH TABEL 4: KHUSUS PENGUNJUNG --}}
        @elseif($jenis == 'pengunjung')
            <thead><tr><th style="width:50px;">No</th><th>IP Address</th><th>Browser Perangkat</th><th>Tanggal Kunjungan</th></tr></thead>
            <tbody>
                @forelse($data as $i => $d)
                <tr><td class="text-center">{{ $i+1 }}</td><td>{{ $d->ip_address ?? '-' }}</td><td>{{ $d->user_agent ?? '-' }}</td><td class="text-center">{{ $d->created_at->format('d-m-Y H:i') }} WIB</td></tr>
                @empty<tr><td colspan="4" class="text-center">Tidak ada log riwayat kunjungan.</td></tr>@endforelse
            </tbody>

        {{-- PERBAIKAN: SWITCH TABEL 5: KHUSUS ULASAN (DIKUNCI SAMA DENGAN VALUE CONTROLLER 'Ulasan') --}}
        @elseif($jenis == 'Ulasan' || $jenis == 'ulasan')
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Pengirim</th>
                    <th>Isi Ulasan</th>
                    <th style="width: 170px;">Tanggal Masuk</th>
                    <th style="width: 100px; text-align: center;">Rating</th>
                    <th style="width: 150px; text-align: center;">Kontak HP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="fw-bold">{{ $d->nama ?? 'Anonim' }}</td>
                    <td>{{ $d->isi_ulasan ?? $d->pesan ?? $d->isi ?? '-' }}</td>
                    <td class="text-center">{{ $d->created_at ? $d->created_at->format('d-m-Y H:i') : '-' }} WIB</td>
                    {{-- Menampilkan angka rating ulasan --}}
                    <td class="text-center">
                        {{ $d->rating ?? 5 }} / 5
                    </td>
                    {{-- Menampilkan kontak handphone pengunjung --}}
                    <td class="text-center">
                        {{ $d->no_hp ?? $d->telepon ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Tidak ada data Ulasan pada periode ini.</td></tr>
                @endforelse
            </tbody>
        @endif
    </table>
</div>
<script>window.onload = function() { window.print(); };</script>
</body>
</html>