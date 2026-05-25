<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Saran;
use Illuminate\Http\Request;

class SaranController extends Controller
{
    public function index(Request $request)
    {
        // Mulai kueri dari model Saran
        $query = \App\Models\Saran::query();

        // JIKA USER MENGISI TANGGAL MULAI DAN SELESAI PADA KALENDER
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [
                $request->tanggal_mulai . ' 00:00:00', 
                $request->tanggal_selesai . ' 23:59:59'
            ]);
        }

        // Ambil data saran yang masuk dengan batas 10 per halaman
        $sarans = $query->latest()->paginate(10);

        // FIX SAKTI: Diubah ke view admin agar tidak nyasar ke halaman PJ lagi!
        return view('admin.saran.index', compact('sarans')); 
    }

    public function show(int $id)
    {
        $saran = Saran::findOrFail($id);
        if (!$saran->is_read) {
            $saran->update(['is_read' => true]);
        }
        return view('admin.saran.show', compact('saran'));
    }

    public function tandaiBaca(int $id)
    {
        Saran::findOrFail($id)->update(['is_read' => true]);
        return back()->with('success', 'Saran ditandai sebagai sudah dibaca.');
    }

    public function destroy(int $id)
    {
        Saran::findOrFail($id)->delete();
        return redirect()->route('admin.saran.index')->with('success', 'Saran berhasil dihapus.');
    }

    public function toggleDisplay($id)
    {
        // Cari data ulasan berdasarkan ID
        $saran = \App\Models\Saran::findOrFail($id);
        
        // Balikkan nilai status (jika 0 jadi 1, jika 1 jadi 0)
        $saran->is_displayed = !$saran->is_displayed;
        $saran->save();

        // Berikan pesan notifikasi sukses yang dinamis
        $statusPesan = $saran->is_displayed ? 'ditampilkan di halaman publik web.' : 'disembunyikan dari halaman publik web.';
        
        return redirect()->back()->with('success', 'Ulasan dari ' . $saran->nama . ' berhasil ' . $statusPesan);
    }
}