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
        // Tetap mempertahankan kueri eager loading relasi jamak 'kategoris' bawaan asli kamu Sindi
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

        // Tetap menggunakan pengurutan nama dan pagination 15 item per halaman
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
        // Validasi pastikan kategori berupa array
        $request->validate([
            'kategori_id' => 'required|array', 
            'nama'        => 'required|string|max:150',
            'nama_ilmiah' => 'required|string|max:150',
            'kolektor'    => 'required|string|max:255',
            'asal_usul'   => 'required|string',
            'deskripsi'   => 'nullable|string',
            'khasiat'     => 'nullable|string',
            'foto_utama'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Proses upload file foto jika ada
        $pathFoto = null;
        if ($request->hasFile('foto_utama')) {
            $pathFoto = $request->file('foto_utama')->store('tanaman', 'public');
        }

        // Logika otomatis menangani duplikasi slug agar tidak memicu error duplicate entry
        $slug = Str::slug($request->nama);
        $originalSlug = $slug;
        $i = 1;
        while (TanamanObat::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        // Simpan data tanaman dengan mencocokkan input form ke kolom database
        $tanaman = TanamanObat::create([
            'user_id'     => auth()->id(),
            'nama'        => $request->nama,
            'nama_ilmiah' => $request->nama_ilmiah,
            'slug'        => $slug,
            'kolektor'    => $request->kolektor,
            'asal_usul'   => $request->asal_usul,
            'deskripsi'   => $request->deskripsi,
            'khasiat'     => $request->khasiat,
            'foto'        => $pathFoto,
        ]);
    
        // Ikat banyak ID kategori ke tabel jembatan secara otomatis
        $tanaman->kategoris()->attach($request->kategori_id);
    
        // PERBAIKAN 1: Cari atau buat otomatis satu album induk bersama dengan nama 'Tanaman Obat'
        $albumInduk = \App\Models\Album::firstOrCreate(
            ['nama_album' => 'Tanaman Obat'],
            ['user_id'    => auth()->id()]
        );
    
        // PERBAIKAN 2: Jika admin melampirkan foto, masukkan langsung ke galeri dengan kolom judul dan tanggal
        if ($pathFoto) {
            \App\Models\Galeri::create([
                'album_id'   => $albumInduk->id,
                'judul'      => 'Foto ' . $tanaman->nama,
                'foto'       => $pathFoto,
                'keterangan' => 'Foto Utama Tanaman ' . $tanaman->nama,
                'tanggal'    => now(),
            ]);
        }
        
        $this->buatQrCode($tanaman);
    
        return redirect()->route('admin.tanaman.index')->with('success', 'Data Tanaman Obat Berhasil Disimpan!');
    }
    
    public function show($id)
    {
        $tanaman = TanamanObat::with('kategoris')->findOrFail($id); 
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
        // PERBAIKAN VALIDASI: Disesuaikan dengan isi form asli di image_0fdf40.png
        $request->validate([
            'kategori_ids' => 'required|array',
            'nama'         => 'required|string|max:150',
            'nama_ilmiah'  => 'required|string|max:150',
            'kolektor'     => 'required|string|max:255', // <-- TAMBAHKAN INI SINDI
            'asal_usul'    => 'required|string',          // <-- TAMBAHKAN INI SINDI
            'deskripsi'    => 'nullable|string',          // <-- UBAH JADI NULLABLE BILA BOLEH KOSONG
            'khasiat'      => 'nullable|string',          // <-- UBAH JADI NULLABLE BILA BOLEH KOSONG
            'is_favourite' => 'nullable|boolean',         // <-- UBAH JADI NULLABLE AGAR TIDAK MEMBAL ERROR
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        // Tetap menggunakan logika pemisahan array bawaan asli kamu Sindi
        $data = $request->except(['foto', '_token', '_method', 'kategori_ids']);

        // Update Slug jika nama berubah (Kodingan asli kamu jangan diganggu)
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

    public function regenerateAllQr()
    {
        $tanaman = TanamanObat::all();
        foreach ($tanaman as $t) {
            $this->buatQrCode($t);
        }
        return redirect()->route('admin.tanaman.index')->with('success', 'Seluruh QR Code berhasil diperbarui dengan domain saat ini!');
    }

    private function buatQrCode(TanamanObat $tanaman): void
    {
        // Gunakan scheme and host dari request aktif agar selalu cocok dengan domain deploy
        $baseUrl = request()->getSchemeAndHttpHost();
        
        // Fallback jika dijalankan via console/seeder (misal http://localhost)
        if (app()->runningInConsole() || empty(request()->getHost())) {
            $baseUrl = config('app.url');
        }

        $url  = rtrim($baseUrl, '/') . '/qr/' . $tanaman->slug;
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