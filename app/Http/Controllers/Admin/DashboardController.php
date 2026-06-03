<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TanamanObat;
use App\Models\Kategori;
use App\Models\Berita;
use App\Models\Galeri;
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
        // Statistik utama untuk Dashboard sesuai Bab 3 Proposal
        $totalTanaman    = TanamanObat::count();
        $totalKategori   = Kategori::count();
        $totalBerita     = Berita::count();
        $totalGaleri     = Galeri::count();
        
        // PERBAIKAN: Menghapus filter 'pengirim' karena kolomnya tidak ada di database
        $ulasanBelumBaca  = Ulasan::where('is_read', false)->count();
        
        // Statistik Pengunjung harian sesuai tracker SITOBAT
        $pengunjungHari  = Pengunjung::where('tanggal', Carbon::today())->count();

        // Grafik pengunjung 30 hari terakhir untuk visualisasi dashboard
        $grafik = [];
        for ($i = 29; $i >= 0; $i--) {
            $tanggal  = Carbon::today()->subDays($i);
            $grafik[] = [
                'tanggal' => $tanggal->format('d/m'),
                'jumlah'  => Pengunjung::where('tanggal', $tanggal->toDateString())->count(),
            ];
        }

        // Data tanaman terpopuler berdasarkan jumlah views [cite: 653]
        $tanamanPopuler = TanamanObat::orderBy('views', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalTanaman','totalKategori','totalBerita','totalGaleri',
            'ulasanBelumBaca','pengunjungHari','grafik','tanamanPopuler'
        ));
    }

    public function profil()
    {
        $user = auth()->user();
        return view('admin.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        // Validasi input profil sesuai model User (name, email, phone, password, foto) [cite: 554]
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
            // Hapus foto lama jika ada sebelum mengunggah yang baru
            if ($user->foto) Storage::disk('public')->delete($user->foto);
            $user->foto = $request->file('foto')->store('users', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}