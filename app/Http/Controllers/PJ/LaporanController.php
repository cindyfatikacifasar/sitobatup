<?php

namespace App\Http\Controllers\Pj;

use App\Http\Controllers\Controller;
use App\Models\TanamanObat;
use App\Models\Kategori;
use App\Models\Pengunjung;
use App\Models\Berita;
use App\Models\Galeri;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // --- LAPORAN TANAMAN (Kode Lama Kamu) ---
    public function tanaman(Request $request)
    {
        $query = TanamanObat::with('kategoris');
    
        if ($request->filled('kategori')) {
            $query->whereHas('kategoris', function($q) use ($request) {
                $q->where('kategoris.id', $request->kategori);
            });
        }
        
        $tanaman   = $query->orderBy('nama')->paginate(20)->withQueryString();
        $kategoris = Kategori::all();
    
        $stats = [
            'total'        => TanamanObat::count(),
            // TAMBAHKAN BARIS INI:
            'tersedia'     => TanamanObat::where('status', 'tersedia')->count(), 
            'per_kategori' => Kategori::withCount('tanamanObats')->get(),
        ];
    
        return view('pj.laporan.tanaman', compact('tanaman','kategoris','stats'));
    }

    // --- LAPORAN BERITA (Baru) ---
    public function berita()
    {
        $beritas = Berita::orderBy('created_at', 'desc')->get();
        return view('pj.laporan.berita', compact('beritas'));
    }

    public function cetakBerita()
    {
        $beritas = Berita::orderBy('created_at', 'desc')->get();
        $tgl = now()->format('d/m/Y');
        return view('pj.laporan.cetak_berita', compact('beritas', 'tgl'));
    }

    // --- LAPORAN GALERI (Baru) ---
    public function galeri()
    {
        $galeris = Galeri::orderBy('tanggal', 'desc')->get();
        return view('pj.laporan.galeri', compact('galeris'));
    }

    public function cetakGaleri()
    {
        $galeris = Galeri::orderBy('tanggal', 'desc')->get();
        $tgl = now()->format('d/m/Y');
        return view('pj.laporan.cetak_galeri', compact('galeris', 'tgl'));
    }

    // --- LAPORAN PENGUNJUNG (Kode Lama Kamu) ---
    public function pengunjung()
    {
        $hari   = Pengunjung::where('tanggal', Carbon::today())->count();
        $minggu = Pengunjung::whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $bulan  = Pengunjung::whereMonth('tanggal', Carbon::now()->month)->count();
        $total  = Pengunjung::count();

        $grafik = [];
        for ($i = 29; $i >= 0; $i--) {
            $tgl = Carbon::today()->subDays($i);
            $grafik[] = [
                'tanggal' => $tgl->format('d/m'),
                'jumlah'  => Pengunjung::where('tanggal', $tgl)->count(),
            ];
        }

        return view('pj.laporan.pengunjung', compact('hari','minggu','bulan','total','grafik'));
    }

    public function export(Request $request)
    {
        $tanaman = TanamanObat::with('kategoris')->orderBy('nama')->get();
        $tgl     = now()->format('Y-m-d');
        return response()->view('pj.laporan.export', compact('tanaman', 'tgl'))
            ->header('Content-Type', 'text/html');
    }
}