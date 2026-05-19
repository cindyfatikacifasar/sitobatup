<?php
// =============================================
// app/Http/Controllers/Admin/KategoriController.php
// =============================================
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        // Jika ada request ?show=all, ambil semua data tanpa paginasi
        if ($request->get('show') === 'all') {
            // Kita pakai paginate dengan jumlah total data agar link pagination tidak error di Blade
            $totalData = \App\Models\Kategori::count();
            $kategoris = \App\Models\Kategori::latest()->paginate($totalData ?: 10);
        } else {
            // Standar bawaan dipotong per 15 data
            $kategoris = \App\Models\Kategori::latest()->paginate(15);
        }
    
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori',
        ]);
    
        \App\Models\Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);
    
        // Kembali ke index dengan toast/notifikasi
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori'      => 'required|string|max:100|unique:kategoris,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update([
            'nama_kategori'      => $request->nama_kategori,
            'slug'      => Str::slug($request->nama_kategori),
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->tanamanObats()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki tanaman obat.');
        }
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function show(Kategori $kategori) { return redirect()->route('admin.kategori.index'); }
}