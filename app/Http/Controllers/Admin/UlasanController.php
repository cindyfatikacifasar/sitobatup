<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index(Request $request)
    {
        // Mulai kueri dari model Saran
        $query = \App\Models\Ulasan::query();

        // JIKA USER MENGISI TANGGAL MULAI DAN SELESAI PADA KALENDER
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [
                $request->tanggal_mulai . ' 00:00:00', 
                $request->tanggal_selesai . ' 23:59:59'
            ]);
        }

        // Ambil data saran yang masuk dengan batas 10 per halaman
        $ulasans = $query->latest()->paginate(10);

        // FIX SAKTI: Diubah ke view admin agar tidak nyasar ke halaman PJ lagi!
        return view('admin.ulasan.index', compact('ulasans')); 
    }

    public function show(int $id)
    {
        $ulasan = Ulasan::findOrFail($id);
        if (!$ulasan->is_read) {
            $ulasan->update(['is_read' => true]);
        }
        return view('admin.ulasan.show', compact('ulasan'));
    }

    public function tandaiBaca(int $id)
    {
        Ulasan::findOrFail($id)->update(['is_read' => true]);
        return back()->with('success', 'Ulasan ditandai sebagai sudah dibaca.');
    }

    public function destroy(int $id)
    {
        Ulasan::findOrFail($id)->delete();
        return redirect()->route('admin.ulasan.index')->with('success', 'Ulasan berhasil dihapus.');
    }

    public function toggleDisplay($id)
    {
        // Cari data ulasan berdasarkan ID
        $ulasan = \App\Models\Ulasan::findOrFail($id);
        
        // Balikkan nilai status (jika 0 jadi 1, jika 1 jadi 0)
        $ulasan->is_displayed = !$ulasan->is_displayed;
        $ulasan->save();

        // Berikan pesan notifikasi sukses yang dinamis
        $statusPesan = $ulasan->is_displayed ? 'ditampilkan di halaman publik web.' : 'disembunyikan dari halaman publik web.';
        
        return redirect()->back()->with('success', 'Ulasan dari ' . $ulasan->nama . ' berhasil ' . $statusPesan);
    }

    public function readAjax($id)
    {
        $ulasan = \App\Models\Ulasan::findOrFail($id); // Sesuaikan nama model Ulasan kamu
        
        // Ubah status menjadi sudah dibaca (is_read = 1 atau true)
        $ulasan->update(['is_read' => 1]); 

        return response()->json([
            'success' => true,
            'message' => 'Status ulasan berhasil diperbarui.'
        ]);
    }
}