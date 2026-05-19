<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeris';
        // Di dalam class Galeri
        protected $fillable = ['album_id', 'judul', 'keterangan', 'foto', 'tanggal'];
    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}