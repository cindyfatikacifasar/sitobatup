<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\TanamanObat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TanamanObatController extends Controller
{
    public function index(Request $request)
    {
        $query = TanamanObat::with('kategoris');

        // Fitur Pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_ilmiah', 'like', '%' . $request->search . '%');
            });
        }
        
        // Fitur Filter Kategori
        if ($request->filled('kategori')) {
            $query->whereHas('kategoris', function($q) use ($request) {
                $q->where('kategoris.id', $request->kategori);
            });
        }



        $tanaman   = $query->orderBy('nama')->paginate(15)->withQueryString();
        $kategoris = Kategori::all();

        return view('admin.tanaman.index', compact('tanaman', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.tanaman.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_ids'        => 'required|array',
            'nama'                => 'required|string|max:150',
            'nama_ilmiah'         => 'required|string|max:150',
            'deskripsi'           => 'required|string',
            'khasiat'             => 'required|string',
            'bagian_digunakan'    => 'nullable|array',
            'asal_usul'           => 'nullable|string|max:100',
            'kolektor'            => 'nullable|string|max:100',
            'is_favourite'        => 'required|boolean',
            'foto'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data = $request->except(['foto', '_token', 'kategori_ids']);
        
        // Handle Checkbox Bagian Digunakan
        if ($request->has('bagian_digunakan')) {
            $data['bagian_digunakan'] = implode(', ', $request->bagian_digunakan);
        }

        // Handle Slug Otomatis
        $slug = Str::slug($request->nama);
        $originalSlug = $slug;
        $i = 1;
        while (TanamanObat::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }
        $data['slug'] = $slug;

        // Handle Upload Foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('tanaman', 'public');
        }

        $tanaman = TanamanObat::create($data);

        // Handle Multi-Kategori (Sync)
        $tanaman->kategoris()->sync($request->kategori_ids);

        // Buat QR Code Otomatis
        $this->buatQrCode($tanaman);

        return redirect()->route('admin.tanaman.index')->with('success', 'Tanaman obat berhasil ditambahkan.');
    }

    public function show($id)
    {
        // 1. Cari data berdasarkan ID, bukan SLUG (karena ini area Admin)
        $tanaman = TanamanObat::with('kategoris')->findOrFail($id); 
    
        // 2. Karena di Admin kita tidak butuh "Tanaman Terkait", kodenya bisa lebih simpel
        // Cukup kirim data tanaman saja ke view folder admin
        return view('admin.tanaman.show', compact('tanaman'));
    }

    public function edit(TanamanObat $tanaman)
    {
        $kategoris = Kategori::all();
        $tanaman->load('kategoris');
        return view('admin.tanaman.edit', compact('tanaman', 'kategoris'));
    }

    public function update(Request $request, TanamanObat $tanaman)
    {
        $request->validate([
            'kategori_ids'        => 'required|array',
            'nama'                => 'required|string|max:150',
            'nama_ilmiah'         => 'required|string|max:150',
            'deskripsi'           => 'required|string',
            'khasiat'             => 'required|string',
            'bagian_digunakan'    => 'nullable|array',
            'is_favourite'        => 'required|boolean',
            'foto'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data = $request->except(['foto', '_token', '_method', 'kategori_ids']);

        // Handle Checkbox Bagian Digunakan
        if ($request->has('bagian_digunakan')) {
            $data['bagian_digunakan'] = implode(', ', $request->bagian_digunakan);
        } else {
            $data['bagian_digunakan'] = null;
        }

        // Update Slug jika nama berubah
        if ($request->nama !== $tanaman->nama) {
            $slug = Str::slug($request->nama);
            $originalSlug = $slug;
            $i = 1;
            while (TanamanObat::where('slug', $slug)->where('id', '!=', $tanaman->id)->exists()) {
                $slug = $originalSlug . '-' . $i++;
            }
            $data['slug'] = $slug;
        }

        if ($request->hasFile('foto')) {
            if ($tanaman->foto) Storage::disk('public')->delete($tanaman->foto);
            $data['foto'] = $request->file('foto')->store('tanaman', 'public');
        }

        $tanaman->update($data);
        
        // Update Multi-Kategori
        $tanaman->kategoris()->sync($request->kategori_ids);

        // Update QR Code jika slug berubah
        if (isset($data['slug'])) {
            $this->buatQrCode($tanaman->fresh());
        }

        return redirect()->route('admin.tanaman.index')->with('success', 'Data tanaman obat berhasil diperbarui.');
    }

    public function destroy(TanamanObat $tanaman)
    {
        if ($tanaman->foto)    Storage::disk('public')->delete($tanaman->foto);
        if ($tanaman->qr_code) Storage::disk('public')->delete($tanaman->qr_code);
        $tanaman->delete();

        return redirect()->route('admin.tanaman.index')->with('success', 'Tanaman obat berhasil dihapus.');
    }

    public function generateQr(int $id)
    {
        $tanaman = TanamanObat::findOrFail($id);
        $this->buatQrCode($tanaman);
        return back()->with('success', 'QR Code berhasil digenerate ulang.');
    }

    public function downloadQr(int $id)
    {
        $tanaman = TanamanObat::findOrFail($id);

        if (!$tanaman->qr_code || !Storage::disk('public')->exists($tanaman->qr_code)) {
            $this->buatQrCode($tanaman);
            $tanaman->refresh();
        }

        $path = Storage::disk('public')->path($tanaman->qr_code);
        return response()->download($path, 'qr-' . $tanaman->slug . '.svg');
    }

    private function buatQrCode(TanamanObat $tanaman): void
    {
        $url  = url('/qr/' . $tanaman->slug);
        $dir  = 'qrcodes';
        $file = $dir . '/qr-' . $tanaman->slug . '.svg';

        Storage::disk('public')->makeDirectory($dir);

        $qrImage = QrCode::format('svg')
            ->size(300)
            ->errorCorrection('H')
            ->generate($url);

        Storage::disk('public')->put($file, $qrImage);

        $tanaman->update(['qr_code' => $file]);
    }
}