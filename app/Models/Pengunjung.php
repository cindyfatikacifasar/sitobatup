<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    protected $table = 'pengunjungs';

    // TAMBAHKAN asal_negara DI SINI
    protected $fillable = [
        'ip_address',
        'user_agent',
        'halaman',
        'tanggal',
        'asal_negara' 
    ];

    // Opsional: Jika kamu ingin Laravel otomatis mengurus tanggal, 
    // pastikan table kamu punya kolom created_at dan updated_at.
    public $timestamps = true;
}