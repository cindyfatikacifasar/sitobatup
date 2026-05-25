<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{TanamanObat, Kategori, Galeri, Berita, Saran, Pengunjung};
use Illuminate\Support\Facades\{Http, DB};

class PublicController extends Controller
{
    public function beranda()
    {
        // 1. Ambil data konten utama
        $totalTanaman    = TanamanObat::count();
        $totalKategori   = Kategori::count();
        $tanamanPopuler  = TanamanObat::orderBy('views', 'desc')->take(6)->get();
        $beritaCarousel  = Berita::where('is_published', true)->where('is_popular', true)->latest()->get();
        $beritaTerbaru   = Berita::where('is_published', true)->orderBy('created_at', 'desc')->take(3)->get();
        $galeriTerbaru   = Galeri::orderBy('tanggal', 'desc')->take(6)->get();

        // 2. Logika Deteksi Negara
        $ip = request()->ip();
        if ($ip == '127.0.0.1' || $ip == '::1') $ip = '103.111.140.10'; 
        
        $negara = 'Indonesia'; 
        
        try {
            $response = Http::timeout(2)->get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                $negara = $response->json()['country'] ?? 'Indonesia';
            }
        } catch (\Exception $e) { }

        // 3. Simpan data pengunjung
        try {
            Pengunjung::create([
                'ip_address' => $ip,
                'asal_negara' => $negara,
                'user_agent' => request()->userAgent(),
                'tanggal' => now()
            ]);
        } catch (\Exception $e) { }

        // 4. Ambil statistik negara
        $statsNegara = Pengunjung::select('asal_negara', DB::raw('count(*) as total'))
                        ->groupBy('asal_negara')->orderBy('total', 'desc')->get();

        return view('public.beranda', compact(
            'totalTanaman', 'totalKategori', 'tanamanPopuler', 
            'beritaTerbaru', 'galeriTerbaru', 'beritaCarousel', 'statsNegara'
        ));
    }

    public function katalog(Request $request)
    {
        $query = TanamanObat::with('kategoris');

        // Search Nama/Ilmiah
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_ilmiah', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->whereHas('kategoris', function($q) use ($request) {
                $q->where('kategoris.id', $request->kategori);
            });
        }

        // Filter Bagian
        if ($request->filled('bagian')) {
            $query->where('bagian_digunakan', 'like', '%' . $request->bagian . '%');
        }

        $tanaman = $query->orderBy('nama')->paginate(12)->withQueryString();
        $kategoris = Kategori::all();

        // Ambil list bagian unik untuk filter
        $bagians = TanamanObat::whereNotNull('bagian_digunakan')
                    ->distinct()
                    ->pluck('bagian_digunakan');

        return view('public.katalog', compact('tanaman', 'kategoris', 'bagians'));
    }

    public function detailTanaman($slug)
    {
        // 1. Ambil data tanaman utama beserta kategorinya
        $tanaman = TanamanObat::with('kategoris')->where('slug', $slug)->firstOrFail();
    
        // 2. Ambil ID kategori dari tanaman ini
        $kategoriIds = $tanaman->kategoris->pluck('id');
    
        // 3. Cari tanaman lain dengan kategori yang sama (Tanaman Terkait)
        // Variabel ini WAJIB ada agar error di image_b13581.png baris 141 hilang
        $tanamanTerkait = TanamanObat::whereHas('kategoris', function($q) use ($kategoriIds) {
            $q->whereIn('kategoris.id', $kategoriIds);
        })
        ->where('id', '!=', $tanaman->id) // Supaya tanaman yang sedang dibuka tidak muncul lagi
        ->take(4) // Ambil 4 saja untuk rekomendasi di bawah
        ->get();
    
        // 4. Kirim ke View. Pastikan nama variabel di compact sama dengan di View
        return view('public.detail-tanaman', compact('tanaman', 'tanamanTerkait'));
    }

    public function galeri(Request $request)
    {
        // 1. Mulai kueri Album lengkap dengan hitungan item dan data foto di dalamnya
        $query = \App\Models\Album::with(['galeris'])->withCount('galeris');

        // 2. Logika Saringan Kotak Pencarian (Biar fitur "Cari Album" di blade kamu berfungsi!)
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where('nama_album', 'like', '%' . $cari . '%')
                  ->orWhere('deskripsi', 'like', '%' . $cari . '%');
        } else {
            $cari = null;
        }

        // 3. Ambil data album menggunakan paginate agar link halaman di bawahnya aktif
        $albums = $query->latest()->paginate(9);

        // 4. Lempar data secara utuh ke file blade kamu
        return view('public.galeri', compact('albums', 'cari'));
    }
    
    public function showAlbum($id)
    {
        // Mengambil data satu album tertentu beserta seluruh foto didalamnya
        $album = \App\Models\Album::with('galeris')->findOrFail($id);
        return view('public.galeri_detail', compact('album'));
    }

    public function berita(Request $request)
    {
        $query = Berita::where('is_published', true);
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        $beritas = $query->orderBy('created_at', 'desc')->paginate(9)->withQueryString();
        return view('public.berita', compact('beritas'));
    }

    public function detailBerita(string $slug)
    {
        $berita = Berita::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $berita->increment('views');

        // Menambahkan data berita terkait agar detail-berita.blade tidak error
        $beritaTerkait = Berita::where('is_published', true)
                            ->where('id', '!=', $berita->id)
                            ->latest()
                            ->take(4)
                            ->get();

        return view('public.detail-berita', compact('berita', 'beritaTerkait'));
    }

    public function saran()
    {
        // Ambil ulasan yang hanya di-approve oleh admin untuk ditampilkan di halaman depan
        $reviewsTampil = \App\Models\Saran::where('is_displayed', 1)
                            ->orderBy('created_at', 'desc')
                            ->get();
    
        return view('public.saran', compact('reviewsTampil'));
    }
    
    public function kirimSaran(Request $request)
    {
        // Validasi input dari pengunjung
        $request->validate([
            'nama'    => 'required|string|max:100',
            'kontak'  => 'nullable|string|max:50', // Ubah jadi nullable (opsional)
            'pesan'   => 'required|string',
            'rating'  => 'required|integer|min:1|max:5', // Validasi rating bintang wajib diisi
        ]);
    
        // Simpan ke database
        \App\Models\Saran::create([
            'nama'         => $request->nama,
            'kontak'       => $request->kontak,
            'pesan'        => $request->pesan,
            'rating'       => $request->rating,
            'pengirim'     => 'pengunjung', // Default pengirim via form publik
            'is_read'      => 0,            // Status belum dibaca oleh admin
            'is_displayed' => 0,            // Default 0 (harus melewati moderasi admin dulu)
        ]);
    
        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda telah dikirim dan akan ditampilkan setelah ditinjau oleh pihak pengelola.');
    }

    public function scanQr(string $slug) { return redirect()->route('tanaman.detail', $slug); }
}