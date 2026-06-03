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
        // 1. VALIDASI: Menyesuaikan nama field sesuai form create baru
        $request->validate([
            'judul'           => 'required|string|max:255',
            'penulis'           => 'required|string|max:100',
            'isi_berita'      => 'required', // Menyesuaikan name="isi_berita" dari CKEditor
            'tanggal_publish' => 'required|date',
            'foto_cover'      => 'required|image|mimes:jpg,jpeg,png|max:3072', // Menyesuaikan name="foto_cover"
        ]);

        // 2. AMBIL DATA & GENERATE SLUG
        $data = [
            'judul'           => $request->judul,
            'slug'            => \Illuminate\Support\Str::slug($request->judul) . '-' . time(),
            'isi'             => $request->isi_berita, // Memetakan isi_berita ke kolom 'isi' di database
            'penulis'         => auth()->user()->nama ?? 'Admin', // Mengambil nama user yang login otomatis jika field form tidak ada
            'tanggal_publish' => $request->tanggal_publish,
            'is_published'    => true, // Otomatis true karena langsung diterbitkan
            'is_carousel'     => $request->has('is_carousel') ? 1 : 0, // Mengisi kolom carousel jika dicentang
            'is_popular'      => $request->has('is_carousel') ? 1 : 0, // Backup jika database kamu masih memakai nama 'is_popular'
        ];

        // 3. PROSES UPLOAD FOTO COVER
        if ($request->hasFile('foto_cover')) {
            // Menyimpan file ke folder storage/app/public/berita
            $data['foto'] = $request->file('foto_cover')->store('berita', 'public');
        }

        // 4. SIMPAN KE DATABASE
        \App\Models\Berita::create($data);

        // 5. REDIRECT KEMBALI
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