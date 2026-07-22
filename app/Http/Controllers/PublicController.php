<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TanamanObat;
use App\Models\Kategori;
use App\Models\Galeri;
use App\Models\Berita;
use App\Models\Ulasan;
use App\Models\Pengunjung;
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

        // 2. Logika Deteksi Lokasi & Perangkat Aman (Revisi Privasi Sindi)
        $ip = request()->ip();
        if ($ip == '127.0.0.1' || $ip == '::1') {
            $ip = '103.111.140.10'; // IP Kampus/Pekanbaru untuk simulasi localhost
        } 
        
        $daerah = 'Riau';
        $negara = 'Indonesia'; 
        $kodeNegara = 'ID'; // ⚡ TAMBAHAN: dipakai untuk generate icon bendera
        
        try {
            $response = Http::timeout(2)->get("http://ip-api.com/json/{$ip}");
            if ($response->successful() && $response->json()['status'] === 'success') {
                $dataApi = $response->json();
                // Menggabungkan nama Kota dan Provinsi (Contoh: Pekanbaru, Riau)
                $daerah  = ($dataApi['city'] ?? 'Pekanbaru') . ', ' . ($dataApi['regionName'] ?? 'Riau');
                $negara  = $dataApi['country'] ?? 'Indonesia';
                $kodeNegara = $dataApi['countryCode'] ?? 'ID'; // ⚡ TAMBAHAN
            }
        } catch (\Exception $e) { }

        // Filter tipe perangkat makro agar lebih aman dan menjaga privasi pengguna
        $rawAgent = request()->userAgent();
        if (preg_match('/(android|iphone|ipad|mobile)/i', $rawAgent)) {
            $tipePerangkat = 'Mobile / HP';
        } else {
            $tipePerangkat = 'Desktop / Laptop';
        }

        // 3. Simpan data pengunjung (Sesuai Struktur Baru)
        try {
            Pengunjung::create([
                'ip_address'  => $daerah,          // Menyimpan data daerah (Kota, Provinsi)
                'asal_negara' => $negara,          // Menyimpan nama negara dinamis
                'kode_negara' => $kodeNegara,       // ⚡ TAMBAHAN: untuk generate icon bendera
                'user_agent'  => $tipePerangkat,   // Menyimpan tipe makro yang aman
                'tanggal'     => now()
            ]);
        } catch (\Exception $e) { }

        // 4. Ambil statistik negara
        $statsNegara = Pengunjung::select('asal_negara', 'kode_negara', DB::raw('count(*) as total'))
                        ->groupBy('asal_negara', 'kode_negara')->orderBy('total', 'desc')->get();

        // ⚡ TAMBAHAN: tempel icon bendera ke setiap baris statistik negara
        $statsNegara = $statsNegara->map(function ($item) {
            $item->bendera = $this->kodeKeBendera($item->kode_negara);
            return $item;
        });

        // ⚡ TAMBAHAN: total keseluruhan pengunjung yang sudah pernah mengakses web
        $totalPengunjung = Pengunjung::count();

        return view('public.beranda', compact(
            'totalTanaman', 'totalKategori', 'tanamanPopuler', 
            'beritaTerbaru', 'galeriTerbaru', 'beritaCarousel', 'statsNegara', 'totalPengunjung'
        ));
    }

    // ⚡ TAMBAHAN: helper konversi kode negara (ISO 2 huruf, mis. "ID") jadi emoji bendera
    private function kodeKeBendera($kode)
    {
        $kode = strtoupper($kode ?? 'ID');
        if (strlen($kode) !== 2) return '🏳️';
        $emoji = '';
        foreach (str_split($kode) as $char) {
            $emoji .= mb_chr(127397 + ord($char), 'UTF-8');
        }
        return $emoji;
    }

    public function katalog(Request $request)
    {
        $query = TanamanObat::with('kategoris');

        // Pencarian multi-kolom Berdasarkan Nama, Nama Ilmiah, dan Khasiat
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_ilmiah', 'like', '%' . $request->search . '%')
                  ->orWhere('khasiat', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Kategori (Tetap dipertahankan)
        if ($request->filled('kategori')) {
            $query->whereHas('kategoris', function($q) use ($request) {
                $q->where('kategoris.id', $request->kategori);
            });
        }

        // ⚡ REVISI SINDI: Logika Filter Bagian yang Digunakan Sudah Dihapus Bersih dari Sini

        $tanaman = $query->orderBy('nama')->paginate(12)->withQueryString();
        $kategoris = Kategori::all();

        // ⚡ REVISI SINDI: Variabel list bagian unik ($bagians) sudah dihapus agar tidak membebani memori server

        return view('public.katalog', compact('tanaman', 'kategoris'));
    }

    public function detailTanaman($slug)
    {
        // 1. Ambil data tanaman utama beserta kategorinya
        $tanaman = TanamanObat::with('kategoris')->where('slug', $slug)->firstOrFail();
        
        // ⚡ PERBAIKAN UTAMA: Tambahkan baris ini agar views bertambah setiap kali detail dibuka!
        $tanaman->increment('views'); 
    
        // 2. Ambil ID kategori dari tanaman ini
        $kategoriIds = $tanaman->kategoris->pluck('id');
    
        // 3. Cari tanaman lain dengan kategori yang sama (Tanaman Terkait)
        $tanamanTerkait = TanamanObat::whereHas('kategoris', function($q) use ($kategoriIds) {
            $q->whereIn('kategoris.id', $kategoriIds);
        })
        ->where('id', '!=', $tanaman->id)
        ->take(4)
        ->get();
    
        // 4. Kirim ke View
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

        // =======================================================================
        // ⚡ REVISI LOGIKA AUTO-COVER: Memisahkan album Tanaman Obat dengan album Manual biasa
        // =======================================================================
        foreach ($albums as $album) {
            if (strtolower($album->nama_album) == 'tanaman obat') {
                // Konsep Khusus: Pinjam otomatis dari foto TanamanObat paling baru yang diinput admin
                $tanamanFoto = \App\Models\TanamanObat::whereNotNull('foto')
                                ->where('foto', '!=', '')
                                ->latest()
                                ->first();
                $album->foto_sampul = $tanamanFoto ? \Storage::url($tanamanFoto->foto) : null;
            } else {
                // Album Manual Biasa: Gunakan foto pertama dari galeri manualnya (jika ada)
                if ($album->galeris_count > 0 && $album->galeris->first()) {
                    $album->foto_sampul = \Storage::url($album->galeris->first()->foto);
                } else {
                    $album->foto_sampul = null; // Biarkan null jika benar-benar album manual yang masih kosong
                }
            }
        }
        // =======================================================================

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

    public function ulasan()
    {
        // Ambil ulasan yang hanya di-approve oleh admin untuk ditampilkan di halaman depan
        $reviewsTampil = \App\Models\Ulasan::where('is_displayed', 1)
                            ->orderBy('created_at', 'desc')
                            ->get();
    
        return view('public.ulasan', compact('reviewsTampil'));
    }
    
    public function kirimUlasan(Request $request)
    {
        // Validasi input dari pengunjung
        $request->validate([
            'nama'    => 'required|string|max:100',
            'kontak'  => 'nullable|string|max:50', 
            'pesan'   => 'required|string',
            'rating'  => 'required|integer|min:1|max:5', 
        ]);
    
        // Simpan ke database (Baris 'pengirim' sudah dihapus bersih agar tidak memicu error column not found)
        \App\Models\Ulasan::create([
            'nama'         => $request->nama,
            'kontak'       => $request->kontak,
            'pesan'        => $request->pesan,
            'rating'       => $request->rating,
            'is_read'      => 0,            
            'is_displayed' => 0,            
        ]);
    
        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda telah dikirim dan akan ditampilkan setelah ditinjau oleh pihak pengelola.');
    }

    public function scanQr(string $slug) { return redirect()->route('tanaman.detail', $slug); }
}