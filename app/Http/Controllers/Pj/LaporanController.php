<?php

namespace App\Http\Controllers\Pj;

use App\Http\Controllers\Controller;
use App\Models\TanamanObat;
use App\Models\Album;
use App\Models\Berita;
use App\Models\Ulasan;
use App\Models\Pengunjung; // Pastikan nama model pengunjung sesuai di proyekmu
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // ==========================================
    // 1. MODUL LAPORAN TANAMAN OBAT
    // ==========================================
    public function tanaman(Request $request)
    {
        $query = TanamanObat::query();

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [$request->tanggal_mulai . ' 00:00:00', $request->tanggal_selesai . ' 23:59:59']);
        } elseif ($request->has('rentang_waktu') && $request->rentang_waktu != 'semua') {
            if ($request->rentang_waktu == 'tiga_bulan') { $query->where('created_at', '>=', now()->subMonths(3)); }
            elseif ($request->rentang_waktu == 'enam_bulan') { $query->where('created_at', '>=', now()->subMonths(6)); }
        }

        $tanamans = $query->latest()->paginate(10);
        return view('pj.laporan.tanaman', compact('tanamans'));
    }

    // =======================================================
    // BARU: 2. MODUL ULASAN MASUK (PENGGANTI MODUL SARAN)
    // =======================================================
    public function ulasan()
    {
        // Mengambil data ulasan terbaru dari database
        $ulasan = Ulasan::orderBy('created_at', 'desc')->paginate(10);
        
        // Mengarah ke halaman view indeks ulasan khusus hak akses Penanggung Jawab (PJ)
        return view('pj.ulasan.index', compact('ulasan'));
    }

    // ==========================================
    // 3. MODUL LAPORAN BERITA & ARTIKEL
    // ==========================================
    public function berita(Request $request)
    {
        $query = Berita::query();

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [$request->tanggal_mulai . ' 00:00:00', $request->tanggal_selesai . ' 23:59:59']);
        } elseif ($request->has('rentang_waktu') && $request->rentang_waktu != 'semua') {
            if ($request->rentang_waktu == 'tiga_bulan') { $query->where('created_at', '>=', now()->subMonths(3)); }
            elseif ($request->rentang_waktu == 'enam_bulan') { $query->where('created_at', '>=', now()->subMonths(6)); }
        }

        $beritas = $query->latest()->paginate(10);
        return view('pj.laporan.berita', compact('beritas')); // Menyesuaikan nama rute blademu nanti
    }

    // ==========================================
    // 4. MODUL LAPORAN GALERI DOKUMENTASI
    // ==========================================
    public function galeri(Request $request)
    {
        $query = Album::withCount('galeris');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [$request->tanggal_mulai . ' 00:00:00', $request->tanggal_selesai . ' 23:59:59']);
        } elseif ($request->has('rentang_waktu') && $request->rentang_waktu != 'semua') {
            if ($request->rentang_waktu == 'tiga_bulan') { $query->where('created_at', '>=', now()->subMonths(3)); }
            elseif ($request->rentang_waktu == 'enam_bulan') { $query->where('created_at', '>=', now()->subMonths(6)); }
        }

        $albums = $query->latest()->get();
        return view('pj.laporan.galeri', compact('albums'));
    }

    // ==========================================
    // 5. MODUL LAPORAN STATISTIK PENGUNJUNG
    // ==========================================
    public function pengunjung(Request $request)
    {
        // Pengaman jika tabel log pengunjung belum dibuat, biar tidak crash saat demo
        if (!class_exists(Pengunjung::class)) {
            $pengunjungs = [];
            return view('pj.laporan.pengunjung', compact('pengunjungs'));
        }

        $query = Pengunjung::query();

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [$request->tanggal_mulai . ' 00:00:00', $request->tanggal_selesai . ' 23:59:59']);
        } elseif ($request->has('rentang_waktu') && $request->rentang_waktu != 'semua') {
            if ($request->rentang_waktu == 'tiga_bulan') { $query->where('created_at', '>=', now()->subMonths(3)); }
            elseif ($request->rentang_waktu == 'enam_bulan') { $query->where('created_at', '>=', now()->subMonths(6)); }
        }

        $pengunjungs = $query->latest()->paginate(15);
        return view('pj.laporan.pengunjung', compact('pengunjungs'));
    }

    // ==========================================
    // ACTION MASTER EXPORT / CETAK (ALL-IN-ONE)
    // ==========================================
    public function export(Request $request)
    {
        $jenis = $request->get('jenis_laporan', 'tanaman');
        $rentang = $request->get('rentang_cetak', 'semua');
        $tgl_mulai = $request->get('cetak_tanggal_mulai');
        $tgl_selesai = $request->get('cetak_tanggal_selesai');

        // 1. Tentukan Model Kueri Berdasarkan Jenis Laporan
        // 1. Tentukan Model Kueri Berdasarkan Jenis Laporan
        if ($jenis == 'berita') { $query = Berita::query(); $judul = "LAPORAN PUBLIKASI BERITA & ARTIKEL MEA"; }
        elseif ($jenis == 'galeri') { $query = Album::withCount('galeris'); $judul = "LAPORAN DATA ALBUM DOKUMENTASI DENTAL"; }
        elseif ($jenis == 'pengunjung') { $query = class_exists(Pengunjung::class) ? Pengunjung::query() : null; $judul = "LAPORAN KUNJUNGAN MONITORING SITOBAT-UP"; }
        elseif ($jenis == 'Ulasan') { $query = Ulasan::query(); $judul = "LAPORAN DATA ULASAN DAN REVIEW PENGUNJUNG"; } // <-- INI TAMBAHANNYA SINDI!
        else { $query = TanamanObat::query(); $judul = "LAPORAN DATA KOLEKSI TANAMAN OBAT KELUARGA"; }

        if (!$query) return "Struktur tabel belum siap.";

        // 2. Terapkan Saringan Waktu Cetak
        if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
            $query->whereBetween('created_at', [$tgl_mulai . ' 00:00:00', $tgl_selesai . ' 23:59:59']);
            $keterangan_waktu = "Periode " . date('d/m/Y', strtotime($tgl_mulai)) . " s/d " . date('d/m/Y', strtotime($tgl_selesai));
        } else {
            if ($rentang == 'tiga_bulan') { $query->where('created_at', '>=', now()->subMonths(3)); $keterangan_waktu = "3 Bulan Terakhir"; }
            elseif ($rentang == 'enam_bulan') { $query->where('created_at', '>=', now()->subMonths(6)); $keterangan_waktu = "6 Bulan Terakhir"; }
            else { $keterangan_waktu = "Semua Data Koleksi"; }
        }

        $data = $query->latest()->get();
        
        return view('pj.laporan.master_cetak', [
            'data' => $data,
            'jenis' => $jenis,
            'judul_laporan' => $judul,
            'keterangan_waktu' => $keterangan_waktu
        ]);
    }

    // Bypass rute cetak bawaan yang beralih fungsi ke master export
    public function cetakBerita() { return redirect()->back(); }
    public function cetakGaleri() { return redirect()->back(); }
}