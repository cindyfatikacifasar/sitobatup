<?php

namespace App\Http\Controllers\Pj;

use App\Http\Controllers\Controller;
use App\Models\TanamanObat;
use App\Models\Kategori;
use App\Models\Saran;
use App\Models\Pengunjung;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTanaman    = TanamanObat::count();
        $totalKategori   = Kategori::count();
        $saranBelumBaca  = Saran::where('is_read', false)->where('pengirim', 'pengunjung')->count();
        $pengunjungHari  = Pengunjung::where('tanggal', Carbon::today())->count();
        $pengunjungBulan = Pengunjung::whereMonth('tanggal', Carbon::now()->month)->count();

        // Grafik pengunjung 14 hari
        $grafik = [];
        for ($i = 13; $i >= 0; $i--) {
            $tgl    = Carbon::today()->subDays($i);
            $grafik[] = [
                'tanggal' => $tgl->format('d/m'),
                'jumlah'  => Pengunjung::where('tanggal', $tgl)->count(),
            ];
        }

        $tanamanPopuler = TanamanObat::orderBy('views', 'desc')->take(5)->get();
        $saranTerbaru   = Saran::where('pengirim', 'pengunjung')->orderBy('created_at', 'desc')->take(5)->get();

        return view('pj.dashboard', compact(
            'totalTanaman','totalKategori','saranBelumBaca',
            'pengunjungHari','pengunjungBulan','grafik','tanamanPopuler','saranTerbaru'
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
}