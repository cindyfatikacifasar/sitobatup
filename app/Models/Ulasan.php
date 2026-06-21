<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasans';
    protected $fillable = ['nama','kontak','pesan','pengirim','is_read','rating','is_displayed'];
}