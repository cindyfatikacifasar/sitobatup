<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::withCount('galeris')->latest()->paginate(10);
        return view('admin.album.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.album.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'nama_album' => 'required|unique:albums,nama_album'
        ]);
    
        // 2. Simpan (Slug akan otomatis dibuat kalau Sindi pakai boot() di Model)
        \App\Models\Album::create([
            'nama_album' => $request->nama_album
        ]);
    
        // 3. Redirect kembali ke index
        return redirect()->route('admin.album.index')->with('success', 'Album berhasil ditambah!');
    }
    public function edit(Album $album)
    {
        return view('admin.album.edit', compact('album'));
    }

    public function update(Request $request, $id)
    {
        $album = \App\Models\Album::findOrFail($id);
        
        $request->validate([
            'nama_album' => 'required|string|max:255|unique:albums,nama_album,'.$id,
        ]);
    
        $album->update([
            'nama_album' => $request->nama_album
        ]);
    
        return redirect()->back()->with('success', 'Nama album berhasil diubah!');
    }

    public function destroy(Album $album)
    {
        // Jika album dihapus, foto di dalamnya juga akan terhapus karena 'cascade' di database
        $album->delete();
        return redirect()->route('admin.album.index')->with('success', 'Album berhasil dihapus!');
    }

    // Fungsi untuk melihat isi foto di dalam album tertentu
    public function show(Album $album)
    {
        $galeris = $album->galeris()->latest()->get();
        return view('admin.album.show', compact('album', 'galeris'));
    }
}