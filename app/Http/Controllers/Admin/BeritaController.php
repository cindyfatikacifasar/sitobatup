<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::query();
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        $beritas = $query->orderBy('created_at', 'desc')->paginate(12);
        return view('admin.berita.index', compact('beritas'));
    }

    public function create() { return view('admin.berita.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'isi'      => 'required',
            'penulis'  => 'required',
            'foto'     => 'required|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        $data = $request->except(['foto', '_token']);
        $data['slug'] = Str::slug($request->judul) . '-' . time();
        $data['is_published'] = $request->has('is_published');
        $data['is_popular'] = $request->has('is_popular'); 

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('berita', 'public');
        }

        Berita::create($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diterbitkan!');
    }

    public function show(Berita $berita) { return view('admin.berita.show', compact('berita')); }

    public function edit(Berita $berita) { return view('admin.berita.edit', compact('berita')); }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'isi'      => 'required',
            'penulis'  => 'required',
            'foto'     => 'nullable|image|max:3072',
        ]);

        $data = $request->except(['foto', '_token', '_method']);
        $data['is_published'] = $request->has('is_published');
        $data['is_popular'] = $request->has('is_popular'); 

        if ($request->hasFile('foto')) {
            if ($berita->foto) Storage::disk('public')->delete($berita->foto);
            $data['foto'] = $request->file('foto')->store('berita', 'public');
        }

        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita diperbarui!');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->foto) Storage::disk('public')->delete($berita->foto);
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita dihapus!');
    }
}