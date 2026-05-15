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
        return $this->hasMany(TanamanObat::class, 'kategori_id');
    }
}