<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    public function index()
    {
        // KUNCI UTAMA: Mengambil data galeri khusus untuk tabel CRUD admin
        $galeris = Galeri::with('album')->latest()->paginate(10);
        
        // DI SINI SALAHNYA KEMARIN! Pastikan manggil view admin, BUKAN public.galeri
        return view('admin.galeri.index', compact('galeris'));
    }

    public function create()
    {
        $albums = Album::all();
        return view('admin.galeri.create', compact('albums'));
    }

    public function store(Request $request)
    {
        // 1. Validasi request input dari form tambah foto galeri
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'foto'     => 'required|array',
            'foto.*'   => 'file|mimes:jpeg,png,jpg,JPEG,PNG,JPG,mp4,mov,avi,MP4,MOV,AVI|max:20480',        ]);
    
        // Ambil data album untuk cadangan nama judul foto
        $album = Album::findOrFail($request->album_id);
    
        // Tentukan judul foto (jika input judul kosong, pakai nama albumnya)
        $judulFoto = $request->judul ?? $album->nama_album;
    
        // 2. Lakukan perulangan jika ada file foto yang di-upload
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $index => $file) {
                // Simpan ke folder storage/public/galeri
                $path = $file->store('galeri', 'public');
    
                // Simpan murni ke database tabel galeris saja (BEBAS EROR COLUMN NOT FOUND)
                Galeri::create([
                    'album_id'   => $request->album_id,
                    'judul'      => $judulFoto,
                    'foto'       => $path,
                    'tanggal'    => now(), // Otomatis mengisi tanggal upload hari ini
                    'keterangan' => $request->keterangan ?? null,
                ]);
            }
        }
    
        return redirect()->route('admin.galeri.index')->with('success', 'Foto-foto berhasil ditambahkan ke dalam galeri album.');
    }
    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        $albums = Album::all();
        return view('admin.galeri.edit', compact('galeri', 'albums'));
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);
        
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'judul'    => 'required|string|max:255',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072', // Boleh kosong jika tidak ingin ganti foto
        ]);

        // Ambil data inputan teks saja terlebih dahulu (Aman dari kebocoran file .tmp)
        $data = $request->only(['album_id', 'judul', 'keterangan']);

        // Jika user mengunggah foto baru saat edit, proses secara aman
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('galeri', 'public');
            $data['foto'] = $path;
        }

        // Update data galeri secara spesifik terisolasi hanya untuk ID ini
        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Data galeri berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil dihapus!');
    }
}