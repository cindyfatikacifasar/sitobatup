<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Album extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'albums';

    // Kolom yang boleh diisi (Mass Assignment)
    // Deskripsi dihapus sesuai permintaan kamu sebelumnya
    protected $fillable = [
        'nama_album',
        'slug'
    ];

    /**
     * Boot function untuk menangani logika otomatis
     */
    protected static function boot()
    {
        parent::boot();

        // Otomatis membuat slug dari nama_album sebelum data disimpan
        static::creating(function ($album) {
            if (empty($album->slug)) {
                $album->slug = Str::slug($album->nama_album);
            }
        });

        // Update slug juga saat nama_album diubah
        static::updating(function ($album) {
            $album->slug = Str::slug($album->nama_album);
        });
    }

    /**
     * Relasi One-to-Many: Satu Album memiliki banyak Foto (Galeri)
     */
    public function galeris()
    {
        // Pastikan nama modelnya 'Galeri' dan foreign key di tabel galeris adalah 'album_id'
        return $this->hasMany(Galeri::class, 'album_id');
    }
}