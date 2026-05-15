<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Saran extends Model
{
    protected $table = 'sarans';
    protected $fillable = ['nama','kontak','pesan','pengirim','is_read'];
}