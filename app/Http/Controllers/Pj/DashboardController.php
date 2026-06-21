<?php

namespace App\Http\Controllers\Pj;

use App\Http\Controllers\Controller;
use App\Models\TanamanObat;
use App\Models\Kategori;
use App\Models\Ulasan;
use App\Models\Pengunjung;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data hitungan asli dari database agar sinkron dengan admin
        $totalTanaman = \App\Models\TanamanObat::count();
        $totalKategori = \App\Models\Kategori::count();
        $totalBerita = \App\Models\Berita::count();
        
        // Jika galeri kamu dihitung berdasarkan jumlah foto, gunakan model Galeri. Jika berdasarkan album, gunakan Album.
        $totalGaleri = \App\Models\Galeri::count(); 
        
        // ⚡ PERBAIKAN SINKRONISASI TOTAL ULASAN: Menghitung total murni dari seluruh baris tabel ulasan tanpa filter is_read
        $ulasanBelumBaca = \App\Models\Ulasan::count();
        
        $totalPengunjung = \App\Models\Pengunjung::count(); // Sesuai nama table counter pengunjungmu
        $pengunjungHari = \App\Models\Pengunjung::whereDate('created_at', today())->count();
    
        // 2. Grafik Pengunjung disinkronkan menjadi 30 hari terakhir (Perbaikan Strict Mode)
        $grafikData = \App\Models\Pengunjung::selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupByRaw('DATE(created_at)')     // ⚡ PERBAIKAN: Menggunakan groupByRaw agar lolos validasi strict database MySQL
            ->orderByRaw('DATE(created_at) ASC') // ⚡ PERBAIKAN: Menggunakan orderByRaw agar pengurutan linear waktu sesuai
            ->get();
    
        $grafik = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $found = $grafikData->firstWhere('tanggal', $date);
            $grafik[] = [
                'tanggal' => now()->subDays($i)->format('d/m'),
                'jumlah' => $found ? $found->jumlah : 0
            ];
        }
    
        $tanamanPopuler = \App\Models\TanamanObat::orderBy('views', 'desc')->take(5)->get();
    
        return view('pj.dashboard', compact(
            'totalTanaman', 'totalKategori', 'totalBerita', 'totalGaleri', 
            'ulasanBelumBaca', 'totalPengunjung', 'pengunjungHari', 'grafik', 'tanamanPopuler'
        ));
    }

    public function profil()
    {
        $user = auth()->user();
        return view('pj.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|min:6|confirmed',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) Storage::disk('public')->delete($user->foto);
            $user->foto = $request->file('foto')->store('users', 'public');
        }

        $user->save();
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // ==========================================
    // KHUSUS HALAMAN PENANGGUNG JAWAB (PJ)
    // ==========================================

    // 1. LAPORAN TANAMAN OBAT (READ-ONLY)
    public function pjTanaman()
    {
        $tanamans = \App\Models\Tanaman::latest()->paginate(10);
        return view('pj.laporan_tanaman', compact('tanamans'));
    }

    // 2. LAPORAN GALERI DOKUMENTASI
    public function pjGaleri()
    {
        $albums = \App\Models\Album::withCount('galeris')->latest()->get();
        return view('pj.laporan_galeri', compact('albums'));
    }

    // 3. LAPORAN BERITA & ARTIKEL
    public function pjBerita()
    {
        $beritas = \App\Models\Berita::latest()->paginate(10);
        return view('pj.laporan_berita', compact('beritas'));
    }

    // 4. LAPORAN SARAN MASUK
    public function pjUlasan()
    {
        $ulasans = \App\Models\Ulasan::where('pengirim', 'pengunjung')->latest()->paginate(10);
        return view('pj.ulasan', compact('ulasans'));
    }

    // 5. AKSI PJ: TANDAI SARAN SUDAH DIBACA
    public function pjBacaUlasan($id)
    {
        $ulasan = \App\Models\Ulasan::findOrFail($id);
        $ulasan->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Ulasan dari pengunjung berhasil ditandai telah ditinjau.');
    }
}