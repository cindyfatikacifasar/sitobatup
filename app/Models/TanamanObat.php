<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanamanObat extends Model
{
    use HasFactory;

    protected $table = 'tanaman_obats';

    // Menggunakan fillable lebih aman untuk mendefinisikan kolom apa saja yang boleh diisi
    protected $fillable = [
        'nama', 
        'nama_ilmiah', 
        'deskripsi', 
        'khasiat', 
        'asal_usul', 
        'kolektor', 
        'is_favourite', 
        'slug', 
        'foto', 
        'qr_code'
    ];

    protected $casts = [
        'is_favourite' => 'boolean',
    ];

    /**
     * Relasi Many-to-Many untuk Fitur Pilihan Multi-Kategori Khasiat
     * Menggunakan tabel jembatan 'kategori_tanaman'
     */
/**
     * Relasi Many-to-Many untuk Fitur Pilihan Multi-Kategori Khasiat
     */
    public function kategoris()
    {
        // Ubah 'tanaman_obat_id' menjadi 'tanaman_id' di bawah ini
        return $this->belongsToMany(Kategori::class, 'kategori_tanaman', 'tanaman_obat_id', 'kategori_id');
    }
}