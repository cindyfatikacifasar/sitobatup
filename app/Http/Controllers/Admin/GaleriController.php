<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        // Mengambil semua album beserta foto pertama di dalamnya sebagai cover
        $albums = \App\Models\Album::with('galeris')->latest()->paginate(12);
        return view('admin.galeri.index', compact('albums'));
    }

    public function create()
    {
        // Sudah tidak ambil data album lagi
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        // Menambah durasi upload agar tidak timeout saat upload banyak foto
        set_time_limit(300);

        $request->validate([
            'judul'     => 'required|string|max:200',
            'tanggal'   => 'required|date',
            'foto'      => 'required',
            'foto.*'    => 'mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:20480', // Support video sampai 20MB
        ]);

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                // Proses simpan file ke folder storage/app/public/galeri
                $path = $file->store('galeri', 'public');

                // Simpan ke database satu per satu
                Galeri::create([
                    'judul'     => $request->judul,
                    'tanggal'   => $request->tanggal,
                    'deskripsi' => $request->deskripsi,
                    'foto'      => $path,
                ]);
            }
        }

        return redirect()->route('admin.galeri.index')->with('success', 'Foto-foto berhasil diunggah!');
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul'     => 'required|string|max:200',
            'tanggal'   => 'required|date',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data = $request->only(['judul', 'tanggal', 'deskripsi']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($galeri->foto) Storage::disk('public')->delete($galeri->foto);
            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('galeri', 'public');
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        if ($galeri->foto) Storage::disk('public')->delete($galeri->foto);
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil dihapus.');
    }

    public function show(Galeri $galeri) 
    { 
        return redirect()->route('admin.galeri.index'); 
    }
}