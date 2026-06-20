<?php

namespace App\Models; // ✨ REVISI: Menambahkan alamat namespace agar Laravel bisa menemukan kelas ini

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    // ✨ REVISI: Membersihkan tanda bintang (*) dari 'nama_kategori'
    protected $fillable = ['nama_kategori', 'slug'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama_kategori);
            }
        });
    }

    public function tanamanObats()
    {
        // Parameter ke-3 adalah foreign key di tabel jembatan (kategori_id)
        // ✨ REVISI: Mengubah 'tanama_obat-*id' menjadi 'tanaman_obat_id' agar pas dengan phpMyAdmin kamu
        return $this->belongsToMany(TanamanObat::class, 'kategori_tanaman', 'kategori_id', 'tanaman_obat_id');
    }
}