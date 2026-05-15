<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Koleksi Tanaman Obat - SITOBAT-UP</title>
    <style>
        * { font-family: Arial, sans-serif; font-size: 12px; }
        body { margin: 20px; color: #333; }
        h1 { font-size: 16px; text-align: center; color: #1a5c2a; }
        h3 { font-size: 13px; text-align: center; color: #555; font-weight: normal; margin-top: 4px; }
        .kop { text-align: center; border-bottom: 2px solid #1a5c2a; padding-bottom: 12px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th { background: #1a5c2a; color: white; padding: 8px 6px; text-align: left; font-size: 11px; }
        td { padding: 7px 6px; border-bottom: 1px solid #ddd; vertical-align: top; }
        tr:nth-child(even) td { background: #f5fff8; }
        .badge-tersedia { background: #d4edda; color: #155724; padding: 2px 8px; border-radius: 10px; font-size: 10px; }
        .badge-tidak { background: #f8d7da; color: #721c24; padding: 2px 8px; border-radius: 10px; font-size: 10px; }
        .footer { margin-top: 24px; text-align: right; color: #888; font-size: 11px; }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="no-print" style="margin-bottom:16px;">
    <button onclick="window.print()" style="background:#1a5c2a;color:white;border:none;padding:8px 20px;border-radius:6px;cursor:pointer;font-size:13px;">🖨️ Cetak / Simpan PDF</button>
    <button onclick="window.close()" style="margin-left:8px;padding:8px 20px;border-radius:6px;cursor:pointer;font-size:13px;">✕ Tutup</button>
</div>

<div class="kop">
    <h1>🌿 LAPORAN KOLEKSI TANAMAN OBAT</h1>
    <h3>Taman Koleksi Tanaman Obat - Kebun Raya Universitas Pahlawan Tuanku Tambusai</h3>
    <p style="margin:4px 0;font-size:11px;color:#777;">Bangkinang, Kabupaten Kampar, Riau &nbsp;|&nbsp; Tanggal Cetak: {{ \Carbon\Carbon::parse($tgl)->format('d F Y') }}</p>
</div>

<p style="margin-bottom:4px;"><strong>Total Koleksi:</strong> {{ $tanaman->count() }} tanaman obat</p>
<p style="margin-bottom:4px;"><strong>Tersedia:</strong> {{ $tanaman->where('status_ketersediaan','tersedia')->count() }} &nbsp;|&nbsp; <strong>Tidak Tersedia:</strong> {{ $tanaman->where('status_ketersediaan','tidak_tersedia')->count() }}</p>

<table>
    <thead>
        <tr>
            <th width="30">#</th>
            <th width="140">Nama Tanaman</th>
            <th width="140">Nama Ilmiah</th>
            <th width="100">Kategori</th>
            <th width="80">Bagian</th>
            <th width="100">Lokasi</th>
            <th width="75">Status</th>
            <th width="50">Views</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tanaman as $i => $t)
        <tr>
            <td>{{ $i+1 }}</td>
            <td><strong>{{ $t->nama }}</strong></td>
            <td style="font-style:italic;color:#555;">{{ $t->nama_ilmiah }}</td>
            <td>{{ $t->kategori->nama ?? '-' }}</td>
            <td>{{ ucfirst($t->bagian_digunakan ?? '-') }}</td>
            <td>{{ $t->lokasi_etalase ?? '-' }}</td>
            <td>
                @if($t->status_ketersediaan === 'tersedia')
                    <span class="badge-tersedia">Tersedia</span>
                @else
                    <span class="badge-tidak">Tidak</span>
                @endif
            </td>
            <td>{{ number_format($t->views) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    <p>Laporan dicetak oleh: {{ auth()->user()->name }} &nbsp;|&nbsp; SITOBAT-UP &copy; {{ date('Y') }}</p>
</div>
</body>
</html>