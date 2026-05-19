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

    // Relasi Many-to-Many untuk fitur Multi-Kategori
    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'tanaman_has_kategori', 'tanaman_id', 'kategori_id');
    }

    // Relasi ke kategori utama (jika masih digunakan di tabel lama)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}