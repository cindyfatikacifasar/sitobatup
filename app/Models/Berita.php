<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';

    protected $fillable = [
        'judul',
        'slug',
        'penulis',
        'foto',
        'isi',
        'views',
        'is_published',
        'is_popular' 
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_popular'   => 'boolean',
    ];
}