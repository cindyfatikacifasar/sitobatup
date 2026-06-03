<?php
// app/Models/Kategori.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
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
        // Parameter ke-4 adalah foreign key untuk tanaman (tanaman_id) sesuai database kamu
        return $this->belongsToMany(TanamanObat::class, 'kategori_tanaman', 'kategori_id', 'tanaman_id');
    }
}