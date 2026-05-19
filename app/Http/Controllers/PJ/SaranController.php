<?php

namespace App\Http\Controllers\Pj;

use App\Http\Controllers\Controller;
use App\Models\Saran;
use Illuminate\Http\Request;

class SaranController extends Controller
{
    public function index(Request $request)
    {
        // 1. Filter awal: Hanya mengambil saran dari pengunjung
        $query = Saran::where('pengirim', 'pengunjung');

        // 2. Filter bawaan: Berdasarkan status dibaca / belum dibaca
        if ($request->filled('status')) {
            $query->where('is_read', $request->status === 'dibaca');
        }

        // 3. TAMBAHAN FILTER: Berdasarkan rentang tanggal kalender kustom
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [
                $request->tanggal_mulai . ' 00:00:00', 
                $request->tanggal_selesai . ' 23:59:59'
            ]);
        }

        // 4. Ambil data dengan mempertahankan parameter filter di URL pagination
        $sarans      = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $belumDibaca = Saran::where('pengirim', 'pengunjung')->where('is_read', false)->count();

        return view('pj.saran.index', compact('sarans', 'belumDibaca'));
    }

    public function show(int $id)
    {
        $saran = Saran::findOrFail($id);
        if (!$saran->is_read) {
            $saran->update(['is_read' => true]);
        }
        return view('pj.saran.show', compact('saran'));
    }

    public function create()
    {
        return view('pj.saran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:100',
            'pesan' => 'required|string|min:10|max:1000',
        ], [
            'nama.required'  => 'Nama wajib diisi.',
            'pesan.required' => 'Isi saran wajib diisi.',
            'pesan.min'      => 'Saran minimal 10 karakter.',
        ]);

        Saran::create([
            'nama'     => $request->nama,
            'kontak'   => auth()->user()->email,
            'pesan'    => $request->pesan,
            'pengirim' => 'penanggungjawab',
            'is_read'  => false,
        ]);

        return redirect()->route('pj.saran.index')->with('success', 'Saran berhasil dikirim ke Admin.');
    }

    public function destroy(int $id)
    {
        $saran = Saran::findOrFail($id);
        $saran->delete();

        return redirect()->route('pj.saran.index')->with('success', 'Saran berhasil dihapus.');
    }
}